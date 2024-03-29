<?php

namespace App\Listeners;

use App\Models\Coupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CartupdatedListener
{
    /**
     * Créer l'évènement listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Contrôller l'évènement listener.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $code = request()->session()->get('coupon');
        $coupon = Coupon::where('code', $code)->first();
        if ($code) {
            request()->session()->put('coupon', [
                'code' => $coupon->code,
                'remise' => $coupon->discount(Cart::subtotal())
            ]);
        }
    }
}
