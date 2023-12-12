@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Usuario</h2>
    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña (Dejar vacío si no desea cambiar)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Rol</label>
            <select class="form-control" id="rol" name="rol" value="{{ $user->rol }}">
                <option value="Administrador" @if($user->rol == 'Administrador') selected @endif>Administrador</option>
                <option value="Empleado" @if($user->rol == 'Empleado') selected @endif>Empleado</option>
                <option value="Cliente" @if($user->rol == 'Cliente') selected @endif>Cliente</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Estado</label>
            <select class="form-control" id="status" name="status" value="{{ $user->status }}">
                <option value="Activo" @if($user->status == 'Activo') selected @endif>Activo</option>
                <option value="Inactivo" @if($user->status == 'Inactivo') selected @endif>Inactivo</option>
                <option value="Suspendido" @if($user->status == 'Suspendido') selected @endif>Suspendido</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
