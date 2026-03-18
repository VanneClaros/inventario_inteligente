<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>REPORTE DE VENTAS</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 80px;
        }

        h1 {
            margin: 5px;
        }

        .info {
            margin-bottom: 15px;
        }

        .total {
            margin: 15px 0;
            font-size: 18px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: center;
        }

        th {
            background: #f2f2f2;
        }

        .section-title {
            margin-top: 25px;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>

<body>

<!-- 🔥 HEADER CON LOGO -->
<div class="header">
    <img src="{{ public_path('logo.png') }}" class="logo">
    <h1>REPORTE DE VENTAS</h1>
    <p>Sistema de Inventario</p>
</div>

<!-- FILTRO -->
<div class="info">
    @if(request('fecha_inicio') && request('fecha_fin'))
        <p><strong>Desde:</strong> {{ request('fecha_inicio') }}</p>
        <p><strong>Hasta:</strong> {{ request('fecha_fin') }}</p>
    @endif
</div>

<!-- TOTAL -->
<div class="total">
    Total vendido: Bs {{ $total }}
</div>

<!-- TABLA DE VENTAS -->
<div class="section-title">Detalle de Ventas</div>

<table>
    <tr>
        <th>ID</th>
        <th>Fecha</th>
        <th>Cliente</th>
        <th>Total</th>
    </tr>

    @foreach($ventas as $venta)
    <tr>
        <td>{{ $venta->id }}</td>
        <td>{{ $venta->created_at }}</td>
        <td>{{ $venta->cliente }}</td>
        <td>{{ $venta->total }}</td>
    </tr>
    @endforeach
</table>

<!-- 🔥 PRODUCTOS MÁS VENDIDOS -->
<div class="section-title">Productos Más Vendidos</div>

<table>
    <tr>
        <th>Producto</th>
        <th>Cantidad Vendida</th>
    </tr>

    @foreach($masVendidos as $producto)
    <tr>
        <td>{{ $producto->producto }}</td>
        <td>{{ $producto->total_vendido }}</td>
    </tr>
    @endforeach
</table>

</body>
</html>