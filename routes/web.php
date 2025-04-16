<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeePenjualanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// LOGIN
Route::get('/', [UserController::class, 'login'])->name('login');
Route::post('/login-proses', [UserController::class, 'login_proses'])->name('login-proses');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::get('/dashboardEmployee', function () {
    return view('dashboardEmployee');
})->name('dashboardEmployee');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');


// ROUTE ADMIN
Route::prefix('admin')->name('admin.')->group(function () {
    // USERS
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create'); 
    Route::post('/users', [UserController::class, 'store'])->name('users.store'); 
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit'); 
    Route::patch('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.delete');
    
    // PRODUCT 
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create'); 
    Route::post('/products', [ProductController::class, 'store'])->name('products.store'); 
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit'); 
    Route::patch('/products/{id}/updateStock', [ProductController::class, 'updateStock'])->name('products.updateStock'); 
    Route::patch('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.delete');

    // PENJUALANS
    Route::get('/penjualans', [PenjualanController::class, 'index'])->name('penjualans.index');
});

Route::prefix('employee')->name('employee.')->group(function () {
    // PRODUCT 
    Route::get('/products', [ProductController::class, 'indexEmployee'])->name('products.index');

    // PENJUALANS
    Route::get('/penjualans', [EmployeePenjualanController::class, 'index'])->name('penjualans.index');
    Route::get('/penjualans/card', [EmployeePenjualanController::class, 'card'])->name('penjualans.card');
    Route::get('/create', [EmployeePenjualanController::class, 'create'])->name('penjualan.create');
    Route::get('/penjualans/preview', [EmployeePenjualanController::class, 'preview'])->name('penjualans.preview');
});
