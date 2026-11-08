<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MarginPenjualanController;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\DetailPengadaanController;
use App\Http\Controllers\PenerimaanController;
use App\Http\Controllers\DetailPenerimaanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\DetailPenjualanController;
use App\Http\Controllers\ReturController;
use App\Http\Controllers\DetailReturController;
use App\Http\Controllers\KartuStokController;
use App\Http\Controllers\SpController;
use App\Http\Controllers\FunctionController;
use App\Http\Controllers\TriggerController;

Route::get('/', function () {
    return redirect()->route('barang.index');
});

Route::resource('barang', BarangController::class);
Route::resource('satuan', SatuanController::class);
Route::resource('vendor', VendorController::class);
Route::resource('user', UserController::class);
Route::resource('role', RoleController::class);
Route::resource('margin-penjualan', MarginPenjualanController::class);
Route::resource('pengadaan', PengadaanController::class);
Route::resource('detail-pengadaan', DetailPengadaanController::class);
Route::resource('penerimaan', PenerimaanController::class);
Route::resource('detail-penerimaan', DetailPenerimaanController::class);
Route::resource('penjualan', PenjualanController::class);
Route::resource('detail-penjualan', DetailPenjualanController::class);
Route::resource('retur', ReturController::class);
Route::resource('detail-retur', DetailReturController::class);
Route::get('kartu-stok', [KartuStokController::class, 'index'])->name('kartu-stok.index');

Route::get('sp', [SpController::class, 'index'])->name('sp.index');
Route::post('sp/proses-penjualan', [SpController::class, 'prosesPenjualan'])->name('sp.prosesPenjualan');
Route::post('sp/proses-retur', [SpController::class, 'prosesRetur'])->name('sp.prosesRetur');
Route::get('function', [FunctionController::class, 'index'])->name('function.index');
Route::get('trigger', [TriggerController::class, 'index'])->name('trigger.index');
