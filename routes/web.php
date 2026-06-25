<?php

use Illuminate\Support\Facades\Route;

// ============================================================
// FRONTEND ROUTES — served by dedicated controllers so all
// pages pull real data from the database.
// ============================================================
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PartsController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Auth\LoginController;

// Home Page — loads featured products, categories, latest blogs
Route::get('/', [HomeController::class, 'index']);

// Lead Inquiry Form Submission
Route::post('/inquiry', [HomeController::class, 'submitInquiry'])->name('inquiry.submit');

// Cart Flow
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout Flow
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('checkout.store');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

// About Us — static content page, no DB queries needed
Route::get('/about', function () {
    return view('frontend.about');
});

// Contact Us — static content page
Route::get('/contact', function () {
    return view('frontend.contact');
});
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');

// Policy Pages — placeholder views to be filled with user content
Route::get('/privacy-policy', function () {
    return view('frontend.privacy-policy');
});
Route::get('/return-refund', function () {
    return view('frontend.return-refund');
});
Route::get('/terms-conditions', function () {
    return view('frontend.terms-conditions');
});
Route::get('/warranty-policy', function () {
    return view('frontend.warranty-policy');
});

// Parts Catalog — supports ?category, ?make, ?part_name, ?sort, ?min_price, ?max_price filters
Route::get('/parts', [PartsController::class, 'index']);

// Part Details — slug-based clean URL: /parts/{slug}
Route::get('/parts/{slug}', [PartsController::class, 'show'])->name('parts.show');

// Legacy route kept for backward-compatibility (old static URL)
Route::redirect('/part-details', '/parts');

// Blog Listing — supports ?category and ?q search filters
Route::get('/blog', [BlogController::class, 'index']);

// Blog Post Detail — slug-based clean URL: /blog/{slug}
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Legacy route kept for backward-compatibility
Route::redirect('/blog-details', '/blog');

// ==========================================
// AUTHENTICATION ROUTES
// ==========================================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ==========================================
// ADMIN DASHBOARD ROUTES
// ==========================================

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\SettingController;

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // Main Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Product Management CRUD
    Route::resource('products', AdminProductController::class);
    Route::post('products/bulk-delete', [AdminProductController::class, 'bulkDelete'])->name('products.bulk-delete');
    Route::post('products/import', [AdminProductController::class, 'importCsv'])->name('products.import');
    Route::get('products/export/csv', [AdminProductController::class, 'exportCsv'])->name('products.export');

    // Category Management CRUD
    Route::resource('categories', AdminCategoryController::class);

    // Blog Management CRUD
    Route::resource('blogs', AdminBlogController::class);

    // SEO Settings Page
    Route::get('seo', [SeoController::class, 'index'])->name('seo.index');
    Route::post('seo/update', [SeoController::class, 'update'])->name('seo.update');

    // Payments Manager Page
    Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::post('payments/update', [PaymentController::class, 'update'])->name('payments.update');

    // Order Management
    Route::resource('orders', OrderController::class);
    Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
    Route::get('orders/{order}/invoice', [OrderController::class, 'downloadInvoice'])->name('orders.invoice');

    // Lead / Contact Forms Management
    Route::get('leads', [LeadController::class, 'index'])->name('leads.index');
    Route::post('leads/{lead}/read', [LeadController::class, 'markRead'])->name('leads.read');
    Route::delete('leads/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');

    // Global Settings Page
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings/update', [SettingController::class, 'update'])->name('settings.update');
});

