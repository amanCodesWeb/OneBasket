<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'      => User::count(),
            'total_admins'     => User::whereIn('role', [User::ROLE_SUPER_ADMIN, User::ROLE_OPS_MANAGER])->count(),
            'total_vendors'    => User::where('role', User::ROLE_VENDOR)->count(),
            'total_customers'  => User::where('role', User::ROLE_CUSTOMER)->count(),
            'total_products'   => Product::count(),
            'active_products'  => Product::where('status', 'active')->count(),
            'total_businesses' => Vendor::count(),
            'pending_vendors'  => Vendor::where('status', 'pending')->count(),
        ];

        return view('pages.dashboard.admin', compact('stats'));
    }
}
