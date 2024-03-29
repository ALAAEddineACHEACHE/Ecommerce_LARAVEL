<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Stripe\Stripe;
use App\Models\Order;
use App\Models\Product;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use Stripe\PaymentIntent;


class StripeController extends Controller
{
    /**
     * Les fonctions du coupon et la création du paiment en ligne.
     *
     * @return void
     */
    public function index()
    {
        if (Cart::count() <= 0) {
            return redirect()->route('products.index');
        }
        Stripe::setApiKey('sk_test_51K5IpbFJCP30LWdTinX7azApRiBWevRmPKhF0k2MclTjHmh2Ytm27mMJl4G9lI48nfXRwhZpmhOWrCGP1xsoPVgO00kS9eIjXo');
        if (request()->session()->has('coupon')) {
            $total = Cart::subtotal() - request()->session()->get('coupon')['remise'] + (Cart::subtotal() - request()->session()->get('coupon')['remise']) * (config('cart.tax') / 100);
        } else {
            $total = Cart::total();
        }
        $intent = PaymentIntent::create([
            'payment_method_types' => [
                'card',
            ],
            'amount' => round($total),
            'currency' => 'mad',

        ]);
        $clientSecret = Arr::get($intent, 'client_secret');

        return view('StripePayment.index', [
            'clientSecret' => $clientSecret,
            'total' => $total
        ]);
    }
    /**
     * Enregistrer les données dans la paiment et traiter la commande.
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {

        if ($this->checkIfNotAvailable()) {
            Session::flash('error', 'Le produit dans votre panier n\'est plus disponible.');
            return response()->json(['success' => false], 400);
        }
        $data = $request->json()->all();

        $order = new Order();

        $order->payment_intent_id = $data['paymentIntent']['id'];
        $order->amount = $data['paymentIntent']['amount'];

        $order->payment_created_at = (new DateTime())
            ->setTimestamp($data['paymentIntent']['created'])
            ->format('Y-m-d H:i:s');

        $products = [];
        $i = 0;

        foreach (Cart::content() as $product) {
            $products['product_' . $i][] = $product->model->title;
            $products['product_' . $i][] = $product->model->price;
            $products['product_' . $i][] = $product->qty;
            $i++;
        }

        $order->products = serialize($products);
        $order->user_id = Auth()->user()->id;
        $order->save();

        if ($data['paymentIntent']['status'] === 'succeeded') {
            $this->updateStock();
            Cart::destroy();
            Session::flash('success', 'Votre commande a été traitée avec succès.');
            return response()->json(['success' => 'Payment Intent Succeeded']);
        } else {
            return response()->json(['error' => 'Payment Intent Not Succeeded']);
        }
    }
    /**
     * Rediriger vers la page de merci si la commande a été traitée avec succès.
     *
     * @return void
     */
    public function thankyou()
    {
        return Session::has('success') ? view('StripePayment.thankyou') : redirect()->route('products.index');
    }
    /**
     * La fonction qui décide si le produit avec ses quantités demandées est dispo sur le stock ou pas.
     *
     * @return void
     */
    private function checkIfNotAvailable()
    {
        foreach (Cart::content() as $item) {
            $product = Product::find($item->model->id);
            if ($product->stock < $item->qty) {
                return true;
            }
        }
        return false;
    }
    /**
     * Changer la quantité du stock.
     *
     * @return void
     */
    private function updateStock()
    {
        foreach (Cart::content() as $item) {
            $product = Product::find($item->model->id);
            $product->update(['stock' => $product->stock - $item->qty]);
        }
    }
}
