@extends('layouts.app')

@section('title', 'Product Details')
@section('page-title', 'Product Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('products.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
        <div>
            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning text-dark">
                <i class="bi bi-pencil-square"></i> Edit Product
            </a>
            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline-block ms-2" onsubmit="return confirm('Are you sure you want to delete this product?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 card-title text-primary">
                        <i class="bi bi-info-circle me-2"></i>Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-bold">Product Name</label>
                        <h3 class="text-dark">{{ $product->name }}</h3>
                        @if($product->slug)
                            <span class="badge bg-light text-dark border">Slug: {{ $product->slug }}</span>
                        @endif
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase fw-bold">Category</label>
                            <div class="fs-5">{{ $product->category->name ?? 'Uncategorized' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase fw-bold">Warehouse</label>
                            <div class="fs-5">{{ $product->warehouse->name ?? 'No Warehouse' }}</div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-bold">Description</label>
                        <div class="p-3 bg-light rounded">
                            {{ $product->description ?: 'No description provided.' }}
                        </div>
                    </div>

                    <hr>

                    <h6 class="text-primary mb-3">Pricing & Inventory</h6>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="p-3 border rounded mb-3">
                                <label class="text-muted small">Purchase Price</label>
                                <div class="fs-5 fw-bold text-dark">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 border rounded mb-3 bg-success-subtle">
                                <label class="text-muted small">Selling Price</label>
                                <div class="fs-5 fw-bold text-success">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="text-muted small">Current Stock</label>
                            <div class="fs-5">{{ $product->current_stock }} {{ $product->unit }}</div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small">Minimum Stock</label>
                            <div class="fs-5">{{ $product->minimum_stock ?? 0 }} {{ $product->unit }}</div>
                        </div>
                        <div class="col-md-4">
                             <label class="text-muted small">Stock Status</label>
                             @if($product->current_stock <= $product->minimum_stock)
                                <div class="badge bg-danger">Low Stock</div>
                             @else
                                <div class="badge bg-success">In Stock</div>
                             @endif
                        </div>
                    </div>

                    <hr>

                    <h6 class="text-primary mb-3">Attributes & Suppliers</h6>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="text-muted small">Color</label>
                            <div>{{ $product->color ?: '-' }}</div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small">Size</label>
                            <div>{{ $product->size ?: '-' }}</div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small">Pattern</label>
                            <div>{{ $product->pattern ?: '-' }}</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small d-block mb-2">Suppliers</label>
                        @if($product->suppliers->count() > 0)
                            @foreach($product->suppliers as $supplier)
                                <a href="{{-- route('suppliers.show', $supplier) --}}#" class="badge bg-info text-decoration-none p-2 me-1">
                                    <i class="bi bi-truck"></i> {{ $supplier->name }}
                                </a>
                            @endforeach
                        @else
                            <span class="text-muted fst-italic">No suppliers linked.</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center">
                    <label class="text-muted small text-uppercase fw-bold mb-2">Status</label>
                    <div>
                        @if($product->is_active)
                            <span class="badge bg-success fs-6 px-3 py-2 rounded-pill">
                                <i class="bi bi-check-circle-fill me-1"></i> Active
                            </span>
                        @else
                            <span class="badge bg-danger fs-6 px-3 py-2 rounded-pill">
                                <i class="bi bi-x-circle-fill me-1"></i> Inactive
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 card-title text-primary">
                        <i class="bi bi-image me-2"></i>Product Image
                    </h5>
                </div>
                <div class="card-body text-center p-4">
                    @if($product->image)
                        <img src="{{ asset('storage/products/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="img-fluid rounded shadow-sm"
                             style="max-height: 300px; width: auto;">
                        <div class="mt-3">
                            <a href="{{ asset('storage/products/' . $product->image) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-zoom-in"></i> View Full Size
                            </a>
                        </div>
                    @else
                        <div class="py-5 bg-light rounded border border-dashed">
                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2 mb-0">No image uploaded</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <ul class="list-unstyled mb-0 text-muted small">
                        <li class="mb-2 d-flex justify-content-between">
                            <span>Created:</span>
                            <span class="fw-bold">{{ $product->created_at->format('d M Y, H:i') }}</span>
                        </li>
                        <li class="d-flex justify-content-between">
                            <span>Last Updated:</span>
                            <span class="fw-bold">{{ $product->updated_at->format('d M Y, H:i') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection