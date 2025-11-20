@extends('layouts.app')

@section('title', 'Home')
@section('content')

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg">
                    <h1 class="display-4 fw-bold mb-4">Pusat Distribusi Batik & Sarung Terpercaya</h1>
                    <p class="lead mb-4">Menghubungkan pengrajin batik lokal dengan pasar yang lebih luas melalui sistem
                        warehouse modern di Surabaya.</p>
                    {{-- <a href="{{ route('warehouse') }}" class="btn btn-light btn-lg me-3">
                    <i class="fas fa-info-circle me-2"></i>Pelajari Lebih
                </a>
                @auth
                    <a href="{{ route('suppliers.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-handshake me-2"></i>Lihat Supplier
                    </a>
                @endauth --}}
                </div>
            </div>
        </div>
    </section>

    <!-- Warehouse Info -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4">
                    <img src="images\warehouse\warehouselogo.jpg" alt="{{ $warehouse->name }}"
                        class="img-fluid rounded shadow">
                </div>
                <div class="col-lg-8">
                    <h1 class="fw-bold mb-3">{{ $warehouse->name }}</h1>
                    <p class="text-muted mb-4">{{ $warehouse->description }}</p>
                    <div class="row">
                        <div class="col-md-6">
                            <p><i class="fas fa-map-marker-alt me-2"></i> {{ $warehouse->address }}, {{ $warehouse->city }},
                                {{ $warehouse->province }}</p>
                        </div>
                    </div>
                </div>
    </section>

@endsection
