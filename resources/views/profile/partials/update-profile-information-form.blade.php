@extends('layouts.app')
@section('title', 'Edit Profile')
@section('page-title', 'Edit Profile Information')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('profile.edit') }}">Profile</a></li>
    <li class="breadcrumb-item active">Information</li>
@endsection

@section('content')
<div class="card border-0 shadow-sm" style="max-width: 600px;">
    <div class="card-body p-4">
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="mb-3">
                <label for="name" class="form-label">{{ __('Name') }}</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required autofocus autocomplete="name">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required autocomplete="username">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! Auth::user()->hasVerifiedEmail())
                    <div class="mt-2">
                        <p class="text-muted small mb-1">{{ __('Your email address is unverified.') }}</p>
                        <button form="send-verification" class="btn btn-link p-0 text-decoration-none small">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>

                        @if (session('status') === 'verification-link-sent')
                            <p class="text-success small mt-2">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="d-flex align-items-center gap-3">
                <button type="submit" class="btn btn-primary btn-gradient">{{ __('Save Changes') }}</button>
                @if (session('status') === 'profile-updated')
                    <span class="text-success small"><i class="bi bi-check-circle"></i> {{ __('Saved.') }}</span>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection