<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponsCodeController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ThanksController;
use App\Http\Controllers\UserauthController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistsController;
use App\Http\Controllers\UserDetailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/* Login */

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])
->name('admin.login');

// Show registration form
Route::get('/admin/register', [AdminAuthController::class, 'showRegister'])->name('admin.register');

// Submit registration
Route::post('/admin/register', [AdminAuthController::class, 'register'])->name('admin.register.submit');

Route::post('/login', [AdminAuthController::class, 'login'])
    ->name('login.submit');

Route::post('/logout', [AdminAuthController::class, 'logout'])
    ->name('logout');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'admin'])
    ->name('admin.dashboard');

Route::prefix('admin')->name('admin.')->group(function () {

    // categories routes

    Route::get('categories', [CategoryController::class, 'index'])
        ->name('categories.index');

    Route::get('categories/create', [CategoryController::class, 'create'])
        ->name('categories.create');

    Route::post('categories', [CategoryController::class, 'store'])
        ->name('categories.store');

    Route::get('categories/{id}/edit', [CategoryController::class, 'edit'])
        ->name('categories.edit');

    Route::put('categories/{id}', [CategoryController::class, 'update'])
        ->name('categories.update');

    Route::delete('categories/{id}', [CategoryController::class, 'destroy'])
        ->name('categories.destroy');

    // sub-category routes

    Route::get('sub-categories', [SubCategoryController::class, 'index'])
        ->name('sub-categories.index');

    Route::get('sub-categories/create', [SubCategoryController::class, 'create'])
        ->name('sub-categories.create');

    Route::post('sub-categories', [SubCategoryController::class, 'store'])
        ->name('sub-categories.store');

    Route::get('sub-categories/{id}/edit', [SubCategoryController::class, 'edit'])
        ->name('sub-categories.edit');

    Route::put('sub-categories/{id}', [SubCategoryController::class, 'update'])
        ->name('sub-categories.update');

    Route::delete('sub-categories/{id}', [SubCategoryController::class, 'destroy'])
        ->name('sub-categories.destroy');

    // Brands routes

    Route::get('brands', [BrandsController::class, 'index'])
        ->name('brands.index');

    Route::get('brands/create', [BrandsController::class, 'create'])
        ->name('brands.create');

    Route::post('brands', [BrandsController::class, 'store'])
        ->name('brands.store');

    Route::get('brands/{id}/edit', [BrandsController::class, 'edit'])
        ->name('brands.edit');

    Route::put('brands/{id}', [BrandsController::class, 'update'])
        ->name('brands.update');

    Route::delete('brands/{id}', [BrandsController::class, 'destroy'])
        ->name('brands.destroy');

    // products routes

    // Product Routes
    Route::get('products', [ProductsController::class, 'index'])->name('products.index');
    Route::get('products/create', [ProductsController::class, 'create'])->name('products.create');
    Route::post('products', [ProductsController::class, 'store'])->name('products.store');
    Route::get('products/{id}/edit', [ProductsController::class, 'edit'])->name('products.edit');
    Route::put('products/{id}', [ProductsController::class, 'update'])->name('products.update');
    Route::delete('products/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');

    // Image Upload (Dropzone)
    Route::post('products/upload-image', [ProductsController::class, 'uploadImage'])->name('products.uploadImage');

    // Get Subcategories by Category
    Route::get('products/subcategories/{categoryId}', [ProductsController::class, 'getSubcategories']);

    Route::delete('products/delete-image/{id}', [ProductsController::class, 'deleteImage'])
        ->name('products.deleteImage');


    Route::get('/get-products', [ProductsController::class, 'getProducts'])
        ->name('products.getProducts');



    // coupons routes



    Route::get('coupons', [CouponsCodeController::class, 'index'])
        ->name('coupons.index');

    Route::get('coupons/create', [CouponsCodeController::class, 'create'])
        ->name('coupons.create');

    Route::post('coupons', [CouponsCodeController::class, 'store'])
        ->name('coupons.store');

    Route::get('coupons/{id}/edit', [CouponsCodeController::class, 'edit'])
        ->name('coupons.edit');

    Route::put('coupons/{id}', [CouponsCodeController::class, 'update'])
        ->name('coupons.update');

    Route::delete('coupons/{id}', [CouponsCodeController::class, 'destroy'])
        ->name('coupons.destroy');

});
Route::get('/user/dashboard', function () {
    return view('user.dashboard');
})->middleware(['auth'])
    ->name('user.dashboard');

Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

// front routes

// Public homepage
Route::get('/', [FrontController::class, 'index'])->name('front.home');

Route::get('page/{slug}', [FrontController::class, 'page'])->name('front.page');


// Checkout page (auth required)
Route::get('/checkout', [CheckoutController::class, 'index'])
    ->middleware('auth')
    ->name('front.checkout');

Route::get('/shop', [ShopController::class, 'index'])->name('front.shop');

Route::get('/product/{slug}', [ProductsController::class, 'product'])->name('front.product');

