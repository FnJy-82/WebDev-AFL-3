<!-- resources/views/shipping-partners.blade.php -->
@extends('layouts.app')

@section('title', 'Partner Pengiriman')
@section('content')

<div class="container mt-5 pt-4">
    <div class="row mb-5">
        <div class="col text-center">
            <h1 class="fw-bold">Partner Pengiriman</h1>
            <p class="lead text-muted">Didukung oleh jasa pengiriman terpercaya untuk melayani seluruh Indonesia</p>
        </div>
    </div>

    <div class="row">
        @foreach($shippingPartners as $partner)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" class="img-fluid mb-4" style="max-height: 80px;">
                    <h4 class="card-title">{{ $partner->name }}</h4>
                    <p class="darkred fw-semibold">{{ $partner->service_type }}</p>

                    <div class="coverage-areas mb-3">
                        <h6 class="text-muted">Cakupan Pengiriman:</h6>
                        @foreach($partner->coverage_list as $area)
                        <span class="badge bg-light text-dark me-1 mb-1">{{ trim($area) }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <div class="card darkredBg text-white">
                <div class="card-body text-center p-4">
                    <h3 class="card-title">Layanan Pengiriman Terintegrasi</h3>
                    <p class="card-text">Kami memastikan produk batik Anda sampai dengan aman dan tepat waktu ke seluruh penjuru Indonesia.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
