@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detalles del Usuario</h2>
    <p><strong>ID:</strong> {{ $user->id }}</p>
    <p><strong>Nombre:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Rol:</strong> {{ $user->rol }}</p>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Volver a la lista</a>
</div>
@endsection
