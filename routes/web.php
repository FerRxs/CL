    <?php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\CategoryController;
    use App\Http\Controllers\ProductController;
    use App\Http\Controllers\OrderController;
    use App\Http\Controllers\CartController;
    use App\Http\Controllers\Auth\LoginController;
    use App\Http\Controllers\PaymentController;

    Auth::routes();

    Route::get('/', function () {
        if (auth()->check()) {
            return auth()->user()->isAdmin() ? redirect()->route('users.index') : redirect()->route('home');
        }
        return view('welcome');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/cart/count', [CartController::class, 'count']);
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
        Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
        Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

        // Nueva ruta para ir al checkout
        Route::get('/checkout', [CartController::class, 'checkoutForm'])->name('checkout');

        // Ruta para procesar el pago
        Route::post('/payment/charge', [PaymentController::class, 'charge'])->name('payment.charge');

        Route::get('/publico/orders/{order}', [OrderController::class, 'showPublic'])->name('public.orders.show');
    });

    // Rutas para la autenticación social
    Route::get('/login-google', [LoginController::class, 'redirectToGoogle']);
    Route::get('/google-callback', [LoginController::class, 'handleGoogleCallback']);

    // Rutas de la aplicación
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/details/{id}', [HomeController::class, 'show'])->name('details');

    Route::group(['middleware' => ['auth', 'checkuserrole']], function () {
        Route::resource('privado/users', UserController::class);
        Route::resource('privado/categories', CategoryController::class);
        Route::resource('privado/products', ProductController::class);
        Route::resource('privado/orders', OrderController::class);

        Route::get('/dashboard', function () {
            return view('privado.dashboard');
        })->name('dashboard');
    });
