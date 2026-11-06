<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpController;
use App\Http\Controllers\FunctionController;
use App\Http\Controllers\TriggerController;

Route::get('/', function () {
    return redirect('/sp');
});

Route::get('/sp', [SpController::class, 'index'])->name('sp.index');
Route::post('/sp/penjualan', [SpController::class, 'prosesPenjualan'])->name('sp.penjualan');
Route::post('/sp/retur', [SpController::class, 'prosesRetur'])->name('sp.retur');

Route::get('/function', [FunctionController::class, 'index'])->name('function.index');

Route::get('/trigger', [TriggerController::class, 'index'])->name('trigger.index');
Route::post('/trigger/simulasi', [TriggerController::class, 'simulasikan'])->name('trigger.simulasi');
