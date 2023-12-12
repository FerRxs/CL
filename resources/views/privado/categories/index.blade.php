@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Categorías</h2>
    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Crear Categoría</a>
    <div id="delete-success" class="alert alert-success d-none"></div>
    <div id="categories-table"></div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetchCategories();
    });

    function fetchCategories() {
        fetch('http://localhost:8000/api/categories', {
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('api_token')
            }
        })
        .then(response => response.json())
        .then(data => {
            renderCategories(data.categories);
        })
        .catch(error => console.error('Error:', error));
    }

    function renderCategories(categories) {
        const table = document.getElementById('categories-table');
        let html = `<table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>`;
        categories.forEach(category => {
            html += `<tr>
                        <td>${category.id}</td>
                        <td>${category.name}</td>
                        <td>${category.description}</td>
                        <td>${category.status}</td>
                        <td>
                            <a href="/privado/categories/${category.id}" class="btn btn-info btn-sm">Detalles</a>
                            <a href="/privado/categories/${category.id}/edit" class="btn btn-primary btn-sm">Editar</a>
                            <button class="btn btn-danger delete-category-btn" data-id="${category.id}">Eliminar</button>
                        </td>
                     </tr>`;
        });
        html += `</tbody></table>`;
        table.innerHTML = html;
        attachDeleteEvent();
    }

    function attachDeleteEvent() {
        document.querySelectorAll('.delete-category-btn').forEach(button => {
            button.addEventListener('click', function() {
                const categoryId = this.getAttribute('data-id');
                deleteCategory(categoryId);
            });
        });
    }

    function deleteCategory(categoryId) {
    if (!confirm('¿Estás seguro de que quieres eliminar esta categoría?')) return;

    fetch('http://localhost:8000/api/categories/' + categoryId, {
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
            document.getElementById('delete-success').innerHTML = 'Categoría eliminada exitosamente';
            document.getElementById('delete-success').classList.remove('d-none');
            setTimeout(() => location.reload(), 2000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ocurrió un error al eliminar la categoría.');
    });
}
</script>
@endsection