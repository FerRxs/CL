<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Bienvenida</title>
    <style>
        .welcome-section {
            background-color: #f8f9fa;
            padding: 50px 0;
            text-align: center;
        }

        .bg-dots-darker {
            background-image: url('path/to/dots-darker-image.jpg'); /* Reemplaza 'path/to/dots-darker-image.jpg' con la ruta de tu imagen de fondo */
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Tienda</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Álbum</a>
                    </li>
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a href="{{ url('/home') }}" class="nav-link">Home</a>
                            </li>
                        @else
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/login-google') }}"><i class="fab fa-google"></i></a>
                        </li>
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">Login</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="nav-link">Registro</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="welcome-section">
        <div class="container">
            <h1>Bienvenido a Mi Página</h1>
            <p>¡Explora nuestro álbum de fotos!</p>
        </div>
    </div>

    <div class="album py-5 bg-light">
        <div class="container">
            <!-- El código del álbum va aquí -->
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
</body>

</html>
