<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $vendor = auth()->user()->vendor;
        return view('vendor.profile.edit', compact('vendor'));
    }

    public function update(Request $request): RedirectResponse
    {
        $vendor = auth()->user()->vendor;

        $data = $request->validate([
            'business_name'      => ['required', 'string', 'max:255'],
            'description'        => ['nullable', 'string'],
            'address'            => ['nullable', 'string', 'max:500'],
            'phone'              => ['nullable', 'string', 'max:20'],
            'whatsapp'           => ['nullable', 'string', 'max:20'],
            'delivery_radius_km' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        $vendor->update($data);

        return back()->with('success', 'Profile updated successfully.');
    }
}
