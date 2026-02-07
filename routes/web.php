<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\FrontController;

use Illuminate\Support\Facades\Route;

/* Login */

Route::get('/login', [AdminAuthController::class, 'showLogin'])
    ->name('login');

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

});

Route::get('/user/dashboard', function () {
    return view('user.dashboard');
})->middleware(['auth'])
  ->name('user.dashboard');



Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');





// front routes


Route::get('/', [FrontController::class, 'index'])->name('front.home');
