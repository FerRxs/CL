@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Crear Producto</h2>
    <div id="form-errors" class="alert alert-danger d-none"></div>
    <form id="create-product-form" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Precio</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock">
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Categoría</label>
            <select class="form-select" id="category_id" name="category_id" required>
                <!-- Las opciones de categoría se cargarán aquí -->
            </select>
        </div>
        <div class="mb-3">
            <label for="image1" class="form-label">Imagen 1</label>
            <input type="file" class="form-control" id="image1" name="image1">
        </div>
        <div class="mb-3">
            <label for="image2" class="form-label">Imagen 2</label>
            <input type="file" class="form-control" id="image2" name="image2">
        </div>
        <div class="mb-3">
            <label for="image3" class="form-label">Imagen 3</label>
            <input type="file" class="form-control" id="image3" name="image3">
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Estado</label>
            <select class="form-select" id="status" name="status" required>
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
                <option value="Descontinuado">Descontinuado</option>
            </select>
        </div>
        <button type="button" class="btn btn-primary" onclick="submitProduct()">Guardar</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        loadCategories();
    });

    function loadCategories() {
        // Cargar categorías desde la API y añadirlas al select
        fetch('http://localhost:8000/api/categories', {
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('api_token')
            }
        })
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('category_id');
            data.categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.name;
                select.appendChild(option);
            });
        })
        .catch(error => console.error('Error:', error));
    }

    function submitProduct() {
        const formData = new FormData(document.getElementById('create-product-form'));
        formData.append('name', document.getElementById('name').value);
        formData.append('description', document.getElementById('description').value);
        formData.append('price', document.getElementById('price').value);
        formData.append('stock', document.getElementById('stock').value);
        formData.append('category_id', document.getElementById('category_id').value);
        formData.append('status', document.getElementById('status').value);

        fetch('http://localhost:8000/api/products', {
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('api_token')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.error) {
                document.getElementById('form-errors').innerHTML = data.message;
                document.getElementById('form-errors').classList.remove('d-none');
            } else {
                window.location.href = '/privado/products'; // Redirige a la lista de productos
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
