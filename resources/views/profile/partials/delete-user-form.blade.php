@extends('layouts.app')

@section('title', 'Delete Account')
@section('page-title', 'Delete Account')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('profile.edit') }}">Profile</a></li>
    <li class="breadcrumb-item active">Delete</li>
@endsection

@section('content')
<div class="card border-danger shadow-sm" style="max-width: 600px;">
    <div class="card-header bg-danger text-white">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> Danger Zone
    </div>
    <div class="card-body p-4">
        <h5 class="card-title text-danger">{{ __('Are you sure you want to delete your account?') }}</h5>
        <p class="card-text text-muted mb-4">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>

        <!-- Bootstrap Modal Trigger Button -->
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
            {{ __('Delete Account') }}
        </button>
    </div>
</div>

<!-- Bootstrap Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">
                        <i class="bi bi-exclamation-circle me-2"></i> {{ __('Confirm Deletion') }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <p class="fw-bold text-danger">
                        {{ __('Are you sure you want to delete your account?') }}
                    </p>
                    <p class="text-muted small">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>
                    
                    <div class="mb-3 mt-4">
                        <label for="password" class="form-label visually-hidden">{{ __('Password') }}</label>
                        <input type="password" 
                               class="form-control @if($errors->userDeletion->has('password')) is-invalid @endif" 
                               id="password" 
                               name="password" 
                               placeholder="Enter your password to confirm" 
                               required>
                        
                        <!-- Display Errors specifically for this bag -->
                        @if($errors->userDeletion->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->userDeletion->first('password') }}
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-danger">{{ __('Delete Account') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script to Auto-Open Modal if Password was Wrong -->
@if($errors->userDeletion->isNotEmpty())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check window.bootstrap to avoid ReferenceError
            var bs = window.bootstrap;
            
            if (bs) {
                var myModal = new bs.Modal(document.getElementById('confirmDeleteModal'));
                myModal.show();
            } else {
                console.warn('Bootstrap JS not detected on window.bootstrap. Ensure your layout loads bootstrap.js bundle.');
            }
        });
    </script>
@endif

@endsection