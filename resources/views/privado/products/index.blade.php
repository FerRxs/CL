@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Lista de Productos</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Agregar Producto</a>
    <div id="products-table"></div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetchProducts();
    });

    function fetchProducts() {
        fetch('http://localhost:8000/api/products', {
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('api_token')
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data && data.products) {
                renderProducts(data.products);
            } else {
                // Manejar el caso de que no haya datos o el formato sea incorrecto
                console.error('Formato de datos incorrecto:', data);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function renderProducts(products) {
        const table = document.getElementById('products-table');
        let html = `<table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>`;

        products.forEach(product => {
            if(product) {
                html += `<tr>
                            <td>${product.id || ''}</td>
                            <td>${product.name || ''}</td>
                            <td>${product.description || ''}</td>
                            <td>${typeof product.price === 'number' ? '$' + product.price.toFixed(2) : ''}</td>
                            <td>${product.stock || ''}</td>
                            <td>${product.status || ''}</td>
                            <td>
                                <a href="/privado/products/${product.id}" class="btn btn-info btn-sm">Detalles</a>
                                <a href="/privado/products/${product.id}/edit" class="btn btn-primary btn-sm">Editar</a>
                                <button class="btn btn-danger btn-sm" onclick="deleteProduct(${product.id})">Eliminar</button>
                            </td>
                         </tr>`;
            }
        });

        html += `</tbody></table>`;
        table.innerHTML = html;
    }

    function deleteProduct(productId) {
        if (!confirm('¿Estás seguro de que quieres eliminar este producto?')) return;

        fetch('http://localhost:8000/api/products/' + productId, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('api_token')
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.error) {
                alert(data.message);
            } else {
                alert('Producto eliminado exitosamente');
                setTimeout(() => location.reload(), 2000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ocurrió un error al eliminar el producto.');
        });
    }
</script>
@endsection
