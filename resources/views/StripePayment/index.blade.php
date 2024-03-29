@extends('layouts.master')
@section('content')
@section('extra-meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
<div class="col-md-12">
    <h1>Page de Paiement</h1>
    <div class="row">
        <div class="col-md-6">
            <form id="payment-form" class="my-4" action="{{ url('checkoutStore') }}" method="POST">
                <div id="card-element">
                    @csrf
                    <!-- placeholder pour élements -->
                </div>
                <div role="alerts"></div>
                <button type="submit" id="submit" class="btn btn-success mt-4">Procéder au
                    Payement({{ getPrice($total) }})</button>
                <p id="payment-result">
                    <!-- On passera la réponse depuis le serveur içi. -->
                </p>
            </form>
        </div>
    </div>

</div>
@include('client.partials.Stripescript')
@endsection
