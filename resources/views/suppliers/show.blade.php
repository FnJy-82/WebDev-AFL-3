@extends('layouts.app')

@section('page-title', 'Suppliers')
@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h1>Supplier Details</h1>
        </div>
        <div class="col text-end">
            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
            <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this supplier?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">{{ $supplier->name }}</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Slug:</th>
                            <td>{{ $supplier->slug }}</td>
                        </tr>
                        <tr>
                            <th>Contact Person:</th>
                            <td>{{ $supplier->contact_person }}</td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td>
                                <a href="tel:{{ $supplier->phone }}">{{ $supplier->phone }}</a>
                            </td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>
                                <a href="mailto:{{ $supplier->email }}">{{ $supplier->email }}</a>
                            </td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if($supplier->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">City:</th>
                            <td>{{ $supplier->city }}</td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td>{{ $supplier->address }}</td>
                        </tr>
                        @if($supplier->shopee_link)
                        <tr>
                            <th>Shopee Link:</th>
                            <td>
                                <a href="{{ $supplier->shopee_link }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-shop"></i> Visit Shopee Store
                                </a>
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <th>Created At:</th>
                            <td>{{ $supplier->created_at->format('M d, Y h:i A') }}</td>
                        </tr>
                        <tr>
                            <th>Updated At:</th>
                            <td>{{ $supplier->updated_at->format('M d, Y h:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
