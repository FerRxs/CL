<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;  // Importa la fachada Auth
use Illuminate\Support\Facades\Hash;  // Importa la fachada Hash
use Illuminate\Support\Str;  // Importa el facade Str
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;  // Asegúrate de que esta ruta sea correcta


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    
    public function redirectToGoogle()
{
    return Socialite::driver('google')->redirect();
}
public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

    $user = User::firstOrCreate(
        ['email' => $googleUser->getEmail()],
        [
            'name' => $googleUser->getName(),
            'password' => Hash::make(Str::random(24)),  
            'rol' => 'cliente',
            'provider' => 'google'  // Añade esta línea
        ]
    );


        Auth::login($user, true);

        return redirect()->route('home');
    }
    
}
