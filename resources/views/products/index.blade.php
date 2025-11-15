@extends('layouts.app')

@section('title', 'Products')
@section('page-title', 'Products')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Products</li>
@endsection

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-8">
                <form action="{{ route('products.index') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="search" placeholder="Search product..." value="{{ $search }}">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="category">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $category == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="status">
                            <option value="">All Status</option>
                            <option value="low_stock" {{ $status == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                            <option value="out_of_stock" {{ $status == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                            <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('products.create') }}" class="btn btn-gradient">
                    <i class="bi bi-plus-circle"></i> Add Product
                </a>
            </div>
        </div>

        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        @if($product->image)
                            <img src="{{ asset('storage/products/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h6 class="card-title mb-2">{{ $product->name }}</h6>
                            <p class="text-muted small mb-2">
                                <i class="bi bi-tag"></i> {{ $product->category->name }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted small">SKU:</span>
                                <code>{{ $product->sku }}</code>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted small">Stock:</span>
                                @if($product->current_stock == 0)
                                    <span class="badge bg-danger">Out of Stock</span>
                                @elseif($product->is_low_stock)
                                    <span class="badge bg-warning text-dark">{{ $product->current_stock }} (Low)</span>
                                @else
                                    <span class="badge bg-success">{{ $product->current_stock }}</span>
                                @endif
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted small">Price:</span>
                                <strong class="text-primary">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</strong>
                            </div>
                            <div class="btn-group w-100" role="group">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this product?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle"></i> No products found.
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
