@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center mb-4">{{ $meal['strMeal'] }}</h1>

            <!-- Imagen centralizada y más grande -->
            <div class="text-center">
                <img class="img-fluid rounded" style="max-width: 80%;" src="{{ $meal['strMealThumb'] }}" alt="{{ $meal['strMeal'] }}">
            </div>

           
                
                <h4>Ingredientes:</h4>
                <!-- Usar badges de Bootstrap para los ingredientes -->
                @for ($i = 1; $i <= 20; $i++)
                    @if (!empty($meal['strIngredient' . $i]))
                        <span class="badge bg-secondary m-1">{{ $meal['strIngredient' . $i] }} - {{ $meal['strMeasure' . $i] }}</span>
                    @endif
                @endfor
 <div class="mt-4">
    

                <h4>Instrucciones:</h4>
                <p>{{ $meal['strInstructions'] }}</p>
                <!-- Tarjeta para información adicional -->
                <div class="card mt-4">
                    <div class="card-body">
                        <p><strong>Categoría:</strong> {{ $meal['strCategory'] }}</p>
                        <p><strong>Área de origen:</strong> {{ $meal['strArea'] }}</p>

                        @if (!empty($meal['strYoutube']))
                            <h5 class="mt-3">Video de la receta:</h5>
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ substr($meal['strYoutube'], -11) }}" allowfullscreen></iframe>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <a href="{{ route('home') }}" class="btn btn-primary mt-4 d-block">Volver al Catálogo</a>
        </div>
    </div>
</div>

@endsection
