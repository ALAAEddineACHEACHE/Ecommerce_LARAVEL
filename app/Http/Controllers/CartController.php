<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * accéder à la page index de la carte.
     *
     * @return void
     */
    public function index()
    {
        return view('client.Cart.index');
    }
    /**
     * ajouter le produit dans le panier.
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        $product = Product::find($request->product_id);
        Cart::add($product->id, $product->title, 1, $product->price)
            ->associate('App\Models\Product');
        return redirect()->route('products.index')->with('success', 'Le produit a été bien ajouté');
    }
    /**
     * appliquer le coupon de réduction qui est à 50%.
     *
     * @param  mixed $request
     * @return void
     */
    public function storecoupon(Request $request)
    {
        $code = $request->get('code');
        $coupon = Coupon::where('code', $code)->first();
        if (!$coupon) {
            return redirect()->back()->with('error', 'Le coupon est invalide.');
        }
        $request->session()->put('coupon', [
            'code' => $coupon->code,
            'remise' => $coupon->discount(Cart::subtotal())
        ]);
        return redirect()->back()->with('success', 'Le coupon est appliqué.');
    }
    /**
     * changer la quantité du produit du moment que ça ne dépasse pas 6 produits.
     *
     * @param  mixed $request
     * @param  mixed $rowId
     * @return void
     */
    public function update(Request $request, $rowId)
    {

        $data = $request->json()->all();
        $validator = Validator::make($request->all(), [
            'qty' => 'required|numeric|between:1,6'
        ]);
        if ($data['qty'] > $data['stock']) {
            Session::flash('error', 'La quantité de ce produit n\'est pas disponible');
            return response()->json(['error' => 'Product quantity not Available']);
        }
        if ($validator->fails()) {
            Session::flash('danger', 'La quantité du produit ne doit pas dépasser 6 produits');
            return response()->json(['error' => 'Cart Quantity Has Been Updated']);
        }
        Cart::update($rowId, $data['qty']);
        Session::flash('success', 'La quantité du produit est passée à ' . $data['qty'] . '.');
        return response()->json(['success' => 'Cart Quantity Has Been Updated']);
    }
    /**
     * supprimer le produit de la carte.
     *
     * @param  mixed $rowId
     * @return void
     */
    public function destroy($rowId)
    {
        Cart::remove($rowId);
        return redirect()->back()->with('success', 'Le produit a été supprimé');
    }
    /**
     * Annuler et retirer le coupon.
     *
     * @return void
     */
    public function destroyCoupon()
    {
        request()->session()->forget('coupon');
        return redirect()->back()->with('success', 'Le coupon a été retiré avec succès');
    }
}
