<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }
    public function updateProfileInformationForm(): View
    {
        return view('profile.partials.update-profile-information-form', ['user' => request()->user()->fresh() ]);
    }
    public function updatePasswordForm(): View
    {
        return view('profile.partials.update-password-form', ['user' => request()->user()->fresh() ]);
    }
    public function deleteUserForm(): View
    {
        return view('profile.partials.delete-user-form', ['user' => request()->user() ]);
    }
    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.partials.info')->with('status', 'profile-updated');
    }

    /**
     * Deactivate the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        Auth::user()->forceFill([
            'is_active' => false, // Set to inactive
        ])->save();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function updatePassword(Request $request): RedirectResponse // Or updatePassword depending on your naming
    {
        // 1. Validate the input
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        // 2. Update the Password
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        // 3. LOGOUT THE USER
        Auth::logout();

        // 4. Invalidate the session (Standard Laravel Security)
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 5. Redirect to Login Page with a specific 'status' flag
        return redirect()->route('login')->with('status', 'password-updated');
    }
}
