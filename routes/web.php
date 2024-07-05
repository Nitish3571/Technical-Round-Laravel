<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;


Route::get('/', [LoginController::class , 'index'])->name("login");

Route::get('/register', [RegisterController::class , 'index'])->name("register");
Route::post('/register', [RegisterController::class , 'store'])->name("register-store");
Route::get('/login', [LoginController::class , 'index'])->name("login");
Route::post('/login', [LoginController::class , 'login'])->name("login-store");
Route::get('/logout', [LoginController::class , 'logout'])->name("logout");
// Route::get('/product', function () {
    //     return view('pages/product/product-list');
    // });
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class , 'index'])->name("dashboard");
    Route::get('/category-list', [CategoryController::class, 'index' ])->name('category-list');
    Route::get('/category-show', [CategoryController::class, 'show' ])->name('category-show');
    Route::post('/category-store', [CategoryController::class, 'store' ])->name('category-store');
    Route::get('/category-edit/{id}', [CategoryController::class, 'edit' ])->name('category-edit');
    Route::post('/category-update', [CategoryController::class, 'update' ])->name('category-update');
    Route::delete('/category-delete/{id}', [CategoryController::class, 'delete' ])->name('category-delete');

    Route::get('/product-list', [ProductController::class, 'index' ])->name('product-list');
    Route::get('/product-show', [ProductController::class, 'show' ])->name('product-show');
    Route::post('/product-add', [ProductController::class, 'store' ])->name('add-product');
    // Route::get('/products-edit/{id}', [ProductController::class, 'edit' ])->name('product-edit');
    // routes/web.php
Route::get('/product-edit/{id}', [ProductController::class, 'edit'])->name('product-edit');
// Update Product
Route::post('/product-update/{id}', [ProductController::class, 'update'])->name('update-product');
Route::delete('/product-delete/{id}', [ProductController::class, 'delete'])->name('product-delete');



});
