<form action="{{ route('products.searchshow') }}" id="search-form">
    @csrf
    <div class="form-group mb-0">
        <input type="text" name="search_product" class="form-control mr-5"
            value="{{ request()->search_product ?? '' }}" />
    </div>
    <button type="submit"><i class="fa fa-search text-info" aria-hidden="true"></i></button>


</form>
