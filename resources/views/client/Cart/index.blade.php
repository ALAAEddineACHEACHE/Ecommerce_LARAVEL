@extends('layouts.master')
@section('content')
    @if (Cart::count() > 0)
        <div class="px-4 px-lg-0">
            <div class="pb-5">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">

                            <!-- Shopping cart table -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="border-0 bg-light">
                                                <div class="p-2 px-3 text-uppercase">Produit</div>
                                            </th>
                                            <th scope="col" class="border-0 bg-light">
                                                <div class="py-2 text-uppercase">Prix</div>
                                            </th>
                                            <th scope="col" class="border-0 bg-light">
                                                <div class="py-2 text-uppercase">Quantité</div>
                                            </th>
                                            <th scope="col" class="border-0 bg-light">
                                                <div class="py-2 text-uppercase">Supprimer</div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach (Cart::content() as $product)
                                            <tr>
                                                <th scope="row" class="border-0">
                                                    <div class="p-2">
                                                        {{-- <img src="{{ $product->model->image }}" alt="" width="70"
                                                            class="img-fluid rounded shadow-sm"> --}}
                                                        <img src="{{ asset('storage/' . $product->model->image) }}"
                                                            id="image-panier" alt="pas d'image"
                                                            class="img-fluid rounded shadow-sm">
                                                        <div class="ml-3 d-inline-block align-middle">
                                                            <h5 class="mb-0"> <a title="titre du produit" href=""
                                                                    class="text-dark d-inline-block align-middle">
                                                                    {{ $product->model->title }}</a></h5><span
                                                                class="text-muted font-weight-normal font-italic d-block">Categorie:
                                                                @foreach ($product->model->categories as $category)
                                                                    {{ $category->name }}{{ $loop->last ? '' : ', ' }}
                                                                @endforeach
                                                            </span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </th>
                                                <td class="border-0 align-middle">
                                                    <strong>{{ getPrice($product->subtotal()) }}</strong>
                                                </td>
                                                <td class="border-0 align-middle">

                                                    <select class="custom-select" name="qty" id="qty"
                                                        data-id="{{ $product->rowId }}"
                                                        data-stock="{{ $product->model->stock }}">
                                                        @for ($i = 1; $i <= 6; $i++)
                                                            <option value="{{ $i }}"
                                                                {{ $product->qty == $i ? 'selected' : '' }}>
                                                                {{ $i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </td>
                                                <td class="border-0 align-middle">
                                                    <form action="{{ route('cart.destroy', $product->rowId) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-danger">
                                                            <i class="bi bi-trash-fill"></i><svg
                                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                fill="currentColor" class="bi bi-trash-fill"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                                            </svg>
                                                    </form>
                                                </td>
                                            </tr>

                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- End -->
                        </div>
                    </div>

                    <div class="row py-5 p-4 bg-white rounded shadow-sm">
                        <div class="col-lg-6">
                            <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Code Coupon</div>
                            @if (!request()->session()->has('coupon'))
                                <div class="p-4">
                                    <p class="font-italic mb-4">Si vous détenez un code Coupon , entrez-le dans le champ
                                        çi-dessous</p>
                                    <form action="{{ route('cart.store.coupon') }}" method="POST">
                                        <div class="input-group mb-4 border rounded-pill p-2">
                                            @csrf
                                            <input type="text" placeholder="Entrez votre code içi" name="code"
                                                aria-describedby="button-addon3" class="form-control border-0" />
                                            <div class="input-group-append border-0">
                                                <button type="submit" class="btn btn-dark px-4 rounded-pill"><i
                                                        class="fa fa-gift mr-2"></i>Appliquer
                                                    le coupon</button>
                                            </div>
                                    </form>
                                </div>
                            @else
                                <div class="p-4">
                                    <p class="font-italic mb-4">Un coupon est déjà appliqué.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Détails de la
                            commande
                        </div>
                        <div class="p-4">
                            <p class="font-italic mb-4">Les frais d'expédition et les frais supplémentaires sont calculés en
                                fonction des valeurs entrées.</p>
                            <ul class="list-unstyled mb-4">
                                <li class="d-flex justify-content-between py-3 border-bottom"><strong
                                        class="text-muted">Sous-Total
                                    </strong><strong>{{ getPrice(Cart::subtotal()) }}</strong></li>
                                @if (request()->session()->has('coupon'))
                                    <li class="d-flex justify-content-between py-3 border-bottom"><strong
                                            class="text-muted">Coupon
                                            {{ request()->session()->get('coupon')['code'] }}
                                            <form action="{{ route('cart.destroy.coupon') }}" method="POST"
                                                class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash-fill"></i><svg xmlns="http://www.w3.org/2000/svg"
                                                        width="16" height="16" fill="currentColor" class="bi bi-trash-fill"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </strong><strong>{{ getPrice(
                                            request()->session()->get('coupon')['remise'],
                                        ) }}</strong>
                                    </li>
                                    <li class="d-flex justify-content-between py-3 border-bottom"><strong
                                            class="text-muted">Nouveau
                                            Sous-total</strong><strong>{{ getPrice(newsubtotal()) }}</strong>
                                    </li>
                                    <li class="d-flex justify-content-between py-3 border-bottom"><strong
                                            class="text-muted">Taxes</strong><strong>{{ getPrice(newTaxes()) }}</strong>
                                    </li>
                                    <li class="d-flex justify-content-between py-3 border-bottom"><strong
                                            class="text-muted">Total</strong><strong>{{ getPrice(newtotalprice()) }}</strong>
                                    </li>
                                @else
                                    <li class="d-flex justify-content-between py-3 border-bottom"><strong
                                            class="text-muted">Taxes</strong><strong>{{ getPrice(Cart::tax()) }}</strong>
                                    </li>
                                    <li class="d-flex justify-content-between py-3 border-bottom"><strong
                                            class="text-muted">Total</strong>
                                        <h5 class="font-weight-bold">{{ getPrice(Cart::total()) }}</h5>
                                    </li>
                                @endif
                            </ul><a title="paimentenligne" href="{{ url('paiement') }}"
                                class="btn btn-success rounded-pill py-2 btn-block">Passer à la caisse</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        </div>
    @else
        <div class="col-md-12">
            <h5>Votre panier est vide pour le moment</h5>
            <p>Mais vous pouvez visiter la <a title="Revenir vers la boutique(page Acceuil)"
                    href="{{ route('products.index') }}">boutique</a> pour faire votre
                shopping.</p>
        </div>
    @endif
@endsection
@section('extra-js')
    @include('client.partials.Cartscript');
@endsection
