<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Ventas</title>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<h1>Reporte de Ventas</h1>

<!--FILTRO -->
<form method="GET" action="/reportes/ventas">

    Fecha inicio:
    <input type="date" name="fecha_inicio">

    Fecha fin:
    <input type="date" name="fecha_fin">

    <button type="submit">Filtrar</button>
    
    <!-- BOTÓN PDF -->
    <a href="{{ route('reportes.pdf', [
        'fecha_inicio' => request('fecha_inicio'),
        'fecha_fin' => request('fecha_fin')
    ]) }}" target="_blank">
        <button type="button">Exportar PDF</button>
    </a>

</form>

<br>

<!-- TOTAL -->
<h3>Total vendido: {{ $total }}</h3>

<br>

<!-- TABLA DE VENTAS -->
<h2>Lista de Ventas</h2>
<table border="1">
<tr>
    <th>ID</th>
    <th>Cliente</th>
    <th>Fecha</th>
    <th>Total</th>
</tr>

@foreach($ventas as $venta)
<tr>
    <td>{{ $venta->id }}</td>
    <td>{{ $venta->cliente }}</td>
    <td>{{ $venta->created_at }}</td>
    <td>{{ $venta->total }}</td>
</tr>
@endforeach

</table>

<br><br>

<!--PRODUCTOS MÁS VENDIDOS -->
<h2>Productos más vendidos</h2>

<table border="1">
<tr>
    <th>Producto</th>
    <th>Cantidad vendida</th>
</tr>

@foreach($masVendidos as $item)
<tr>
    <td>{{ $item->producto }}</td>
    <td>{{ $item->total_vendido }}</td>
</tr>
@endforeach

</table>

<br><br>

<!-- GRÁFICO -->
<h2>Ventas por día</h2>

<canvas id="graficoVentas" width="400" height="150"></canvas>

<script>
const labels = [
    @foreach($ventasPorDia as $item) 
        "{{ $item->fecha }}",
    @endforeach
];

const data = [
    @foreach($ventasPorDia as $item)
        {{ $item->total }},
    @endforeach
];

const ctx = document.getElementById('graficoVentas').getContext('2d');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Ventas por día',
            data: data,
            borderWidth: 2,
            fill: false
        }]
    },
    options: {
        responsive: true
    }
});
</script>

</body>
</html>