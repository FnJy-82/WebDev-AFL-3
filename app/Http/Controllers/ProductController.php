php artisan make:controller<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Warehouse;
use App\Models\Supplier;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $category = $request->get('category');
        $status = $request->get('status');

        $products = Product::with(['category', 'warehouse'])
            ->when($search, function($query) use ($search) {
                $query->search($search);
            })
            ->when($category, function($query) use ($category) {
                $query->where('category_id', $category);
            })
            ->when($status, function($query) use ($status) {
                if ($status == 'low_stock') {
                    $query->lowStock();
                } elseif ($status == 'out_of_stock') {
                    $query->where('current_stock', 0);
                } elseif ($status == 'active') {
                    $query->where('is_active', true);
                }
            })
            ->latest()
            ->paginate(12);

        $categories = Category::active()->get();

        return view('products.index', compact('products', 'categories', 'search', 'category', 'status'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        $warehouses = Warehouse::active()->get();
        $suppliers = Supplier::active()->get();

        return view('products.create', compact('categories', 'warehouses', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'current_stock' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'color' => 'nullable|string|max:50',
            'size' => 'nullable|string|max:50',
            'pattern' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'suppliers' => 'nullable|array',
            'suppliers.*' => 'exists:suppliers,id',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($validated['name']) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/products', $imageName);
            $validated['image'] = $imageName;
        }

        $validated['slug'] = Str::slug($validated['name']);

        $product = Product::create($validated);

        // Attach suppliers
        if ($request->has('suppliers')) {
            $product->suppliers()->attach($request->suppliers);
        }

        ActivityLog::log('create', $product, "Created product: {$product->name}");

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'warehouse', 'suppliers', 'stockMovements' => function($query) {
            $query->with('user')->latest()->take(10);
        }]);

        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        $warehouses = Warehouse::active()->get();
        $suppliers = Supplier::active()->get();
        $product->load('suppliers');

        return view('products.edit', compact('product', 'categories', 'warehouses', 'suppliers'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'color' => 'nullable|string|max:50',
            'size' => 'nullable|string|max:50',
            'pattern' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'suppliers' => 'nullable|array',
            'suppliers.*' => 'exists:suppliers,id',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::delete('public/products/' . $product->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($validated['name']) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/products', $imageName);
            $validated['image'] = $imageName;
        }

        $validated['slug'] = Str::slug($validated['name']);

        $product->update($validated);

        // Sync suppliers
        if ($request->has('suppliers')) {
            $product->suppliers()->sync($request->suppliers);
        }

        ActivityLog::log('update', $product, "Updated product: {$product->name}");

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Delete image
        if ($product->image) {
            Storage::delete('public/products/' . $product->image);
        }

        $name = $product->name;
        $product->delete();

        ActivityLog::log('delete', $product, "Deleted product: {$name}");

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
