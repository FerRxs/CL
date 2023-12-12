@extends('layouts.app')

@section('content')
<div class="container">
    <div id="category-details"></div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categoryId = {{ $category->id }};
        fetchCategoryDetails(categoryId);
    });

    function fetchCategoryDetails(categoryId) {
        fetch('http://localhost:8000/api/categories/' + categoryId, {
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('api_token')
            }
        })
        .then(response => response.json())
        .then(data => {
            renderCategoryDetails(data.category);
        })
        .catch(error => console.error('Error:', error));
    }

    function renderCategoryDetails(category) {
        const container = document.getElementById('category-details');
        container.innerHTML = `
            <div class="card">
                <div class="card-header">Detalle de la Categoría</div>
                <div class="card-body">
                    <h5 class="card-title">${category.name}</h5>
                    <p class="card-text">${category.description}</p>
                    <p class="card-text"><small class="text-muted">Estado: ${category.status}</small></p>
                    <a href="/privado/categories/${category.id}/edit" class="btn btn-primary">Editar</a>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Volver a la Lista</a>
                </div>
            </div>
        `;
    }
</script>
@endsection
