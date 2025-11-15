@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">Total Products</p>
                    <h3 class="mb-0">{{ $totalProducts }}</h3>
                </div>
                <div class="stat-icon" style="background: #e0e7ff; color: #4f46e5;">
                    <i class="bi bi-box"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">Low Stock Items</p>
                    <h3 class="mb-0 text-warning">{{ $lowStockProducts }}</h3>
                </div>
                <div class="stat-icon" style="background: #fef3c7; color: #f59e0b;">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">Today Stock In</p>
                    <h3 class="mb-0 text-success">{{ $todayStockIn }}</h3>
                </div>
                <div class="stat-icon" style="background: #d1fae5; color: #10b981;">
                    <i class="bi bi-arrow-down-circle"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">Today Stock Out</p>
                    <h3 class="mb-0 text-danger">{{ $todayStockOut }}</h3>
                </div>
                <div class="stat-icon" style="background: #fee2e2; color: #ef4444;">
                    <i class="bi bi-arrow-up-circle"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart -->
<div class="row mb-4">
    <div class="col-lg-8">
        <div class="stat-card">
            <h5 class="mb-4">Stock Movement (Last 7 Days)</h5>
            <canvas id="stockChart" height="80"></canvas>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="stat-card">
            <h5 class="mb-4">Low Stock Alerts</h5>
            @forelse($activeAlerts->take(5) as $alert)
                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                    <div class="stat-icon me-3" style="background: #fee2e2; color: #ef4444; width: 40px; height: 40px; font-size: 1rem;">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="mb-0 fw-bold">{{ $alert->product->name }}</p>
                        <small class="text-muted">Stock: {{ $alert->current_stock }} / Min: {{ $alert->threshold }}</small>
                    </div>
                </div>
            @empty
                <p class="text-muted text-center py-3">No alerts</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="stat-card">
            <h5 class="mb-4">Recent Stock In</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Supplier</th>
                            <th>Qty</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentStockIns as $stockIn)
                            <tr>
                                <td>{{ $stockIn->product->name }}</td>
                                <td>{{ $stockIn->supplier->name }}</td>
                                <td><span class="badge bg-success">+{{ $stockIn->quantity }}</span></td>
                                <td>{{ $stockIn->transaction_date->format('d M') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">No data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="stat-card">
            <h5 class="mb-4">Recent Stock Out</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Customer</th>
                            <th>Qty</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentStockOuts as $stockOut)
                            <tr>
                                <td>{{ $stockOut->product->name }}</td>
                                <td>{{ Str::limit($stockOut->customer_name, 20) }}</td>
                                <td><span class="badge bg-danger">-{{ $stockOut->quantity }}</span></td>
                                <td>{{ $stockOut->transaction_date->format('d M') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">No data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('stockChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($last7Days->pluck('date')) !!},
            datasets: [
                {
                    label: 'Stock In',
                    data: {!! json_encode($last7Days->pluck('stock_in')) !!},
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4
                },
                {
                    label: 'Stock Out',
                    data: {!! json_encode($last7Days->pluck('stock_out')) !!},
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endpush
