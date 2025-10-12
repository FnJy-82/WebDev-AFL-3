@extends('layouts.app')

@section('title', 'Gudang Kami')
@section('content')

<div class="container mt-5 pt-4">
    <div class="row mb-5">
        <div class="col text-center">
            <h1 class="fw-bold">Allstock Warehouse</h1>
            <p class="lead text-muted">Pusat distribusi modern di Surabaya</p>
        </div>
    </div>

    <!-- Warehouse Overview -->
    <div class="row mb-5 d-flex align-items-center">
        <div class="col-lg-4 mb-4">
            <img src="{{ $warehouse->logo_url }}" alt="{{ $warehouse->name }}" class="img-fluid rounded shadow">
        </div>
        <div class="col-lg-8">
            <p class="text-muted mb-4">{{ $warehouse->description }}</p>
            <div class="row">
                <div class="col-md-6">
                    <p><i class="fas fa-map-marker-alt darkred me-2"></i> <strong>Alamat:</strong><br>{{ $warehouse->full_address }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Vision -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card darkredBg text-white">
                <div class="card-body p-4">
                    <h3 class="card-title mb-3"><i class="fas fa-bullseye me-2"></i>Visi Kami</h3>
                    <p class="card-text mb-0">{{ $warehouse->vision }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Missions -->
    <div class="row">
        <div class="col-12">
            <h3 class="fw-bold mb-4 text-center">Misi Kami</h3>
            <div class="row">
                @foreach($warehouse->missions as $index => $mission)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="mission-item">
                                <h5 class="fw-bold">Misi {{ $index + 1 }}</h5>
                                <p class="text-muted">{{ $mission }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
