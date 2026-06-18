@extends('layouts.admin')

@section('title', 'Settings')
@section('heading', 'Settings')

@section('content')
    <div class="max-w-2xl animate-fade-in">
        <form method="POST" action="{{ route('admin.settings.update') }}"
              class="bg-white dark:bg-gray-800/80 rounded-xl border border-gray-200 dark:border-gray-700/80 shadow-sm p-6">
            @csrf

            <div class="flex items-center justify-between p-4 rounded-xl bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700/60">
                <div class="flex-1 min-w-0">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Vendor Products Require Approval</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        When enabled, products added by vendors must be approved by an admin before they appear in the public listings.
                        When disabled, vendor products go live immediately.
                    </p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer ml-4 shrink-0">
                    <input type="hidden" name="vendor_products_require_approval" value="0">
                    <input type="checkbox" name="vendor_products_require_approval" value="1"
                           class="sr-only peer"
                           {{ $vendorApproval ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary-500 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                </label>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-500 hover:to-primary-600 text-white text-sm font-medium shadow-sm hover:shadow-md transition-all duration-200">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
@endsection
