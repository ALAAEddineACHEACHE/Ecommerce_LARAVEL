<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe(
        'pk_test_51K5IpbFJCP30LWdTS61oqEYEfj4uOjPJknQhq6s2WUEC8GJMmnwzI9EoFWGtNeLh4D4p7u9pHWAm91DKfsVWLiVY00eJ0XzKMm'
    );

    const elements = stripe.elements();
    const cardElement = elements.create('card');;
    cardElement.mount('#card-element');
    const form = document.getElementById('payment-form');
    const resultContainer = document.getElementById('payment-result');
    cardElement.on('change', function(event) {
        if (event.error) {
            resultContainer.classList.add('alert', 'alert-warning');
            resultContainer.textContent = event.error.message;
        } else {
            resultContainer.classList.remove('alert', 'alert-warning');
            resultContainer.textContent = '';
        }
    });

    var submitButton = document.getElementById('submit');

    submitButton.addEventListener('click', function(ev) {
        ev.preventDefault();
        submitButton.disabled = true;
        stripe.confirmCardPayment("{{ $clientSecret }}", {
            payment_method: {
                card: cardElement
            }
        }).then(function(result) {
            if (result.error) {
                // Montrer l'erreur au client (ex., insuffisant fonds(ressource financière.))
                console.log(result.error.message);
            } else {
                // Le paiement a été procédé
                if (result.paymentIntent.status === 'succeeded') {
                    var paymentIntent = result.paymentIntent;
                    var token = document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content');
                    var form = document.getElementById('payment-form');
                    var url = form.action;

                    fetch(
                        url, {
                            headers: {
                                "Content-Type": "application/json",
                                "Accept": "application/json,text-plain,*/*",
                                "X-Requested-with": "XMLHttpRequest",
                                "X-CSRF-TOKEN": token
                            },
                            method: 'post',
                            body: JSON.stringify({
                                paymentIntent: paymentIntent
                            })
                        }
                    ).then((data) => {
                        if (data.status === 400) {
                            var redirect = "panier";
                        } else {
                            var redirect = "merci";
                        }
                        // console.log(data);
                        // form.reset();
                        window.location.href = redirect;
                    }).catch((error) => {
                        console.log(error)
                    })
                }
            }
        });
    });
</script>
