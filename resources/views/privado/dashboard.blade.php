@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Panel Administrativo</h2>

    <!-- Estadísticas Ficticias (Datos de Ejemplo) -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Usuarios Registrados</h5>
                    <h2 class="card-text">123</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Categorías</h5>
                    <h2 class="card-text">45</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Productos</h5>
                    <h2 class="card-text">678</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico de Barras (Dato Aleatorio) -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Ventas Mensuales</h5>
            <canvas id="ventasChart" width="400" height="200"></canvas>
        </div>
    </div>

    <!-- Tarjetas de Últimos Pedidos (Datos de Ejemplo) -->
    <h4 class="mb-3">Últimos Pedidos</h4>
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Pedido #1234</h5>
                    <p class="card-text">Fecha: 2023-11-01</p>
                    <p class="card-text">Total: $245.50</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Pedido #5678</h5>
                    <p class="card-text">Fecha: 2023-11-02</p>
                    <p class="card-text">Total: $128.75</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Pedido #9101</h5>
                    <p class="card-text">Fecha: 2023-11-03</p>
                    <p class="card-text">Total: $315.20</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
<script>
    // Datos Ficticios para el Gráfico de Barras
    var ctx = document.getElementById('ventasChart').getContext('2d');
    var ventasChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
            datasets: [{
                label: 'Ventas',
                data: [300, 450, 600, 550, 700, 900],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>
@endsection
