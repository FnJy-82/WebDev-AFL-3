@extends('layouts.app')

@section('page-title', 'Supplier')
@section('content')

<div class="container mt-5 pt-4">
    <div class="row mb-5">
        <div class="col text-center">
            <h1 class="fw-bold">Supplier Kami</h1>
            <p class="lead text-muted">Bekerja sama dengan pengrajin batik terbaik dari berbagai daerah</p>
        </div>
    </div>

    <div class="row">
        @foreach($suppliers as $supplier)
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="card-title">{{ $supplier->name }}</h4>

                    @if($supplier->shopee_link)
                    <div class="mt-3">
                        <a href="{{ $supplier->shopee_link }}" target="_blank"
                            class="btn-gradient p-2 text-decoration-none rounded-2 d-inline-flex align-items-center justify-content-center">
                            <i class="fas fa-store me-2"></i>
                            <span>Visit Shopee</span>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <div class="card bg-light">
                <div class="card-body text-center p-5">
                    <h3 class="card-title">Ingin Menjadi Supplier Kami?</h3>
                    <p class="card-text text-muted">Kami selalu terbuka untuk bekerja sama dengan pengrajin batik dan produsen sarung berkualitas.</p>
                    <button class="btn-gradient p-2 text-decoration-none rounded-2 d-inline-flex align-items-center justify-content-center">Hubungi Kami</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
