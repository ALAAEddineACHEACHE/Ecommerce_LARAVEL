<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use TCG\Voyager\Facades\Voyager;

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



//Les routes des produits
Route::get('', [ProductController::class, 'index'])->name('products.index');
Route::get('boutique/{slug}', [ProductController::class, 'show']);
Route::get('searchshow', [ProductController::class, 'search'])->name('products.searchshow');
Auth::routes();
//Les routes de la Carte
Route::group(['middleware' => ['auth']], function () {
    Route::get('panier', [CartController::class, 'index'])->name('cart index page');
    Route::post('ajouter/panier', [CartController::class, 'store'])->name('cart.store');
    Route::post('panier/{rowId}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('panier/{rowId}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('coupon', [CartController::class, 'storecoupon'])->name('cart.store.coupon');
    Route::delete('coupon', [CartController::class, 'destroyCoupon'])->name('cart.destroy.coupon');
});
//Paiments avec Stripe
Route::group(['middleware' => ['auth']], function () {
    Route::get('paiement', [StripeController::class, 'index']);
    Route::post('checkoutStore', [StripeController::class, 'store']);
    Route::get('merci', [StripeController::class, 'thankyou']);
});

//Voyager Routes
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
Route::get('/orders', [HomeController::class, 'index'])->name('myorders');
