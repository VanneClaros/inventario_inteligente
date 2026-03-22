<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reportes</h2>
</x-slot>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap');
* { font-family: 'DM Sans', sans-serif; }
.rp-wrap { background: #1a1f2e; min-height: 100vh; padding: 2rem; }
.page-title { font-size: 1.6rem; font-weight: 700; color: #f0e6c8; letter-spacing: -0.03em; }
.page-title span { color: #c9a84c; }

/* FILTRO CARD */
.filter-card {
    background: #242938; border: 1px solid #2e3550;
    border-radius: 16px; padding: 1.25rem 1.5rem;
    display: flex; align-items: flex-end; gap: 1rem; flex-wrap: wrap;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 24px rgba(0,0,0,0.3);
}
.filter-label { font-size: 0.72rem; font-weight: 600; color: #8892a4; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.4rem; display: block; }
.filter-input {
    background: #1a1f2e; border: 1px solid #2e3550;
    color: #e8eaf0; border-radius: 10px; padding: 0.6rem 1rem; font-size: 0.875rem;
    outline: none; transition: border-color 0.2s;
}
.filter-input:focus { border-color: #c9a84c; box-shadow: 0 0 0 3px rgba(201,168,76,0.15); }
.btn-filtrar {
    background: #2e3550; border: 1px solid #3d4666; color: #a0a8c0;
    border-radius: 10px; padding: 0.6rem 1.25rem; font-size: 0.875rem; font-weight: 600;
    cursor: pointer; transition: all 0.15s; display: inline-flex; align-items: center; gap: 0.4rem;
    font-family: 'DM Sans', sans-serif;
}
.btn-filtrar:hover { border-color: #c9a84c; color: #c9a84c; }
.btn-pdf {
    background: linear-gradient(135deg, #c9a84c, #e8c96a);
    color: #111; border: none; border-radius: 10px;
    padding: 0.6rem 1.25rem; font-size: 0.875rem; font-weight: 700;
    cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.4rem;
    text-decoration: none;
}
.btn-pdf:hover { opacity: 0.9; color: #111; }

/* KPI TOTAL */
.kpi-total {
    background: #242938; border: 1px solid #2e3550;
    border-left: 4px solid #c9a84c;
    border-radius: 16px; padding: 1.25rem 1.5rem;
    margin-bottom: 1.5rem;
    display: flex; align-items: center; gap: 1rem;
    box-shadow: 0 4px 24px rgba(0,0,0,0.3);
}
.kpi-icon { font-size: 2rem; }
.kpi-label { font-size: 0.72rem; font-weight: 600; color: #8892a4; text-transform: uppercase; letter-spacing: 0.08em; }
.kpi-value { font-size: 1.8rem; font-weight: 700; color: #c9a84c; font-family: 'DM Mono', monospace; letter-spacing: -0.03em; }

/* TABLES */
.table-card {
    background: #242938; border: 1px solid #2e3550;
    border-radius: 16px; overflow: hidden;
    box-shadow: 0 4px 24px rgba(0,0,0,0.3);
    margin-bottom: 1.5rem;
}
.table-card-header {
    background: #111520; padding: 1rem 1.5rem;
    display: flex; align-items: center; gap: 0.5rem;
}
.table-card-title { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.12em; color: #c9a84c; }
.rp-table { width: 100%; border-collapse: collapse; }
.rp-table th { font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: #6b7280; padding: 0.85rem 1.25rem; text-align: left; border-bottom: 1px solid #2e3550; }
.rp-table td { padding: 0.85rem 1.25rem; font-size: 0.875rem; color: #c8cdd8; border-bottom: 1px solid #2a3045; }
.rp-table tbody tr:last-child td { border-bottom: none; }
.rp-table tbody tr:hover td { background: #2e3550; }
.td-id { font-family: 'DM Mono', monospace; color: #5a6280; font-size: 0.8rem; }
.td-nombre { font-weight: 600; color: #f0e6c8; }
.td-fecha { font-family: 'DM Mono', monospace; font-size: 0.78rem; color: #8892a4; }
.td-total { font-family: 'DM Mono', monospace; color: #c9a84c; font-weight: 700; }
.td-qty {
    display: inline-flex; align-items: center; justify-content: center;
    background: #1a2e25; border: 1px solid #166534; color: #86efac;
    border-radius: 999px; padding: 0.2rem 0.75rem;
    font-family: 'DM Mono', monospace; font-size: 0.72rem; font-weight: 600;
}

/* CHART CARD */
.chart-card {
    background: #242938; border: 1px solid #2e3550;
    border-radius: 16px; padding: 0;
    box-shadow: 0 4px 24px rgba(0,0,0,0.3);
    overflow: hidden;
}
.chart-body { padding: 1.5rem; }
</style>

<div class="rp-wrap">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="page-title">Reporte de <span>Ventas</span></div>
    </div>

    {{-- FILTROS --}}
    <form method="GET" action="/reportes/ventas">
        <div class="filter-card">
            <div>
                <label class="filter-label">Fecha inicio</label>
                <input type="date" name="fecha_inicio" class="filter-input" value="{{ request('fecha_inicio') }}">
            </div>
            <div>
                <label class="filter-label">Fecha fin</label>
                <input type="date" name="fecha_fin" class="filter-input" value="{{ request('fecha_fin') }}">
            </div>
            <button type="submit" class="btn-filtrar">
                <i class="bi bi-funnel"></i> Filtrar
            </button>
            <a href="{{ route('reportes.pdf', ['fecha_inicio' => request('fecha_inicio'), 'fecha_fin' => request('fecha_fin')]) }}"
                target="_blank" class="btn-pdf">
                <i class="bi bi-file-earmark-pdf"></i> Exportar PDF
            </a>
        </div>
    </form>

    {{-- KPI TOTAL --}}
    <div class="kpi-total">
        <div class="kpi-icon">💰</div>
        <div>
            <div class="kpi-label">Total vendido</div>
            <div class="kpi-value">Bs. {{ number_format($total, 2) }}</div>
        </div>
    </div>

    {{-- TABLA VENTAS --}}
    <div class="table-card">
        <div class="table-card-header">
            <i class="bi bi-receipt" style="color:#c9a84c"></i>
            <span class="table-card-title">Lista de Ventas</span>
        </div>
        <table class="rp-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ventas as $venta)
                <tr>
                    <td><span class="td-id">#{{ $venta->id }}</span></td>
                    <td><span class="td-nombre">{{ $venta->cliente }}</span></td>
                    <td><span class="td-fecha">{{ \Carbon\Carbon::parse($venta->created_at)->format('d/m/Y H:i') }}</span></td>
                    <td><span class="td-total">Bs. {{ number_format($venta->total, 2) }}</span></td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-4" style="color:#4b5563">Sin ventas en este período</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PRODUCTOS MÁS VENDIDOS --}}
    <div class="table-card">
        <div class="table-card-header">
            <i class="bi bi-trophy" style="color:#c9a84c"></i>
            <span class="table-card-title">Productos más vendidos</span>
        </div>
        <table class="rp-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Cantidad vendida</th>
                </tr>
            </thead>
            <tbody>
                @foreach($masVendidos as $i => $item)
                <tr>
                    <td><span class="td-id">{{ $i + 1 }}</span></td>
                    <td><span class="td-nombre">{{ $item->producto }}</span></td>
                    <td><span class="td-qty">{{ $item->total_vendido }} uds</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- GRÁFICO --}}
    <div class="chart-card">
        <div class="table-card-header">
            <i class="bi bi-graph-up" style="color:#c9a84c"></i>
            <span class="table-card-title">Ventas por día</span>
        </div>
        <div class="chart-body">
            <canvas id="graficoVentas" height="100"></canvas>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
const labels = [@foreach($ventasPorDia as $item)"{{ $item->fecha }}",@endforeach];
const data = [@foreach($ventasPorDia as $item){{ $item->total }},@endforeach];
const ctx = document.getElementById('graficoVentas').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Ventas por día (Bs.)',
            data: data,
            borderColor: '#c9a84c',
            backgroundColor: 'rgba(201,168,76,0.08)',
            borderWidth: 2.5,
            pointBackgroundColor: '#c9a84c',
            pointRadius: 5,
            pointHoverRadius: 7,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { labels: { color: '#8892a4', font: { family: 'DM Sans' } } }
        },
        scales: {
            x: { ticks: { color: '#6b7280' }, grid: { color: '#2a3045' } },
            y: { ticks: { color: '#6b7280' }, grid: { color: '#2a3045' } }
        }
    }
});
</script>
</x-app-layout>