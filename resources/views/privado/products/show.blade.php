@extends('layouts.app')

@section('content')
<div class="container">
    <div id="product-details"></div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productId = {{ $product->id }};
        fetchProductDetails(productId);
    });

    function fetchProductDetails(productId) {
        fetch('http://localhost:8000/api/products/' + productId, {
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('api_token')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data && data.product) {
                renderProductDetails(data.product);
            } else {
                console.error('No se encontró el producto:', data);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function renderProductDetails(product) {
        const container = document.getElementById('product-details');
        container.innerHTML = `
            <div class="card">
                <div class="card-header">Detalle del Producto</div>
                <div class="card-body">
                    <h5 class="card-title">${product.name}</h5>
                    <p class="card-text">${product.description}</p>
                    <p class="card-text">Precio: $${product.price}</p>
                    <p class="card-text">Stock: ${product.stock}</p>
                    <p class="card-text">Categoría: ${product.category_id}</p>
                    <p class="card-text">Estado: ${product.status}</p>
                    <div class="product-images">
                        ${renderProductImages(product)}
                    </div>
                    <a href="/privado/products/${product.id}/edit" class="btn btn-primary">Editar</a>
                    <a href="/privado/products" class="btn btn-secondary">Volver a la Lista</a>
                </div>
            </div>
        `;
    }

    function renderProductImages(product) {
        let imagesHtml = '';
        if (product.image1_url) {
            imagesHtml += `<img src="${product.image1_url}" alt="Imagen 1" class="img-thumbnail" style="max-width: 100px;">`;
        }
        if (product.image2_url) {
            imagesHtml += `<img src="${product.image2_url}" alt="Imagen 2" class="img-thumbnail" style="max-width: 100px;">`;
        }
        if (product.image3_url) {
            imagesHtml += `<img src="${product.image3_url}" alt="Imagen 3" class="img-thumbnail" style="max-width: 100px;">`;
        }
        return imagesHtml;
    }

</script>
@endsection
