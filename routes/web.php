<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});


// Kategori Routes
Route::prefix('kategori')->name('kategori.')->group(function () {
    Route::get('/', [KategoriController::class, 'index'])->name('index');
    Route::get('/create', [KategoriController::class, 'create'])->name('create');
    Route::get('/data', [KategoriController::class, 'getData'])->name('data');
    Route::post('/store', [KategoriController::class, 'store'])->name('store');
    Route::get('/{id}/show', [KategoriController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [KategoriController::class, 'update'])->name('update');
    Route::get('/{id}/confirm', [KategoriController::class, 'confirm'])->name('confirm');
    Route::delete('/{id}/delete', [KategoriController::class, 'delete'])->name('delete');
});

// Barang Routes
Route::prefix('barang')->name('barang.')->group(function () {
    Route::get('/', [BarangController::class, 'index'])->name('index');
    Route::get('/create', [BarangController::class, 'create'])->name('create');
    Route::get('/data', [BarangController::class, 'getData'])->name('getData');
    Route::post('/store', [BarangController::class, 'store'])->name('store');
    Route::get('/{id}/show', [BarangController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [BarangController::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [BarangController::class, 'update'])->name('update');
    Route::get('/{id}/confirm', [BarangController::class, 'confirm'])->name('confirm');
    Route::delete('/{id}/delete', [BarangController::class, 'delete'])->name('delete');
});

// User Routes
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::get('/data', [UserController::class, 'getData'])->name('getData');
    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::get('/{id}/show', [UserController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [UserController::class, 'update'])->name('update');
    Route::get('/{id}/confirm', [UserController::class, 'confirm'])->name('confirm');
    Route::delete('/{id}/delete', [UserController::class, 'delete'])->name('delete');
});

// Transaksi Routes
Route::prefix('transaksi')->name('transaksi.')->group(function () {
    Route::get('/', [TransaksiController::class, 'index'])->name('index');
    Route::get('/create', [TransaksiController::class, 'create'])->name('create');
    Route::get('/data', [TransaksiController::class, 'getData'])->name('getData');
    Route::post('/store', [TransaksiController::class, 'store'])->name('store');
    Route::get('/{id}/show', [TransaksiController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [TransaksiController::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [TransaksiController::class, 'update'])->name('update');
    Route::get('/{id}/confirm', [TransaksiController::class, 'confirm'])->name('confirm');
    Route::delete('/{id}/delete', [TransaksiController::class, 'delete'])->name('delete');
});

// Log Activity Routes
Route::prefix('log_activity')->name('log_activity.')->group(function () {
    Route::get('/', [LogActivityController::class, 'index'])->name('index');
    Route::post('/store', [LogActivityController::class, 'store'])->name('store');
});

// Login
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
