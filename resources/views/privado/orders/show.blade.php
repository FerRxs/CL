@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Lista de Órdenes</h2>
    <a href="{{ route('orders.create') }}" class="btn btn-primary mb-3">Agregar Orden</a>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Usuario ID</th>
                <th scope="col">Fecha</th>
                <th scope="col">Total</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <th scope="row">{{ $order->id }}</th>
                <td>{{ $order->user_id }}</td>
                <td>{{ $order->date }}</td>
                <td>${{ number_format($order->total, 2) }}</td>
                <td>{{ $order->status }}</td>
                <td>
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de querer borrar esta orden?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
    <div class="container">
        <h2>Detalles de la Orden #{{ $order->id }}</h2>
        {{-- Mostrar los detalles de la orden --}}
    </div>
@endsection
