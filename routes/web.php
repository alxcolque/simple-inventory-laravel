<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// desabilitar la ruta /register
Auth::routes(['register' => false]);

Route::get('/', function () {
    //redirige a login
    return redirect('/login');
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    // Routes for both admin and workers
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::get('/profile/pass', [UserController::class, 'passwordChange'])->name('profile.password');
    Route::get('/profile/delete', [UserController::class, 'passwordDelete'])->name('profile.delete');

    Route::get('/clients-js', [ClientController::class, 'getAllClient']);
    Route::get('/sales-graph/{value}', [HomeController::class, 'getSalesGraph']);
    Route::resource('clients', ClientController::class)->names('clients');
    Route::resource('sales', SaleController::class)->names('sales');
    Route::resource('purchases', PurchaseController::class)->names('purchases');

    /* Route::resource('inventories', InventoryController::class)->names('inventories');
    Route::resource('reports', ReportController::class)->names('reports'); */

    // Admin routes
    /* Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::resource('users', UserController::class)->names('users');
        Route::resource('products', ProductController::class)->names('products');
        Route::resource('categories', CategoryController::class)->names('categories');
        Route::resource('suppliers', SupplierController::class)->names('suppliers');
    }); */
    // Admin routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', [HomeController::class, 'index']);
        Route::resource('users', UserController::class)->names('users');
        Route::resource('products', ProductController::class)->names('products');
        Route::resource('categories', CategoryController::class)->names('categories');
        Route::resource('suppliers', SupplierController::class)->names('suppliers');

    });

    // Worker routes
    Route::middleware(['role:worker'])->group(function () {
        Route::get('/worker', [HomeController::class, 'index'])->name('worker.index');
        // Add more worker-specific routes here
    });
});

