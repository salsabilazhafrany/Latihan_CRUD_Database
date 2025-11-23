<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CrudController;

// Route Login
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Dashboard (Sebaiknya diproteksi middleware, tapi kita ikuti alur tutorial)
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

// Route CRUD (tanpa database)
Route::prefix('crud')->group(function () {
    Route::get('/', [CrudController::class, 'index'])->name('crud.index');
    Route::get('/create', [CrudController::class, 'create'])->name('crud.create');
    Route::post('/store', [CrudController::class, 'store'])->name('crud.store');
    Route::get('/edit/{id}', [CrudController::class, 'edit'])->name('crud.edit');
    Route::post('/update/{id}', [CrudController::class, 'update'])->name('crud.update');
    Route::get('/delete/{id}', [CrudController::class, 'delete'])->name('crud.delete');
});