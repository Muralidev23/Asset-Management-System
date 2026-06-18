<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Redirect route for default home paths
Route::get('/home', function () {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('employee.dashboard');
    }
    return redirect()->route('login');
})->name('home');

// Admin Routes (Admin role required)
Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin'], function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // Employee Bulk Upload
    Route::get('/employees/upload', [App\Http\Controllers\EmployeeController::class, 'showUploadForm'])->name('employees.upload');
    Route::post('/employees/upload', [App\Http\Controllers\EmployeeController::class, 'handleUpload'])->name('employees.upload.post');
    Route::get('/employees/download-template', [App\Http\Controllers\EmployeeController::class, 'downloadTemplate'])->name('employees.download-template');
    
    // Employee CRUD
    Route::resource('employees', App\Http\Controllers\EmployeeController::class);
    
    // Asset CRUD
    Route::resource('assets', App\Http\Controllers\AssetController::class)->except(['show']);
    
    // Asset assignment, return, and history
    Route::post('/assets/{asset}/assign', [App\Http\Controllers\AssetController::class, 'assign'])->name('assets.assign');
    Route::post('/assets/{asset}/return', [App\Http\Controllers\AssetController::class, 'returnAsset'])->name('assets.return');
    Route::get('/assets/{asset}/history', [App\Http\Controllers\AssetController::class, 'history'])->name('assets.history');
});

// Employee Routes (Authentication required)
Route::group(['middleware' => ['auth'], 'prefix' => 'employee'], function () {
    Route::get('/dashboard', [App\Http\Controllers\EmployeeDashboardController::class, 'index'])->name('employee.dashboard');
});

require __DIR__.'/auth.php';
