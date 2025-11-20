@extends('layouts.app')

@section('title', 'Profile Settings')
@section('page-title', 'Profile Settings')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Profile</li>
@endsection

@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <div class="stat-icon bg-primary text-white mx-auto mb-3 rounded-circle" style="width: 64px; height: 64px;">
                    <i class="bi bi-person-vcard fs-3"></i>
                </div>
                <h5 class="card-title">Profile Information</h5>
                <p class="text-muted small">Update your account's profile information and email address.</p>
                
                <div class="text-start bg-light p-3 rounded mb-3">
                    <small class="d-block text-muted">Name</small>
                    <div class="fw-bold text-dark mb-2">{{ $user->name }}</div>
                    
                    <small class="d-block text-muted">Email</small>
                    <div class="fw-bold text-dark">{{ $user->email }}</div>
                </div>

                <a href="{{ route('profile.partials.info') }}" class="btn btn-outline-primary w-100">
                    <i class="bi bi-pencil-square me-1"></i> Edit Information
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <div class="stat-icon bg-warning text-white mx-auto mb-3 rounded-circle" style="width: 64px; height: 64px;">
                    <i class="bi bi-shield-lock fs-3"></i>
                </div>
                <h5 class="card-title">Security</h5>
                <p class="text-muted small">Ensure your account is using a long, random password to stay secure.</p>
                
                <div class="text-start bg-light p-3 rounded mb-3">
                    <small class="d-block text-muted">Password</small>
                    <div class="fw-bold text-dark">••••••••••••</div>
                </div>

                <a href="{{ route('profile.partials.password') }}" class="btn btn-outline-warning w-100 text-dark">
                    <i class="bi bi-key me-1"></i> Change Password
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <div class="stat-icon bg-danger text-white mx-auto mb-3 rounded-circle" style="width: 64px; height: 64px;">
                    <i class="bi bi-exclamation-triangle fs-3"></i>
                </div>
                <h5 class="card-title">Delete Account</h5>
                <p class="text-muted small">Permanently delete your account and all associated data.</p>
                
                <div class="alert alert-danger bg-danger-subtle border-0 text-danger small mb-3">
                    <i class="bi bi-info-circle me-1"></i> This action is irreversible.
                </div>

                <a href="{{ route('profile.partials.delete') }}" class="btn btn-outline-danger w-100">
                    <i class="bi bi-trash me-1"></i> Delete Account
                </a>
            </div>
        </div>
    </div>
</div>
@endsection