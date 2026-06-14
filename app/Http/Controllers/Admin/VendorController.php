<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;

class VendorController extends Controller
{
    public function index(Request $request): View
    {
        $query = Vendor::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('business_name', 'like', "%{$s}%")
                  ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$s}%"));
            });
        }

        $vendors = $query->latest()->paginate(15);
        $statuses = Vendor::$statuses;

        return view('admin.vendors.index', compact('vendors', 'statuses'));
    }

    public function create(): View
    {
        $statuses = Vendor::$statuses;
        $users = User::whereDoesntHave('vendor')
            ->whereIn('role', [User::ROLE_VENDOR, User::ROLE_SUPER_ADMIN, User::ROLE_OPS_MANAGER])
            ->get();
        return view('admin.vendors.form', compact('statuses', 'users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id'            => ['required', 'exists:users,id'],
            'business_name'      => ['required', 'string', 'max:255'],
            'description'        => ['nullable', 'string'],
            'address'            => ['nullable', 'string', 'max:500'],
            'phone'              => ['nullable', 'string', 'max:20'],
            'whatsapp'           => ['nullable', 'string', 'max:20'],
            'status'             => ['required', Rule::in(Vendor::$statuses)],
            'delivery_radius_km' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'commission_rate'    => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        $data['slug'] = Str::slug($data['business_name']) . '-' . Str::random(4);

        Vendor::create($data);

        return redirect()->route('admin.vendors.index')
            ->with('success', 'Vendor created successfully.');
    }

    public function show(Vendor $vendor): View
    {
        $vendor->load('user');
        return view('admin.vendors.show', compact('vendor'));
    }

    public function edit(Vendor $vendor): View
    {
        $statuses = Vendor::$statuses;
        return view('admin.vendors.form', compact('vendor', 'statuses'));
    }

    public function update(Request $request, Vendor $vendor): RedirectResponse
    {
        $data = $request->validate([
            'business_name'      => ['required', 'string', 'max:255'],
            'description'        => ['nullable', 'string'],
            'address'            => ['nullable', 'string', 'max:500'],
            'phone'              => ['nullable', 'string', 'max:20'],
            'whatsapp'           => ['nullable', 'string', 'max:20'],
            'status'             => ['required', Rule::in(Vendor::$statuses)],
            'delivery_radius_km' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'commission_rate'    => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        $vendor->update($data);

        return redirect()->route('admin.vendors.index')
            ->with('success', 'Vendor updated successfully.');
    }

    public function destroy(Vendor $vendor): RedirectResponse
    {
        $vendor->delete();
        return redirect()->route('admin.vendors.index')
            ->with('success', 'Vendor deleted.');
    }

    // ── Status actions ──────────────────────────────────────────

    public function approve(Vendor $vendor): RedirectResponse
    {
        $vendor->update([
            'status'      => Vendor::STATUS_ACTIVE,
            'verified_at' => now(),
        ]);

        return back()->with('success', 'Vendor approved and verified.');
    }

    public function reject(Vendor $vendor): RedirectResponse
    {
        $vendor->update(['status' => Vendor::STATUS_REJECTED]);
        return back()->with('success', 'Vendor rejected.');
    }

    public function suspend(Vendor $vendor): RedirectResponse
    {
        $vendor->update(['status' => Vendor::STATUS_SUSPENDED]);
        return back()->with('success', 'Vendor suspended.');
    }

    public function activate(Vendor $vendor): RedirectResponse
    {
        $vendor->update(['status' => Vendor::STATUS_ACTIVE]);
        return back()->with('success', 'Vendor activated.');
    }
}
