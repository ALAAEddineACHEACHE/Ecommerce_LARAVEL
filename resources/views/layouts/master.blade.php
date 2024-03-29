<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="HTML,CSS,BOOTSTRAP,JAVASCRIPT,LARAVEL">
    <meta name="description" content="e-commerce Cartmax">
    @yield('extra-meta')
    <title>Ecommerce Website</title>
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

    <div class="container">
        <!-- ***** Header Area ***** -->
        <header>
            <div class="blog-header py-3 row flex-nowrap justify-content-between align-items-center">
                <div class="col-4 pt-1">
                    <a title="regarder ton panier" class="text-muted" href="{{ url('panier') }}">Panier <span
                            class="badge badge-pill badge-info text-white">{{ Cart::count() }}</span></a>
                </div>
                <div class="col-4 text-center">
                    <a title="revenir vers la page d'acceuil" class="blog-header-logo text-info"
                        href="{{ route('products.index') }}">🛍️ Cartmax</a>
                </div>
                <div class="col-4 d-flex justify-content-end align-items-center">
                    @include('client.partials.search')
                    @include('client.partials.auth')
                </div>
            </div>
        </header>

        <div class="nav-scroller py-1 mb-2">
            <nav class="nav d-flex justify-content-between">
                @foreach (App\Models\Category::all() as $category)
                    <a title="aller vers cette catégorie" class="p-2 text-muted"
                        href="{{ route('products.index', ['categorie' => $category->slug]) }}">{{ $category->name }}</a>
                @endforeach
            </nav>
        </div>
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul class="mb-0 mt-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- ***** Main Area ***** -->
    <main class="container">
        @if (request()->input())
            <h6>{{ $products->total() }} résultat (s) pour la recherche "{{ request()->search_product }}"</h6>
        @endif
        <div class="row mb-2">
            @yield('content')
        </div>
    </main>

    <!-- ***** Footer Area ***** -->
    @include('client.partials.footer')

    <!-- ***** Script Area ***** -->
    @yield('extra-js')
    @yield('cart-script')

</body>

</html>
