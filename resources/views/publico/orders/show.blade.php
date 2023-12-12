{{-- resources/views/publico/orders/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Resumen de Pedido</h2>
    <div class="card">
        <div class="card-header">Pedido #{{ $order->id }}</div>
        <div class="card-body">
            <h5 class="card-title">Estado del Pedido: {{ $order->status }}</h5>
            <p class="card-text">Fecha del Pedido: {{$order->date}}</p>
            <p class="card-text">Total del Pedido: ${{ number_format($order->total, 2) }}</p>

            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderDetails as $detail)
                        <tr>
                            <td>{{ $detail->product->name }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>${{ number_format($detail->unit_price, 2) }}</td>
                            <td>${{ number_format($detail->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <a href="{{ url('/home') }}" class="btn btn-primary">Volver</a>
        </div>
    </div>
</div>
@endsection
