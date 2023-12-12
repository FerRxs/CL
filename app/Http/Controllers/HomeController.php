<?php

namespace App\Http\Controllers;
use App\Models\Product; // o la ruta correcta si tu modelo Product está en un directorio diferente
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     public function index()
     {
         // Obtener productos activos
         $products = Product::where('status', 'Activo')->get();
         return view('publico.home', ['products' => $products]);
     }
     
     
   /*  public function index()------------------------------------ INDEX DE LA API DESCOMENTAR PARA TRAER PRODUCTOS DE LA API
    {
        $client = new Client(['base_uri' => 'https://www.themealdb.com/api/json/v1/1/']);
    
        // Aunque la API tiene una opción de obtener una comida aleatoria, la llamaremos varias veces para obtener 6 o 9.
        $meals = [];
        for ($i = 0; $i < 9; $i++) { // Cambia 6 por 9 si deseas 9 productos.
            $response = $client->request('GET', 'random.php');
            $body = $response->getBody();
            $meal = json_decode($body, true);
            $meals[] = $meal['meals'][0];
        }
    
        return view('publico.home', ['meals' => $meals]);
    } */
    /* 
    public function show($id)
    {
        $client = new Client(['base_uri' => 'https://www.themealdb.com/api/json/v1/1/']);
        $response = $client->request('GET', 'lookup.php?i=' . $id);
        $body = $response->getBody();
        $meal = json_decode($body, true);
    
        return view('publico.details', ['meal' => $meal['meals'][0]]);
    }
     */
}
