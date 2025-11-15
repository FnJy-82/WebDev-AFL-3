@extends('layouts.app')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-8">
                    {{-- Same fields as create, but with values --}}
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $product->name) }}" required>
                    </div>
                    {{-- Add all other fields similar to create.blade.php --}}
                </div>

                <div class="col-md-4">
                    <h5 class="mb-4">Product Image</h5>

                    @if($product->image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/products/' . $product->image) }}" class="img-fluid rounded">
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Change Image</label>
                        <input type="file" class="form-control" name="image" accept="image/*" onchange="previewImage(event)">
                    </div>

                    <div id="imagePreview" style="display: none;">
                        <img id="preview" src="" class="img-fluid rounded">
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="text-end">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-gradient">Update Product</button>
            </div>
        </form>
    </div>
</div>
@endsection
