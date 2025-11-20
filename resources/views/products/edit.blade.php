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
                    <h5 class="mb-4">Product Information</h5>

                    <div class="mb-3">
                        <label class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Warehouse <span class="text-danger">*</span></label>
                            <select class="form-select @error('warehouse_id') is-invalid @enderror" name="warehouse_id" required>
                                <option value="">Select Warehouse</option>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}" {{ old('warehouse_id', $product->warehouse_id) == $warehouse->id ? 'selected' : '' }}>
                                        {{ $warehouse->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('warehouse_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Purchase Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('purchase_price') is-invalid @enderror" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}" required>
                            </div>
                            @error('purchase_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Selling Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('selling_price') is-invalid @enderror" name="selling_price" value="{{ old('selling_price', $product->selling_price) }}" required>
                            </div>
                            @error('selling_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Unit <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('unit') is-invalid @enderror" name="unit" value="{{ old('unit', $product->unit) }}" required>
                            @error('unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                   <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Current Stock <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('current_stock') is-invalid @enderror" name="current_stock" value="{{ old('current_stock', $product->current_stock) }}" required>
                            @error('current_stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Minimum Stock <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('minimum_stock') is-invalid @enderror" name="minimum_stock" value="{{ old('minimum_stock', $product->minimum_stock) }}" required>
                            @error('minimum_stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Color</label>
                            <input type="text" class="form-control @error('color') is-invalid @enderror" name="color" value="{{ old('color', $product->color) }}">
                            @error('color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Size</label>
                            <input type="text" class="form-control @error('size') is-invalid @enderror" name="size" value="{{ old('size', $product->size) }}">
                            @error('size')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Pattern (Motif)</label>
                            <input type="text" class="form-control @error('pattern') is-invalid @enderror" name="pattern" value="{{ old('pattern', $product->pattern) }}">
                            @error('pattern')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Suppliers</label>
                        <select class="form-select @error('suppliers') is-invalid @enderror" name="suppliers[]" multiple>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" 
                                    {{ collect(old('suppliers', $product->suppliers->pluck('id')))->contains($supplier->id) ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Hold Ctrl to select multiple</small>
                        @error('suppliers')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <h5 class="mb-4">Product Image</h5>

                    {{-- 1. Display Existing Image --}}
                    @if($product->image)
                        <div class="mb-3 p-3 border rounded bg-light text-center" id="currentImageContainer">
                            <label class="form-label text-muted small">Current Image</label>
                            <img src="{{ asset('storage/products/' . $product->image) }}" 
                                 class="img-fluid rounded d-block mx-auto mb-2" 
                                 style="max-height: 200px;"
                                 onerror="this.style.display='none';">
                            
                            <div class="form-check form-switch d-inline-block text-start mt-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="deleteImage" name="delete_image" value="1">
                                <label class="form-check-label text-danger" for="deleteImage">Delete this image</label>
                            </div>
                        </div>
                    @endif

                    {{-- 2. Upload New Image --}}
                    <div class="mb-3">
                        <label class="form-label">Change Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*" onchange="previewImage(event)">
                        <small class="text-muted">Max 2MB (JPG, PNG, GIF)</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- 3. Preview New Image --}}
                    <div id="imagePreview" class="border rounded p-3 text-center bg-white shadow-sm" style="display: none;">
                        <label class="form-label text-muted small">New Image Preview</label>
                        <img id="preview" src="" class="img-fluid rounded" style="max-height: 300px;">
                    </div>

                    <div class="form-check mb-3 mt-3">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} id="isActive">
                        <label class="form-check-label" for="isActive">
                            Active Product
                        </label>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="text-end">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
                <button type="submit" class="btn btn-gradient">
                    <i class="bi bi-save"></i> Update Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('imagePreview');
        const currentImageContainer = document.getElementById('currentImageContainer');
        const deleteCheckbox = document.getElementById('deleteImage');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewContainer.style.display = 'block';
                document.getElementById('preview').src = e.target.result;
                
                // If we select a new image, we can hide the "Delete" checkbox because
                // the new image will replace the old one anyway.
                if(deleteCheckbox) {
                    deleteCheckbox.checked = false;
                    deleteCheckbox.disabled = true;
                    if(currentImageContainer) currentImageContainer.style.opacity = '0.5';
                }
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush