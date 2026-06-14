<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $vendor = auth()->user()->vendor;
        return view('vendor.dashboard', compact('vendor'));
    }
}
