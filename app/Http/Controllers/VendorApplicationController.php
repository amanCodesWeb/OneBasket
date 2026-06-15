<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class VendorApplicationController extends Controller
{
    public function showForm(): View
    {
        return view('pages.vendor-apply');
    }

    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'email'           => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone'           => ['required', 'string', 'max:20'],
            'business_name'   => ['required', 'string', 'max:255'],
            'address'         => ['nullable', 'string', 'max:500'],
            'description'     => ['nullable', 'string', 'max:2000'],
        ]);

        // Generate a random password — this will be shown to admin on approval
        $password = Str::random(12);

        // Create the user account
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt($password),
            'role'     => User::ROLE_VENDOR,
        ]);

        // Create the vendor record (pending)
        Vendor::create([
            'user_id'       => $user->id,
            'business_name' => $validated['business_name'],
            'slug'          => Str::slug($validated['business_name']) . '-' . Str::random(4),
            'description'   => $validated['description'],
            'address'       => $validated['address'],
            'phone'         => $validated['phone'],
            'status'        => Vendor::STATUS_PENDING,
        ]);

        return redirect()->route('home')
            ->with('success', 'Your application has been submitted successfully! We will review it and get back to you.');
    }
}
