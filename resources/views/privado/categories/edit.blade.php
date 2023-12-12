@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Categoría</h2>
    <div id="form-errors" class="alert alert-danger d-none"></div>
    <div class="mb-3">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Descripción</label>
        <textarea class="form-control" id="description" name="description">{{ $category->description }}</textarea>
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">Estado</label>
        <select class="form-control" id="status" name="status">
            <option value="Activo" {{ $category->status == 'Activo' ? 'selected' : '' }}>Activo</option>
            <option value="Inactivo" {{ $category->status == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>
    <button type="button" class="btn btn-primary" onclick="updateCategory({{ $category->id }})">Guardar</button>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancelar</a>
</div>
@endsection

@section('scripts')
<script>
    function updateCategory(categoryId) {
        const name = document.getElementById('name').value;
        const description = document.getElementById('description').value;
        const status = document.getElementById('status').value;

        fetch('http://localhost:8000/api/categories/' + categoryId, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('api_token')
            },
            body: JSON.stringify({ name, description, status })
        })
        .then(response => response.json())
        .then(data => {
            if(data.error) {
                document.getElementById('form-errors').innerHTML = data.message;
                document.getElementById('form-errors').classList.remove('d-none');
            } else {
                window.location.href = '/privado/categories'; // Redirige a la lista de categorías
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('form-errors').innerHTML = 'Ocurrió un error al enviar el formulario.';
            document.getElementById('form-errors').classList.remove('d-none');
        });
    }
</script>
@endsection
