<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'  => User::count(),
            'total_admins' => User::whereIn('role', [User::ROLE_SUPER_ADMIN, User::ROLE_OPS_MANAGER])->count(),
            'total_vendors' => User::where('role', User::ROLE_VENDOR)->count(),
            'total_customers' => User::where('role', User::ROLE_CUSTOMER)->count(),
        ];

        return view('pages.dashboard.admin', compact('stats'));
    }
}
