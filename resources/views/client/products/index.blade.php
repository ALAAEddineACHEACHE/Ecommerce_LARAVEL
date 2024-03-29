@extends('layouts.master')
@section('content')
    @foreach ($products as $product)
        <div class="col-md-6">
            <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                <div class="col p-4 d-flex flex-column position-static">
                    <strong class="d-inline-block mb-2 text-primary">
                        @foreach ($product->categories as $category)
                            {{ $category->name }}

                        @endforeach
                    </strong>
                    <h5 class="mb-0">{{ $product->title }}</h5>
                    <div class="mb-1 text-muted">{{ $product->created_at->format('d/m/Y') }}</div>
                    <p class="card-text mb-auto">{{ $product->subtitle }}</p>
                    <strong class="card-text mb-auto">{{ $product->getPrice() }}</strong>
                    <a title="ajouter le produit au panier" href="{{ url('boutique', $product->slug) }}"
                        class="stretched-link btn btn-info">Achat du
                        produit</a>
                </div>
                <div class="col-auto d-flex d-lg-block">
                    <img id="newproduct" src="{{ asset('storage/' . $product->image) }}" alt="">

                </div>
            </div>
        </div>


    @endforeach
    {{ $products->appends(request()->input())->links() }}

@endsection
