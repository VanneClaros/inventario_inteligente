<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-dark text-white">

<div class="container mt-4">

    <h2 class="text-center mb-4">📊 Dashboard</h2>

    <div class="alert alert-info text-center">
        Sistema de inventario inteligente
        
    </div>

    <!-- TARJETAS -->
    <div class="row mb-4">

        <div class="col-md-3">
            <div class="card bg-primary text-center" onclick="mostrarGrafico('productos')" style="cursor:pointer">
                <div class="card-body">
                    <h5>Productos</h5>
                    <h3>{{ $totalProductos }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-center" onclick="mostrarGrafico('clientes')" style="cursor:pointer">
                <div class="card-body">
                    <h5>Clientes</h5>
                    <h3>{{ $totalClientes }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning text-center" onclick="mostrarGrafico('ventas')" style="cursor:pointer">
                <div class="card-body">
                    <h5>Ventas</h5>
                    <h3>{{ $totalVentas }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-danger text-center">
                <div class="card-body">
                    <h5>Ventas Hoy</h5>
                    <h3>{{ $ventasHoy }}</h3>
                </div>
            </div>
        </div>

    </div>

    <!-- GRAFICO -->
    <div class="card bg-secondary">
        <div class="card-body">

            <h4 id="tituloGrafico">Estadísticas</h4>

            <!-- FILTROS -->
            <div id="filtrosVentas" style="display:none" class="mb-3">
                <a href="/dashboard?filtro=dia" class="btn btn-primary btn-sm">Hoy</a>
                <a href="/dashboard?filtro=semana" class="btn btn-success btn-sm">Semana</a>
                <a href="/dashboard?filtro=mes" class="btn btn-warning btn-sm">Mes</a>
                <a href="/dashboard?filtro=anio" class="btn btn-danger btn-sm">Año</a>
            </div>

            <canvas id="graficoPrincipal"></canvas>

            <div id="infoExtra" class="mt-4"></div>

        </div>
    </div>

</div>

<script>
let chart;

function mostrarGrafico(tipo){

    if(chart){
        chart.destroy();
    }

    let labels=[];
    let datos=[];
    let titulo="";
    let info="";

    document.getElementById("filtrosVentas").style.display="none";

    if(tipo=="productos"){
        titulo="Productos más vendidos";

        @foreach($productosVendidos as $p)
            labels.push("{{ $p->nombre }}");
            datos.push({{ $p->total }});
        @endforeach

        chart=new Chart(document.getElementById("graficoPrincipal"),{
            type:'pie',
            data:{
                labels:labels,
                datasets:[{data:datos}]
            }
        });

        info="<div class='alert alert-info'>Top: {{ $productoTop->nombre }} ({{ $productoTop->total }})</div>";
    }

    if(tipo=="clientes"){
        titulo="Clientes top";

        @foreach($clientesTop as $c)
            labels.push("{{ $c->nombre }}");
            datos.push({{ $c->total }});
        @endforeach

        chart=new Chart(document.getElementById("graficoPrincipal"),{
            type:'bar',
            data:{
                labels:labels,
                datasets:[{data:datos}]
            }
        });

        info="<div class='alert alert-success'>Top: {{ $clienteTop->nombre }}</div>";
    }

    if(tipo=="ventas"){
        titulo="Ventas";

        document.getElementById("filtrosVentas").style.display="block";

        @foreach($ventasPorDia as $v)
            labels.push("{{ $v->fecha }}");
            datos.push({{ $v->total }});
        @endforeach

        chart=new Chart(document.getElementById("graficoPrincipal"),{
            type:'line',
            data:{
                labels:labels,
                datasets:[{
                    label:'Ventas',
                    data:datos,
                    borderColor:'#ffc107',
                    fill:true
                }]
            }
        });
    }

    document.getElementById("tituloGrafico").innerText=titulo;
    document.getElementById("infoExtra").innerHTML=info;
}

//CARGA INICIAL
mostrarGrafico('ventas');

</script>

</body>
</html>