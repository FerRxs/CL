@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Producto</h2>
    <div id="form-errors" class="alert alert-danger d-none"></div>
    <form id="edit-product-form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="product_id" value="{{ $product->id }}">
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description">{{ $product->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Precio</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ $product->price }}" required>
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" value="{{ $product->stock }}">
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Categoría</label>
            <select class="form-select" id="category_id" name="category_id" required>
                <!-- Las opciones de categoría se cargarán aquí -->
            </select>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Estado</label>
            <select class="form-select" id="status" name="status" required>
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
                <option value="Descontinuado">Descontinuado</option>
            </select>
        </div>
        <button type="button" class="btn btn-primary" onclick="updateProduct()">Guardar Cambios</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        loadCategories();
        setInitialValues();
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
            select.value = "{{ $product->category_id }}"; // Establece el valor inicial
        })
        .catch(error => console.error('Error:', error));
    }

    function setInitialValues() {
        document.getElementById('status').value = "{{ $product->status }}";
    }

    function updateProduct() {
        const productId = document.getElementById('product_id').value;
        const formData = new FormData(document.getElementById('edit-product-form'));
        formData.append('_method', 'PUT'); // Método HTTP falso para Laravel

        fetch('http://localhost:8000/api/products/' + productId, {
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
