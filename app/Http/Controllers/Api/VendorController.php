<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Vendor::with('user:id,name,email')->active();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where('business_name', 'like', "%{$s}%");
        }

        $vendors = $query->paginate(20);

        return response()->json($vendors);
    }

    public function show(Vendor $vendor): JsonResponse
    {
        if (! $vendor->isActive()) {
            return response()->json(['message' => 'Vendor not found.'], 404);
        }

        $vendor->load('user:id,name,email');
        return response()->json($vendor);
    }

    public function update(Request $request): JsonResponse
    {
        $vendor = $request->user()->vendor;

        if (! $vendor) {
            return response()->json(['message' => 'No vendor profile found.'], 404);
        }

        $data = $request->validate([
            'business_name'      => ['sometimes', 'string', 'max:255'],
            'description'        => ['nullable', 'string'],
            'address'            => ['nullable', 'string', 'max:500'],
            'phone'              => ['nullable', 'string', 'max:20'],
            'whatsapp'           => ['nullable', 'string', 'max:20'],
            'delivery_radius_km' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        $vendor->update($data);

        return response()->json([
            'message' => 'Vendor profile updated.',
            'vendor'  => $vendor,
        ]);
    }
}
