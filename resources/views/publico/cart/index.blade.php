{{-- resources/views/publico/cart/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h2 class="my-2">Carrito de Compras</h2>
                </div>
                <div class="card-body">
                    @if($cartItems->isEmpty())
                        <p class="text-center">Tu carrito está vacío.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Imagen</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>
                                                @php $imagePath = $item->attributes->has('image') ? 'storage/' . $item->attributes->image : 'path/to/default/image.png'; @endphp
                <img src="{{ asset($imagePath) }}" alt="{{ $item->name }}" class="img-fluid" style="max-width: 100px;">
                                            </td>
                                            <td>${{ number_format($item->price, 2) }}</td>
                                            <td>
                                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control form-control-sm mx-2" style="width: 80px;">
                                                    <button type="submit" class="btn btn-outline-secondary btn-sm">Actualizar</button>
                                                </form>
                                            </td>
                                            <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                            <td>
                                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('cart.clear') }}" class="btn btn-warning btn-lg">Vaciar Carrito</a>
                            <a href="{{ route('checkout') }}" class="btn btn-success btn-lg">Proceder al Pago</a> {{-- Cambio aquí --}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
