<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
</x-slot>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap');
* { font-family: 'DM Sans', sans-serif; }
.dash-wrap { background: #1a1f2e; min-height: 100vh; padding: 2rem; color: #e8eaf0; }

/* TOPBAR */
.dash-topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
.dash-title { font-size: 1.6rem; font-weight: 700; color: #f0e6c8; letter-spacing: -0.03em; }
.dash-title span { color: #c9a84c; }
.dash-rol { font-family: 'DM Mono', monospace; font-size: 0.75rem; background: #242938; border: 1px solid #2e3550; color: #c9a84c; padding: 0.35rem 0.85rem; border-radius: 999px; letter-spacing: 0.08em; text-transform: uppercase; }

/* FILTROS */
.filtros { display: flex; gap: 0.5rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
.filtro-btn { font-size: 0.8rem; font-weight: 500; padding: 0.4rem 1rem; border-radius: 999px; border: 1px solid #2e3550; background: #242938; color: #8892a4; cursor: pointer; text-decoration: none; transition: all 0.2s; }
.filtro-btn:hover, .filtro-btn.active { background: linear-gradient(135deg,#c9a84c,#e8c96a); color: #111; border-color: #c9a84c; font-weight: 700; }

/* KPI */
.kpi-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
.kpi-card { background: #242938; border: 1px solid #2e3550; border-radius: 16px; padding: 1.4rem 1.6rem; position: relative; overflow: hidden; transition: transform 0.2s, border-color 0.2s; }
.kpi-card:hover { transform: translateY(-3px); border-color: #c9a84c; }
.kpi-card::before { content: ''; position: absolute; top: 0; right: 0; width: 80px; height: 80px; border-radius: 50%; background: radial-gradient(circle, rgba(201,168,76,0.08) 0%, transparent 70%); }
.kpi-icon { font-size: 1.4rem; margin-bottom: 0.8rem; }
.kpi-value { font-size: 2rem; font-weight: 700; color: #f0e6c8; letter-spacing: -0.04em; line-height: 1; margin-bottom: 0.3rem; }
.kpi-label { font-size: 0.72rem; color: #6b7280; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; }

/* TOP BANNER */
.top-banner { display: flex; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
.top-card { flex: 1; min-width: 220px; background: #242938; border: 1px solid #2e3550; border-left: 4px solid #c9a84c; border-radius: 16px; padding: 1.2rem 1.5rem; display: flex; align-items: center; gap: 1rem; }
.top-card-icon { font-size: 1.8rem; width: 48px; height: 48px; background: #1a1f2e; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.top-card-label { font-size: 0.7rem; color: #6b7280; text-transform: uppercase; letter-spacing: 0.08em; }
.top-card-value { font-size: 1rem; font-weight: 700; color: #f0e6c8; margin-top: 0.1rem; }
.top-card-value span { color: #c9a84c; font-size: 0.85rem; font-family: 'DM Mono', monospace; }

/* CARDS */
.card-dark { background: #242938; border: 1px solid #2e3550; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.3); height: 100%; }
.card-header-dark { background: #111520; padding: 0.85rem 1.25rem; display: flex; align-items: center; gap: 0.5rem; }
.card-header-title { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.12em; color: #c9a84c; }
.card-body-dark { padding: 1.25rem; }

/* TABLA VENTAS */
.mini-table { width: 100%; border-collapse: collapse; }
.mini-table th { font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.08em; color: #6b7280; padding: 0.5rem 0; border-bottom: 1px solid #2e3550; }
.mini-table td { padding: 0.65rem 0; font-size: 0.85rem; border-bottom: 1px solid #2a3045; color: #c8cdd8; }
.mini-table td:last-child { text-align: right; font-family: 'DM Mono', monospace; color: #c9a84c; font-weight: 700; }
.mini-table tr:last-child td { border-bottom: none; }

/* BARRAS */
.bar-item { margin-bottom: 0.85rem; }
.bar-header { display: flex; justify-content: space-between; margin-bottom: 0.3rem; }
.bar-name { font-size: 0.8rem; color: #c8cdd8; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 75%; }
.bar-count { font-family: 'DM Mono', monospace; font-size: 0.75rem; color: #c9a84c; font-weight: 700; }
.bar-track { background: #2e3550; border-radius: 999px; height: 5px; overflow: hidden; }
.bar-fill { height: 100%; border-radius: 999px; background: linear-gradient(90deg, #c9a84c, #e8c96a); }

/* CLIENTES */
.cliente-item { display: flex; align-items: center; gap: 0.75rem; padding: 0.6rem 0; border-bottom: 1px solid #2a3045; }
.cliente-item:last-child { border-bottom: none; }
.cli-avatar { width: 34px; height: 34px; border-radius: 50%; background: linear-gradient(135deg, #c9a84c, #e8c96a); display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; color: #111; flex-shrink: 0; }
.cli-name { font-size: 0.85rem; color: #f0e6c8; font-weight: 600; flex: 1; }
.cli-count { font-family: 'DM Mono', monospace; font-size: 0.75rem; color: #6b7280; }

/* STOCK / LOTES GRID */
.item-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(130px,1fr)); gap: 0.65rem; }
.item-pill { background: #1a1f2e; border: 1px solid #2e3550; border-radius: 12px; padding: 0.75rem; }
.item-pill-name { font-size: 0.78rem; color: #c8cdd8; margin-bottom: 0.4rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.item-pill-sub { font-size: 0.68rem; color: #6b7280; margin-bottom: 0.3rem; font-family: 'DM Mono', monospace; }
.badge-red { display: inline-flex; align-items: center; gap: 0.25rem; background: #2a1f1f; border: 1px solid #7f1d1d; color: #fca5a5; border-radius: 999px; padding: 0.2rem 0.6rem; font-size: 0.68rem; font-weight: 600; }
.badge-yellow { display: inline-flex; align-items: center; gap: 0.25rem; background: #2a1f09; border: 1px solid #92400e; color: #fcd34d; border-radius: 999px; padding: 0.2rem 0.6rem; font-size: 0.68rem; font-weight: 600; }
.badge-green { display: inline-flex; align-items: center; gap: 0.25rem; background: #1a2e25; border: 1px solid #166534; color: #86efac; border-radius: 999px; padding: 0.2rem 0.6rem; font-size: 0.68rem; font-weight: 600; }
.empty-state { text-align: center; color: #4b5563; font-size: 0.85rem; padding: 1.5rem 0; }
</style>

<div class="dash-wrap">

    <div class="dash-topbar">
        <div class="dash-title">Panel de <span>Control</span></div>
        <div class="dash-rol">{{ Auth::user()->rol }}</div>
    </div>

    <div class="filtros">
        <a href="/dashboard" class="filtro-btn {{ !request('filtro') ? 'active' : '' }}">Todo</a>
        <a href="/dashboard?filtro=dia" class="filtro-btn {{ request('filtro') == 'dia' ? 'active' : '' }}">Hoy</a>
        <a href="/dashboard?filtro=semana" class="filtro-btn {{ request('filtro') == 'semana' ? 'active' : '' }}">Esta semana</a>
        <a href="/dashboard?filtro=mes" class="filtro-btn {{ request('filtro') == 'mes' ? 'active' : '' }}">Este mes</a>
        <a href="/dashboard?filtro=anio" class="filtro-btn {{ request('filtro') == 'anio' ? 'active' : '' }}">Este año</a>
    </div>

    {{-- KPIs --}}
    <div class="kpi-grid">
        <div class="kpi-card"><div class="kpi-icon">📦</div><div class="kpi-value">{{ $totalProductos }}</div><div class="kpi-label">Productos</div></div>
        <div class="kpi-card"><div class="kpi-icon">👥</div><div class="kpi-value">{{ $totalClientes }}</div><div class="kpi-label">Clientes</div></div>
        <div class="kpi-card"><div class="kpi-icon">🧾</div><div class="kpi-value">{{ $totalVentas }}</div><div class="kpi-label">Ventas totales</div></div>
        <div class="kpi-card"><div class="kpi-icon">📅</div><div class="kpi-value">{{ number_format($ventasHoy, 0) }}</div><div class="kpi-label">Bs. vendidos hoy</div></div>
        <div class="kpi-card"><div class="kpi-icon">📊</div><div class="kpi-value">{{ number_format($promedioVenta, 0) }}</div><div class="kpi-label">Bs. promedio/venta</div></div>
    </div>

    {{-- TOP BANNER --}}
    @if($productoTop || $clienteTop)
    <div class="top-banner">
        @if($productoTop)
        <div class="top-card">
            <div class="top-card-icon">🥇</div>
            <div><div class="top-card-label">Producto más vendido</div><div class="top-card-value">{{ $productoTop->nombre }} <span>({{ $productoTop->total }} uds)</span></div></div>
        </div>
        @endif
        @if($clienteTop)
        <div class="top-card">
            <div class="top-card-icon">👑</div>
            <div><div class="top-card-label">Cliente top</div><div class="top-card-value">{{ $clienteTop->nombre }} <span>({{ $clienteTop->total }} compras)</span></div></div>
        </div>
        @endif
    </div>
    @endif

    {{-- FILA 1 --}}
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <div class="card-dark">
                <div class="card-header-dark"><i class="bi bi-graph-up" style="color:#c9a84c"></i><span class="card-header-title">Ventas por día</span></div>
                <div class="card-body-dark">
                    @if($ventasPorDia->count())
                    <table class="mini-table">
                        <thead><tr><th>Fecha</th><th style="text-align:right">Total (Bs.)</th></tr></thead>
                        <tbody>
                            @foreach($ventasPorDia as $v)
                            <tr><td>{{ $v->fecha }}</td><td>{{ number_format($v->total, 2) }}</td></tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else<div class="empty-state">Sin ventas en este período</div>@endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-dark">
                <div class="card-header-dark"><i class="bi bi-trophy" style="color:#c9a84c"></i><span class="card-header-title">Top productos</span></div>
                <div class="card-body-dark">
                    @php $maxProd = $productosVendidos->max('total') ?: 1; @endphp
                    @foreach($productosVendidos as $p)
                    <div class="bar-item">
                        <div class="bar-header"><span class="bar-name">{{ $p->nombre }}</span><span class="bar-count">{{ $p->total }}</span></div>
                        <div class="bar-track"><div class="bar-fill" style="width:{{ ($p->total/$maxProd)*100 }}%"></div></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- FILA 2 --}}
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <div class="card-dark">
                <div class="card-header-dark"><i class="bi bi-people" style="color:#c9a84c"></i><span class="card-header-title">Top clientes</span></div>
                <div class="card-body-dark">
                    @foreach($clientesTop as $c)
                    <div class="cliente-item">
                        <div class="cli-avatar">{{ strtoupper(substr($c->nombre,0,2)) }}</div>
                        <div class="cli-name">{{ $c->nombre }}</div>
                        <div class="cli-count">{{ $c->total }} compras</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-dark" style="border-color:#3f1f1f;background:#1e1313">
                <div class="card-header-dark" style="background:#0f0a0a"><i class="bi bi-x-circle" style="color:#ef4444"></i><span class="card-header-title" style="color:#ef4444">Lotes vencidos</span></div>
                <div class="card-body-dark">
                    @if($lotesVencidos->count())
                    <div class="item-grid">
                        @foreach($lotesVencidos as $lote)
                        <div class="item-pill" style="border-color:#3f1f1f">
                            <div class="item-pill-name">{{ $lote->producto->nombre ?? 'N/A' }}</div>
                            <div class="item-pill-sub">Lote #{{ $lote->id }}</div>
                            <div class="badge-red"><i class="bi bi-x-circle"></i> Venció {{ \Carbon\Carbon::parse($lote->fecha_vencimiento)->diffForHumans() }}</div>
                            <div style="font-size:0.68rem;color:#6b7280;margin-top:0.3rem">{{ $lote->cantidad }} uds</div>
                        </div>
                        @endforeach
                    </div>
                    @else<div class="empty-state">✅ Sin lotes vencidos</div>@endif
                </div>
            </div>
        </div>
    </div>

    {{-- FILA 3 --}}
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card-dark" style="border-color:#3f2e1a;background:#1a1509">
                <div class="card-header-dark" style="background:#0f0c04"><i class="bi bi-exclamation-triangle" style="color:#f59e0b"></i><span class="card-header-title" style="color:#f59e0b">Por vencer (30 días)</span></div>
                <div class="card-body-dark">
                    @if($lotesPorVencer->count())
                    <div class="item-grid">
                        @foreach($lotesPorVencer as $lote)
                        @php $dias = now()->diffInDays($lote->fecha_vencimiento); @endphp
                        <div class="item-pill" style="border-color:#3f2e1a">
                            <div class="item-pill-name">{{ $lote->producto->nombre ?? 'N/A' }}</div>
                            <div class="item-pill-sub">Lote #{{ $lote->id }}</div>
                            <div class="badge-yellow"><i class="bi bi-clock"></i> {{ $dias }} días</div>
                            <div style="font-size:0.68rem;color:#6b7280;margin-top:0.3rem">{{ $lote->cantidad }} uds</div>
                        </div>
                        @endforeach
                    </div>
                    @else<div class="empty-state">✅ Sin lotes por vencer</div>@endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-dark">
                <div class="card-header-dark"><i class="bi bi-exclamation-triangle" style="color:#c9a84c"></i><span class="card-header-title">Stock bajo</span></div>
                <div class="card-body-dark">
                    @if($stockBajo->count())
                    <div class="item-grid">
                        @foreach($stockBajo as $p)
                        <div class="item-pill">
                            <div class="item-pill-name">{{ $p->nombre }}</div>
                            <div class="badge-yellow"><i class="bi bi-exclamation-triangle"></i> {{ $p->stock }} uds</div>
                        </div>
                        @endforeach
                    </div>
                    @else<div class="empty-state">✅ Todo el stock está bien</div>@endif
                </div>
            </div>
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>