Route::post('/cart/add', [CartController::class, 'add'])->name('front.cart.add');
Route::get('/cart', [CartController::class, 'cart'])->name('front.cart.page');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// user auth

Route::get('/user/login', [UserauthController::class, 'index'])
    ->name('login');

Route::get('/user/register', [UserauthController::class, 'view'])->name('user_auth.register');

Route::post('/user/login', [UserauthController::class, 'loginPost'])->name('user_auth.loginPost');

Route::post('/user/register', [UserauthController::class, 'registerPost'])->name('user_auth.registerPost');

Route::get('/user/logout', [UserauthController::class, 'logout'])->name('user_auth.logout');

Route::get('/thanks', [ThanksController::class, 'index'])
    ->name('front.thanks');

Route::post('/process-checkout', [CheckoutController::class, 'processCheckout'])
    ->middleware('auth')
    ->name('front.process-checkout');

Route::post('/apply-coupon', [CheckoutController::class, 'applyCoupon'])
    ->name('front.applyCoupon');

Route::prefix('admin')->middleware(['auth'])->group(function () {

    Route::get('/shipping', [ShippingController::class, 'index'])->name('admin.shippings.index');

    Route::get('/shipping/create', [ShippingController::class, 'create'])->name('admin.shippings.create');

    Route::post('/shipping/store', [ShippingController::class, 'store'])->name('admin.shippings.store');

    Route::get('/shipping/{id}/edit', [ShippingController::class, 'edit'])->name('admin.shippings.edit');

    Route::post('/shipping/{id}/update', [ShippingController::class, 'update'])->name('admin.shippings.update');

    Route::delete('/shipping/{id}', [ShippingController::class, 'destroy'])->name('admin.shippings.delete');
});

Route::post('/get-shipping', [CheckoutController::class, 'getShipping'])
    ->name('front.getShipping');



Route::middleware('auth')->group(function () {

    Route::get('/front/account/profile', [UserauthController::class, 'profile'])
        ->name('front.account.profile');

    Route::get('/front/account/order', [UserauthController::class, 'orders'])
        ->name('front.account.order');

    Route::get('/front/account/order/{id}', [UserauthController::class, 'orderDetail'])
        ->name('front.account.orderDetail');

    // Add auth middleware

    Route::post('front/account/wishlist/toggle', [WishlistsController::class, 'toggle'])->name('front.account.wishlist.toggle');
    Route::get('front/account/wishlist', [WishlistsController::class, 'index'])->name('front.account.wishlist');
    Route::delete('front/account/{id}', [WishlistsController::class, 'remove'])->name('front.account.remove');
});



Route::get('/admin/order/order', [OrderController::class, 'index'])->name('admin.order.order');

Route::get('/admin/order/order-detail/{id}', [OrderController::class, 'show'])->name('admin.order.order-detail');


Route::post('/admin/order/update-status', [OrderController::class, 'updateStatusAjax'])
    ->name('admin.order.updateStatusAjax');

Route::post('/emails/order-invoice', [OrderController::class, 'sendInvoiceEmail'])
    ->name('emails.order-invoice');


Route::middleware(['auth'])->group(function () {

    // Show account settings page
    Route::get('/account/settings', [UserDetailController::class, 'edit'])
        ->name('user.settings');

    // Update personal information (name, email, password)
    Route::post('/account/settings/personal', [UserDetailController::class, 'updatePersonal'])
        ->name('user.updatePersonal');

    // Update address information
    Route::post('/account/settings/address', [UserDetailController::class, 'updateAddress'])
        ->name('user.updateAddress');

});


Route::prefix('admin')->group(function () {

    // User listing
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');

    // Create user
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('users', [UserController::class, 'store'])->name('admin.users.store');

    // Edit user
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');

    Route::put('users/{id}', [UserController::class, 'update'])->name('admin.users.update');

    // Delete user
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

// pages routes


    // User listing
    Route::get('/pages', [PageController::class, 'index'])->name('admin.pages.index');

    // Create user
    Route::get('/pages/create', [PageController::class, 'create'])->name('admin.pages.create');

    Route::post('pages', [PageController::class, 'store'])->name('admin.pages.store');

    // Edit user
    Route::get('/pages/{id}/edit', [PageController::class, 'edit'])->name('admin.pages.edit');

    Route::put('pages/{id}', [PageController::class, 'update'])->name('admin.pages.update');

    // Delete user
    Route::delete('/pages/{id}', [PageController::class, 'destroy'])->name('admin.pages.destroy');

});


// Show Change Password Form
Route::middleware(['auth'])->get('/admin/change-password', [AdminAuthController::class, 'showChangePasswordForm'])
    ->name('admin.users.changePasswordForm');

// Handle Change Password POST
Route::middleware(['auth'])->post('/admin/change-password', [AdminAuthController::class, 'updatePassword'])
    ->name('admin.users.updatePassword');


Route::middleware(['auth'])->group(function () {
    Route::post('/admin/update-personal', [AdminAuthController::class, 'updatePersonal'])
        ->name('admin.updatePersonal');
});
