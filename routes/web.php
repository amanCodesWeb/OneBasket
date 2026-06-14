<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Vendor\DashboardController as VendorDashboardController;
use App\Http\Controllers\Vendor\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ── Public pages ───────────────────────────────────────────────
Route::get('/',          [PageController::class, 'home'])->name('home');
Route::get('/welcome',   [PageController::class, 'welcome'])->name('welcome');

Route::get('/categories',            [PageController::class, 'categories'])->name('categories.index');
Route::get('/categories/{category:slug}', [PageController::class, 'category'])->name('categories.show');

Route::get('/products',           [PageController::class, 'products'])->name('products.index');
Route::get('/products/{slug}',    [PageController::class, 'product'])->name('products.show');

Route::get('/vendors', function () {
    $vendors = \App\Models\Vendor::active()->verified()->with('user:id,name')->get();
    return view('pages.vendors', compact('vendors'));
})->name('vendors.index');

// ── Guest (not logged in) ──────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});

// ── Authenticated ──────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Email verification
    Route::get('/email/verify', [AuthController::class, 'notice'])->name('verification.notice');
    Route::post('/email/resend', [AuthController::class, 'resend'])->name('verification.resend');
});

// ── Admin (Super Admin + Ops Manager) ──────────────────────────
Route::middleware(['auth', 'role:super_admin,ops_manager'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Vendor management
    Route::get('/vendors', [VendorController::class, 'index'])->name('vendors.index');
    Route::get('/vendors/create', [VendorController::class, 'create'])->name('vendors.create');
    Route::post('/vendors', [VendorController::class, 'store'])->name('vendors.store');
    Route::get('/vendors/{vendor}', [VendorController::class, 'show'])->name('vendors.show');
    Route::get('/vendors/{vendor}/edit', [VendorController::class, 'edit'])->name('vendors.edit');
    Route::put('/vendors/{vendor}', [VendorController::class, 'update'])->name('vendors.update');
    Route::delete('/vendors/{vendor}', [VendorController::class, 'destroy'])->name('vendors.destroy');

    // Vendor status actions
    Route::post('/vendors/{vendor}/approve', [VendorController::class, 'approve'])->name('vendors.approve');
    Route::post('/vendors/{vendor}/reject', [VendorController::class, 'reject'])->name('vendors.reject');
    Route::post('/vendors/{vendor}/suspend', [VendorController::class, 'suspend'])->name('vendors.suspend');
    Route::post('/vendors/{vendor}/activate', [VendorController::class, 'activate'])->name('vendors.activate');
});

// ── Vendor Portal (vendors only) ───────────────────────────────
Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
