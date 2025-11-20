@extends('layouts.app')
@section('title', 'Security')
@section('page-title', 'Update Password')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('profile.edit') }}">Profile</a></li>
    <li class="breadcrumb-item active">Security</li>
@endsection

@section('content')
<div class="card border-0 shadow-sm" style="max-width: 600px;">
    <div>
        <form method="post" action="{{ route('profile.password.custom_update') }}" class="mt-6 space-y-6">
            @csrf
            @method('put')

            <div class="mb-3">
                <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
                <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" id="current_password" name="current_password" autocomplete="current-password">
                @error('current_password', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">{{ __('New Password') }}</label>
                <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" id="password" name="password" autocomplete="new-password">
                @error('password', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                <input type="password" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                @error('password_confirmation', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex align-items-center gap-3">
                <button type="submit" class="btn btn-warning">{{ __('Update Password') }}</button>
                @if (session('status') === 'password-updated')
                    <span class="text-success small"><i class="bi bi-check-circle"></i> {{ __('Saved.') }}</span>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection