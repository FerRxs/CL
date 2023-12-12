<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class MealController extends Controller
{
    public function index()
    {
        $client = new Client(['base_uri' => 'https://www.themealdb.com/api/json/v1/1/']);
        $response = $client->request('GET', 'random.php');
        $body = $response->getBody();
        $meals = json_decode($body, true);

        return view('publico.meals.index', ['meals' => $meals['meals']]);
    }

public function show($id)
{
    $client = new Client();
    $response = $client->get('https://www.themealdb.com/api/json/v1/1/lookup.php?i=' . $id);
    $meal = json_decode($response->getBody())->meals[0];

    return view('publico.meals.show', compact('meal'));
}
}
