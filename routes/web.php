<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MarginPenjualanController;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\PenerimaanController;
use App\Http\Controllers\DetailPenerimaanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\KartuStokController;

Route::get('/', fn () => redirect()->route('dashboard'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['login'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::middleware('role:1')->group(function () {
        Route::resource('barang', BarangController::class)
            ->only(['create', 'store', 'edit', 'update', 'destroy'])
            ->parameters(['barang' => 'id']);
        Route::resource('satuan', SatuanController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
            ->parameters(['satuan' => 'id']);
        Route::resource('vendor', VendorController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
            ->parameters(['vendor' => 'id']);
        Route::resource('role', RoleController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
            ->parameters(['role' => 'id']);
        Route::resource('user', UserController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
            ->parameters(['user' => 'id']);
        Route::resource('margin-penjualan', MarginPenjualanController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
            ->parameters(['margin-penjualan' => 'id']);
        Route::post('margin-penjualan/{id}/aktifkan', [MarginPenjualanController::class, 'aktifkan'])
            ->name('margin-penjualan.aktifkan');
    });

    Route::resource('barang', BarangController::class)->only(['index']);
    Route::middleware('role:1,3')->group(function () {
        Route::resource('pengadaan', PengadaanController::class)->only(['create', 'store']);
        Route::post('pengadaan/{id}/detail', [PengadaanController::class, 'storeDetail'])->name('pengadaan.detail.store');
        Route::resource('penerimaan', PenerimaanController::class)->only(['create', 'store']);
        Route::get('detail-penerimaan/{id}/edit', [DetailPenerimaanController::class, 'edit'])->name('detail-penerimaan.edit');
        Route::put('detail-penerimaan/{id}', [DetailPenerimaanController::class, 'update'])->name('detail-penerimaan.update');
    });

    Route::middleware('role:1,3,4,5')->group(function () {
        Route::resource('pengadaan', PengadaanController::class)->only(['index', 'show']);
        Route::resource('penerimaan', PenerimaanController::class)->only(['index', 'show']);
        Route::get('kartu-stok', [KartuStokController::class, 'index'])->name('kartu-stok.index');
    });

    Route::middleware('role:1,2')->group(function () {
        Route::resource('penjualan', PenjualanController::class)->only(['create', 'store']);
        Route::post('penjualan/{id}/detail', [PenjualanController::class, 'storeDetail'])->name('penjualan.detail.store');
    });

    Route::middleware('role:1,2,4,5')->group(function () {
        Route::resource('penjualan', PenjualanController::class)->only(['index', 'show']);
    });
});
