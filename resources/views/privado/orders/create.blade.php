@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Crear Nueva Orden</h2>
    <form method="post" action="{{ route('orders.store') }}">
        @csrf
        <div class="mb-3">
            <label for="product_id" class="form-label">Seleccionar Producto:</label>
            <select class="form-select" id="product_id" name="product_id" required>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }} - ${{ number_format($product->price, 2) }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Fecha:</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Cantidad:</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required>
        </div>
        
        <div class="mb-3">
            <label for="status" class="form-label">Estado:</label>
            <select class="form-select" id="status" name="status" required>
                <option value="Pendiente">Pendiente</option>
                <option value="Enviado">Enviado</option>
                <option value="Entregado">Entregado</option>
                <option value="Cancelado">Cancelado</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Crear Orden</button>
    </form>
</div>
@endsection
