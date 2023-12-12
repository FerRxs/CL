@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Tienda</title> <!-- Cambié el nombre aquí -->

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                @auth
                    @if (auth()->user()->isAdmin() || auth()->user()->isEmployee())
                        <a class="navbar-brand" href="{{ url('/dashboard') }}">Tienda</a> <!-- Cambié el nombre aquí y vinculé al dashboard -->
                    @else
                        <a class="navbar-brand" href="{{ url('/home') }}">Tienda</a> <!-- Cambié el nombre aquí y vinculé al home para clientes -->
                    @endif
                @else
                    <a class="navbar-brand" href="{{ url('/') }}">Tienda</a> <!-- Cambié el nombre aquí y vinculé al home para visitantes -->
                @endauth
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
        
<ul class="navbar-nav me-auto">
    @auth
        @if (auth()->user()->isAdmin())
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.index') }}">Usuarios</a> <!-- Enlace visible solo para administradores -->
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/home') }}" class="btn btn-outline-primary me-2">menu principal</a> <!-- Enlace visible solo para administradores -->
            </li>
            
        @endif
        @if (auth()->user()->isAdmin() || auth()->user()->isEmployee())
            <li class="nav-item">
                <a class="nav-link" href="{{ route('categories.index') }}">Categorías</a> <!-- Enlace visible para administradores y empleados -->
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('products.index') }}">Productos</a> <!-- Enlace visible para administradores y empleados -->
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('orders.index') }}">Ordenes</a> <!-- Enlace visible para administradores y empleados -->
            </li>


        @endif
        @if (auth()->user()->isClient())
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">Inicio</a> <!-- Redirige al home para clientes -->
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" href="{{ route('cart.index') }}">
                <i class="fa fa-shopping-cart"></i> Carrito
                <span class="badge badge-pill badge-danger" id="cart-count">0</span>
            </a>
        </li>
    @endauth
</ul>



                    <!-- Right Side Of Navbar -->
<ul class="navbar-nav ms-auto">
    <!-- Authentication Links -->
    @guest
        @if (Route::has('login'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
        @endif

        <!-- Botón de Iniciar sesión con Google -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/login-google') }}"><i class="fab fa-google"></i></a>
        </li>

        @if (Route::has('register'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
        @endif
    @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

@auth
    <script>
        // Verifica que el usuario esté autenticado para hacer la llamada AJAX
        
        updateCartCount();
    
        function updateCartCount() {
            fetch('{{ url('/cart/count') }}') // Ruta que devuelve el conteo del carrito
                .then(response => response.json())
                .then(data => {
                    document.getElementById('cart-count').textContent = data.count;
                })
                .catch(error => console.error('Error al actualizar el conteo del carrito:', error));
        }
       
    </script>
     @endauth



     @yield('scripts')

</body>
</html>
