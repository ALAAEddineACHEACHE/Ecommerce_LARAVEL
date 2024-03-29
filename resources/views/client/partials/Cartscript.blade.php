@section('extra-meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('cart-script')
    <script>
        var qty = document.querySelectorAll('#qty');
        Array.from(qty).forEach((element) => {
            element.addEventListener('change', function() {
                var rowId = element.getAttribute('data-id');
                var stock = element.getAttribute('data-stock');
                var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                fetch(`/panier/${rowId}`, {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": token
                    },
                    method: 'post',
                    body: JSON.stringify({
                        qty: this.value,
                        stock: stock
                    })
                }).then((data) => {
                    console.log(data);
                    location.reload();
                }).catch((error) => {
                    console.log(error);
                });
            });
        });
    </script>
@endsection
