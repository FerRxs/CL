@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Finalizar Compra</h2>
    <div class="row">
        <div class="col-md-6 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Tu carrito</span>
                <span class="badge badge-secondary badge-pill">{{ Cart::getContent()->count() }}</span>
            </h4>
            <ul class="list-group mb-3">
                @foreach($cartItems as $item)
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">{{ $item->name }}</h6>
                        <small class="text-muted">Cantidad: {{ $item->quantity }}</small>
                    </div>
                    <span class="text-muted">${{ number_format($item->price, 2) }}</span>
                </li>
                @endforeach
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total (USD)</span>
                    <strong>${{ Cart::getTotal() }}</strong>
                </li>
            </ul>
        </div>
        <div class="col-md-6 order-md-1">
            <h4 class="mb-3">Información de Pago</h4>
            <form action="{{ route('payment.charge') }}" method="POST" id="payment-form">
                @csrf
                <div id="card-element" class="form-control">
                    <!-- Stripe Elements will go here -->
                </div>
                <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                <button class="btn btn-primary btn-lg btn-block mt-4" type="submit">Realizar Pago</button>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>

    // Personaliza Stripe Elements aquí
var style = {
  base: {
    color: "#32325d",
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: "antialiased",
    fontSize: "16px",
    "::placeholder": {
      color: "#aab7c4"
    }
  },
  invalid: {
    color: "#fa755a",
    iconColor: "#fa755a"
  }
};

    // Inicializar Stripe con tu clave pública
    var stripe = Stripe('{{ env('STRIPE_KEY') }}');
    var elements = stripe.elements();

    // Personaliza Stripe Elements aquí
    var card = elements.create('card', {style: style});
    card.mount('#card-element');

    // Escucha cambios en el elemento de la tarjeta y muestra errores si ocurren
    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // El formulario de pago que llama a la función stripeTokenHandler cuando se envía
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        stripe.createToken(card).then(function(result) {
            if (result.error) {
                // Informa al usuario si hay un error
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                // Si obtenemos el token, llamamos a stripeTokenHandler
                stripeTokenHandler(result.token);
            }
        });
    });

    // Función para manejar el token después de la creación
    function stripeTokenHandler(token) {
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken'); // Asegúrate de que el nombre sea 'stripeToken'
        hiddenInput.setAttribute('value', token.id); // Asigna el valor del token
        form.appendChild(hiddenInput);
        form.submit(); // Envía el formulario al servidor
    }
</script>
@endsection