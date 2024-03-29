<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Afficher les produits avec ses catégories.
     *
     * @return void
     */
    public function index()
    {
        if (request()->categorie) {
            $products = Product::with('categories')->whereHas('categories', function ($query) {
                $query->where('slug', request()->categorie);
            })->orderBy('created_at', 'DESC')->paginate(6);
        } else {
            $products = Product::with('categories')->orderBy('created_at', 'DESC')->paginate(6);
        }

        return view('client.products.index')->with('products', $products);
    }
    /**
     * regarder le produit et voir son statut dispo ou pas.
     *
     * @param  mixed $slug
     * @return void
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $stock = $product->stock === 0 ? 'Indisponible' : 'Disponible';
        return view('client.products.show', [
            'product' => $product,
            'stock' => $stock
        ]);
    }
    /**
     * faire une recherche pour trouver le produit qu'on veut.
     *
     * @return void
     */
    public function search()
    {
        request()->validate([
            'search_product' => 'required|min:3'
        ]);
        $search_product = request()->input('search_product');
        $products = Product::where('title', 'like', "%" . $search_product . "%")
            ->orWhere('description', 'like', "%$search_product%")
            ->paginate(6);

        return view('client.products.searchshow')->with('products', $products);
    }
}
