@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Orden</h2>
    <form method="post" action="{{ route('orders.update', $order->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="user_id" class="form-label">Usuario ID:</label>
            <input type="text" class="form-control" id="user_id" name="user_id" value="{{ $order->user_id }}" required>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Fecha:</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ $order->date }}" required>
        </div>
        <div class="mb-3">
            <label for="total" class="form-label">Total:</label>
            <input type="number" class="form-control" id="total" name="total" value="{{ $order->total }}" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Estado:</label>
            <select class="form-select" id="status" name="status" required>
                <option value="Pendiente" {{ $order->status == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="Enviado" {{ $order->status == 'Enviado' ? 'selected' : '' }}>Enviado</option>
                <option value="Entregado" {{ $order->status == 'Entregado' ? 'selected' : '' }}>Entregado</option>
                <option value="Cancelado" {{ $order->status == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Orden</button>
    </form>
</div>
@endsection
