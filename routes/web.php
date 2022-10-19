<?php

use App\Http\Controllers\Api\CurrencyController;
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


Route::match(['get','post'],'/',[CurrencyController::class,'store'])->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/result',[CurrencyController::class,'convertPLN'])->name('result');

Route::get('/convertCurrency', function () {
    return view('convertCurrency');
})->name('convertCurrency');

Route::get('/goldExchange', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('gold.exchange');
