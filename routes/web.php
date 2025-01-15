<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImagesController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/goback', [ProfileController::class, 'goback'])->name('go.back');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth', 'role:admin')->group(function () {
    Route::get('/admin-index',  [AdminController::class, 'index'])->name('admin.index');

    Route::get('/category-index', [CategoryController::class, 'index'])->name('category.index');
    Route::post('/category-create', [CategoryController::class, 'create'])->name('category.create');
    Route::put('/category-update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category-destroy/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

    Route::get('/product-index', [ProductController::class, 'index'])->name('product.index');
    Route::post('/product-create', [ProductController::class, 'create'])->name('product.create');
    Route::put('/product-update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product-destroy/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
    
    Route::get('/product-variants', [ProductVariantController::class, 'index'])->name('product_variant.index');
    Route::post('/product-variants-create', [ProductVariantController::class, 'create'])->name('product_variant.create');
    Route::put('/product-variants-update/{id}', [ProductVariantController::class, 'update'])->name('product_variant.update');
    Route::delete('/product-variants-destroy/{id}', [ProductVariantController::class, 'destroy'])->name('product_variant.destroy');
    
    Route::get('/stocks', [StockController::class, 'index'])->name('stock.index');
    Route::post('/stocks-create', [StockController::class, 'create'])->name('stock.create'); 
    Route::put('/stocks-update/{id}', [StockController::class, 'update'])->name('stock.update'); 
    Route::delete('/stocks-destroy/{id}', [StockController::class, 'destroy'])->name('stock.destroy');
    
    Route::get('/product-images', [ProductImagesController::class, 'index'])->name('product_image.index');
    Route::post('/product-image-create', [ProductImagesController::class, 'create'])->name('product_image.create');
    Route::put('/product-image-update/{id}', [ProductImagesController::class, 'update'])->name('product_image.update');
    Route::delete('/product-image-destroy/{id}', [ProductImagesController::class, 'destroy'])->name('product_image.destroy');      

});


Route::middleware('auth')->group(function () {
    Route::get('/', [ClientController::class, 'index'])->name('client.index');
    Route::get('/client-category/{id}', [ClientController::class, 'items'])->name('client.category-product');
    Route::get('/product-variant/{id}', [ClientController::class, 'variants'])->name('client.product-variant');
    Route::get('/back-product', [ClientController::class, 'back'])->name('back.product');
});

require __DIR__ . '/auth.php';
