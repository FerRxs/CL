@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Lista de Usuarios</h2>
    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Agregar Usuario</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->rol }}</td>
                <td>
                    <a href="{{ route('users.show', $user) }}" class="btn btn-info">Ver</a>
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
