@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="mb-4">Catálogo de Productos</h2>
            <div class="row">
                @foreach($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img class="card-img-top" src="{{ asset('storage/' . $product->image1) }}" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">${{ $product->price }}</span>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                    <input type="hidden" name="name" value="{{ $product->name }}">
                                    <input type="hidden" name="price" value="{{ $product->price }}">
                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control" style="width: 60px; display: inline-block;">
                                    <button type="submit" class="btn btn-primary">Añadir al Carrito</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection