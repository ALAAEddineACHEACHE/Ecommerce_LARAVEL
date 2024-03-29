<?php

use Gloudemans\Shoppingcart\Facades\Cart;

/**
 * La fonction getPrice pour formatter le nombre.
 *
 * @param  mixed $priceInDecimals
 * @return void
 */
function getPrice($priceInDecimals)
{
    $price = floatval($priceInDecimals) / 100;

    return number_format($price, 2, ', ', ' ') . ' dh';
}
/**
 * fonction qui calcule le nouveau sous-total.
 *
 * @return void
 */
function newsubtotal()
{
    return Cart::subtotal() - request()->session()->get('coupon')['remise'];
}
/**
 * fonction qui calcule le nouveau taxe.
 *
 * @return void
 */
function newtaxes()
{
    return (Cart::subtotal() - request()->session()->get('coupon')['remise']) * (config('cart.tax') / 100);
}
/**
 * fonction qui calcule le nouveau prix total.
 *
 * @return void
 */
function newtotalprice()
{
    return Cart::subtotal() - request()->session()->get('coupon')['remise'] + (Cart::subtotal() - request()->session()->get('coupon')['remise']) * (config('cart.tax') / 100);
}
