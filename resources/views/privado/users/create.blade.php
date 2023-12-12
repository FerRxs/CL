@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Crear Usuario</h2>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Rol</label>
            <select class="form-control" id="rol" name="rol">
                <option value="Administrador">Administrador</option>
                <option value="Empleado">Empleado</option>
                <option value="Cliente">Cliente</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Estado</label>
            <select class="form-control" id="status" name="status">
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
                <option value="Suspendido">Suspendido</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
