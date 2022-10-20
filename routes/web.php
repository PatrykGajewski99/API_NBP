<?php

use App\Http\Controllers\Api\CurrencyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GoldController;

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
    return view('welcome');
})->name('welcome');

require __DIR__.'/auth.php';

Route::get('/result',[CurrencyController::class,'convertCurrency'])->name('result');

Route::get('/convertCurrency', function () {
    return view('convertCurrency');
})->name('convertCurrency');

Route::get('/goldExchange', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('gold.exchange');

Route::get('/convertGoldToCurrency', function () {
    return view('convertGold');
})->name('convertGoldToCurrency');

Route::get('/convertGold',[GoldController::class,'convertGoldToCurrency'])->name('convert.gold.to.currency');
Route::get('/convertCurrencyToGold',[GoldController::class,'convertCurrencyToGold'])->name('convert.currency.to.gold');
