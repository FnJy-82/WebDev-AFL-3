@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <!-- Hero Section -->
    <section class="hero-section text-white" style="background: linear-gradient(to right, #4e54c8, #8f94fb); padding: 100px 0;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-4">Pusat Distribusi Batik & Sarung Terpercaya</h1>
                    <p class="lead mb-5">Menghubungkan pengrajin batik lokal dengan pasar yang lebih luas melalui sistem
                        warehouse modern di Surabaya.</p>
                    {{-- Uncomment jika ingin menampilkan tombol
                    <a href="{{ route('warehouse') }}" class="btn btn-light btn-lg me-3 shadow-sm">
                        <i class="bi bi-info-circle me-2"></i>Pelajari Lebih
                    </a>
                    @auth
                        <a href="{{ route('suppliers.index') }}" class="btn btn-outline-light btn-lg">
                            <i class="bi bi-people me-2"></i>Lihat Supplier
                        </a>
                    @endauth 
                    --}}
                </div>
            </div>
        </div>
    </section>

    <!-- Warehouse Info -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <div class="position-relative">
                        <!-- Pastikan path gambar menggunakan forward slash (/) -->
                        <img src="{{ asset('images/warehouse/warehouselogo.jpg') }}" alt="{{ $warehouse->name }}"
                            class="img-fluid rounded-4 shadow-lg">
                    </div>
                </div>
                <div class="col-lg-7 ps-lg-5">
                    <span class="badge bg-primary mb-2">Tentang Kami</span>
                    <h2 class="fw-bold mb-3">{{ $warehouse->name }}</h2>
                    <p class="text-muted mb-4 lead" style="line-height: 1.8;">{{ $warehouse->description }}</p>
                    
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 btn-lg-square rounded-circle bg-light text-primary d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="bi bi-geo-alt-fill fs-4"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold">Lokasi Strategis</h6>
                            <p class="mb-0 text-muted">{{ $warehouse->address }}, {{ $warehouse->city }}, {{ $warehouse->province }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Visi & Misi Section (BARU) -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Visi & Misi Kami</h2>
                <p class="text-muted">Komitmen kami untuk kemajuan industri tekstil nusantara</p>
            </div>

            <!-- Visi Card -->
            <div class="row justify-content-center mb-5">
                <div class="col-lg-10">
                    <div class="card border-0 shadow-sm text-center p-4 rounded-4 bg-white">
                        <div class="card-body">
                            <div class="mb-3 text-primary">
                                <i class="bi bi-eye fs-1"></i>
                            </div>
                            <h3 class="fw-bold text-primary mb-3">Visi</h3>
                            <p class="lead fst-italic text-dark mb-0">
                                "Menjadi pusat distribusi dan penyimpanan terpercaya untuk produk batik dan sarung lokal, yang mendorong kemajuan industri tekstil tradisional Indonesia melalui efisiensi, kolaborasi, dan inovasi logistik."
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Misi Grid -->
            <div class="row g-4">
                <div class="col-12 text-center mb-2">
                    <h3 class="fw-bold text-secondary">Misi</h3>
                </div>

                <!-- Misi 1 -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 hover-shadow transition">
                        <div class="card-body text-center p-4">
                            <div class="mb-3 text-success">
                                <i class="bi bi-people-fill fs-2"></i>
                            </div>
                            <h6 class="fw-bold">Pemberdayaan</h6>
                            <p class="text-muted small mb-0">
                                Memberdayakan pengrajin dan produsen kecil dari berbagai daerah untuk menjangkau pasar yang lebih luas.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Misi 2 -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 hover-shadow transition">
                        <div class="card-body text-center p-4">
                            <div class="mb-3 text-info">
                                <i class="bi bi-building-fill-gear fs-2"></i>
                            </div>
                            <h6 class="fw-bold">Sistem Modern</h6>
                            <p class="text-muted small mb-0">
                                Menyediakan sistem penyimpanan dan distribusi yang efisien, modern, dan berlokasi strategis di Surabaya.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Misi 3 -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 hover-shadow transition">
                        <div class="card-body text-center p-4">
                            <div class="mb-3 text-warning">
                                <i class="bi bi-building-fill-gear fs-2"></i>
                            </div>
                            <h6 class="fw-bold">Kemitraan</h6>
                            <p class="text-muted small mb-0">
                                Menjalin kemitraan berkelanjutan dengan para seller untuk memperkuat rantai pasok produk batik dan sarung.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Misi 4 -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 hover-shadow transition">
                        <div class="card-body text-center p-4">
                            <div class="mb-3 text-danger">
                                <i class="bi bi-award-fill fs-2"></i>
                            </div>
                            <h6 class="fw-bold">Kualitas & Budaya</h6>
                            <p class="text-muted small mb-0">
                                Menjaga kualitas dan keaslian setiap produk sebagai wujud pelestarian warisan budaya Indonesia.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection