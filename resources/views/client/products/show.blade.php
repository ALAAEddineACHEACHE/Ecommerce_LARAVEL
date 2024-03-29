@extends('layouts.master')
@section('content')
    <div class="col-md-12">
        <div
            class="row no-gutters p-3 border rounded d-flex align-items-center flex-md-row mb-4 shadow-sm position-relative">
            <div class="col p-3 d-flex flex-column position-static">
                <muted class="d-inline-block mb-2 text-info">
                    <div class="badge badge-pill badge-info">{{ $stock }}</div>
                    @foreach ($product->categories as $category)
                        {{ $category->name }}{{ $loop->last ? '' : ', ' }}
                    @endforeach
                </muted>
                <h3 class="mb-4">{{ $product->title }}</h3>
                <span>{!! $product->description !!}</span>
                <strong class="mb-4 display-4 text-secondary">{{ $product->getPrice() }}</strong>
                @if ($stock === 'Disponible')
                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn btn-success mb-2"><i class="fa fa-shopping-cart"
                                aria-hidden="true"></i>
                            Ajouter au panier</button>
                    </form>
                @endif
            </div>
            <div class="col-auto d-flex d-lg-block">
                <img id="image-product" src="{{ asset('storage/' . $product->image) }}" alt="pas d'image">
                <div class="mt-2 ml-5">

                    @if ($product->images)
                        @foreach (json_decode($product->images, true) as $image)
                            <img id="gallery-images" class="img-thumbnail" src="{{ asset('storage/' . $image) }}"
                                alt="pas d'image">
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('client.partials.showscript')
@endsection
