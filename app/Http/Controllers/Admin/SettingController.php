<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $vendorApproval = Setting::boolValue('vendor_products_require_approval', true);
        return view('admin.settings.index', compact('vendorApproval'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'vendor_products_require_approval' => ['boolean'],
        ]);

        Setting::setValue(
            'vendor_products_require_approval',
            $request->boolean('vendor_products_require_approval') ? '1' : '0'
        );

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}
