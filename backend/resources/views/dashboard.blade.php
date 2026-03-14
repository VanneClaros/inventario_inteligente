<!DOCTYPE html>
<html>
<head>

    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    </head>

    <body class="bg-dark text-white">

    <div class="container mt-4">

    <h1 class="mb-4">Dashboard</h1>

    <div class="row">

    <div class="col-md-3">
    <div class="card bg-primary text-white">
    <div class="card-body">
    <h5>Productos</h5>
    <h3>{{ $totalProductos }}</h3>
    </div>
    </div>
    </div>

    <div class="col-md-3">
    <div class="card bg-success text-white">
    <div class="card-body">
    <h5>Clientes</h5>
    <h3>{{ $totalClientes }}</h3>
    </div>
    </div>
    </div>

    <div class="col-md-3">
    <div class="card bg-warning text-white">
    <div class="card-body">
    <h5>Ventas</h5>
    <h3>{{ $totalVentas }}</h3>
    </div>
    </div>
    </div>

    </div>

    <hr class="my-4">

    <div class="row">

    <div class="col-md-8">

    <div class="card bg-secondary">

    <div class="card-body">

    <h5>Gráfica de ventas</h5>

    <canvas id="ventasChart"></canvas>

    </div>

    </div>

    </div>

    <div class="col-md-4">

    <div class="card bg-info mb-3">

    <div class="card-body">

    <h6>Producto más vendido</h6>

    @if($productoTop)

    <p>{{ $productoTop->nombre }}</p>

    <p>{{ $productoTop->total }} vendidos</p>

    @endif

    </div>

    </div>

    <div class="card bg-success mb-3">

    <div class="card-body">

    <h6>Cliente con más compras</h6>

    @if($clienteTop)

    <p>{{ $clienteTop->nombre }}</p>

    <p>{{ $clienteTop->total }} compras</p>

    @endif

    </div>

    </div>

    <div class="card bg-danger">

    <div class="card-body">

    <h6>Stock bajo</h6>

    @foreach($stockBajo as $p)

    <p>{{ $p->nombre }} ({{ $p->stock }})</p>

    @endforeach

    </div>

    </div>

    </div>

    </div>

    </div>

    <script>

    let fechas = [];
    let totales = [];

    @foreach($ventasPorDia as $venta)

    fechas.push("{{ $venta->fecha }}");
    totales.push({{ $venta->total }});

    @endforeach

    new Chart(document.getElementById("ventasChart"),{

    type:'line',

    data:{
    labels:fechas,
    datasets:[{
    label:'Ventas',
    data:totales,
    borderWidth:2
    }]
    }

    });

</script>

</body>
</html>