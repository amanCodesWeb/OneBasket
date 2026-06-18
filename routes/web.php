<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Vendor\DashboardController as VendorDashboardController;
use App\Http\Controllers\Vendor\OrderController as VendorOrderController;
use App\Http\Controllers\Vendor\ProductController as VendorProductController;
use App\Http\Controllers\Vendor\ProfileController;
use App\Http\Controllers\Vendor\AuthController as VendorAuthController;
use App\Http\Controllers\VendorApplicationController;
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

// ── Vendor Application (public) ───────────────────────────────
Route::get('/apply/vendor',  [VendorApplicationController::class, 'showForm'])->name('vendor.apply');
Route::post('/apply/vendor', [VendorApplicationController::class, 'submit'])->name('vendor.apply.submit');

// ── Admin Login (separate from public login) ───────────────────
Route::middleware('guest')->prefix('admin')->group(function () {
    Route::get('/login',  [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
});

// ── Vendor Login (separate from public login) ─────────────────
Route::middleware('guest')->prefix('vendor')->group(function () {
    Route::get('/login',  [VendorAuthController::class, 'showLogin'])->name('vendor.login');
    Route::post('/login', [VendorAuthController::class, 'login']);
});

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

    // ── Cart ──────────────────────────────────────────────────
    Route::get('/cart',        [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add',   [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/count',  [CartController::class, 'count'])->name('cart.count');
    Route::patch('/cart/{cart}',   [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}',  [CartController::class, 'remove'])->name('cart.remove');

    // ── Checkout ──────────────────────────────────────────────
    Route::get('/checkout',        [CheckoutController::class, 'review'])->name('checkout.review');
    Route::post('/checkout/place', [CheckoutController::class, 'place'])->name('checkout.place');

    // ── Orders ────────────────────────────────────────────────
    Route::get('/orders',        [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
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

    // Product management
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Order management
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');

    // Product approval
    Route::post('/products/{product}/approve', [ProductController::class, 'approve'])->name('products.approve');
    Route::post('/products/{product}/reject', [ProductController::class, 'reject'])->name('products.reject');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
});

// ── Vendor Portal (vendors only) ───────────────────────────────
Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Products
    Route::get('/products', [VendorProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [VendorProductController::class, 'create'])->name('products.create');
    Route::post('/products', [VendorProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [VendorProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [VendorProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [VendorProductController::class, 'destroy'])->name('products.destroy');

    // Orders
    Route::get('/orders', [VendorOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [VendorOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/mark-as-packed', [VendorOrderController::class, 'markAsPacked'])->name('orders.mark-as-packed');
});
