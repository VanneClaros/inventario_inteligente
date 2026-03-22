<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
</x-slot>

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap');

.dash-wrap {
    font-family: 'DM Sans', sans-serif;
    background: #0f1117;
    min-height: 100vh;
    padding: 2rem;
    color: #e8eaf0;
}
.dash-topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2.5rem;
}
.dash-title { font-size: 1.6rem; font-weight: 700; letter-spacing: -0.03em; color: #fff; }
.dash-title span { color: #6ee7b7; }
.dash-rol {
    font-family: 'DM Mono', monospace;
    font-size: 0.75rem;
    background: #1e2130;
    border: 1px solid #2e3347;
    color: #6ee7b7;
    padding: 0.35rem 0.85rem;
    border-radius: 999px;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}
.filtros { display: flex; gap: 0.5rem; margin-bottom: 2rem; flex-wrap: wrap; }
.filtro-btn {
    font-family: 'DM Sans', sans-serif;
    font-size: 0.8rem;
    font-weight: 500;
    padding: 0.4rem 1rem;
    border-radius: 999px;
    border: 1px solid #2e3347;
    background: #1e2130;
    color: #9ca3af;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s;
}
.filtro-btn:hover, .filtro-btn.active {
    background: #6ee7b7;
    color: #0f1117;
    border-color: #6ee7b7;
    font-weight: 600;
}
.kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}
.kpi-card {
    background: #1e2130;
    border: 1px solid #2e3347;
    border-radius: 16px;
    padding: 1.4rem 1.6rem;
    position: relative;
    overflow: hidden;
    transition: transform 0.2s, border-color 0.2s;
}
.kpi-card:hover { transform: translateY(-3px); border-color: #6ee7b7; }
.kpi-icon { font-size: 1.4rem; margin-bottom: 0.8rem; }
.kpi-value { font-size: 2rem; font-weight: 700; color: #fff; letter-spacing: -0.04em; line-height: 1; margin-bottom: 0.3rem; }
.kpi-label { font-size: 0.75rem; color: #6b7280; font-weight: 500; text-transform: uppercase; letter-spacing: 0.06em; }
.main-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem; }
@media (max-width: 768px) { .main-grid { grid-template-columns: 1fr; } }
.card { background: #1e2130; border: 1px solid #2e3347; border-radius: 16px; padding: 1.5rem; }
.card-title {
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #6b7280;
    margin-bottom: 1.2rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.card-title::after { content: ''; flex: 1; height: 1px; background: #2e3347; }
.ventas-table { width: 100%; border-collapse: collapse; }
.ventas-table th { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.08em; color: #6b7280; text-align: left; padding: 0.4rem 0; border-bottom: 1px solid #2e3347; }
.ventas-table td { padding: 0.65rem 0; font-size: 0.875rem; border-bottom: 1px solid #1a1e2e; color: #d1d5db; }
.ventas-table td:last-child { text-align: right; font-family: 'DM Mono', monospace; font-size: 0.8rem; color: #6ee7b7; }
.ventas-table tr:last-child td { border-bottom: none; }
.bar-item { margin-bottom: 0.85rem; }
.bar-header { display: flex; justify-content: space-between; margin-bottom: 0.3rem; }
.bar-name { font-size: 0.8rem; color: #d1d5db; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 70%; }
.bar-count { font-family: 'DM Mono', monospace; font-size: 0.75rem; color: #6ee7b7; }
.bar-track { background: #2e3347; border-radius: 999px; height: 5px; overflow: hidden; }
.bar-fill { height: 100%; border-radius: 999px; background: linear-gradient(90deg, #6ee7b7, #34d399); }
.cliente-item { display: flex; align-items: center; gap: 0.75rem; padding: 0.6rem 0; border-bottom: 1px solid #1a1e2e; }
.cliente-item:last-child { border-bottom: none; }
.cliente-avatar { width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #6ee7b7, #3b82f6); display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; color: #0f1117; flex-shrink: 0; }
.cliente-name { font-size: 0.85rem; color: #d1d5db; flex: 1; }
.cliente-count { font-family: 'DM Mono', monospace; font-size: 0.75rem; color: #6b7280; }
.stock-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 0.75rem; }
.stock-item { background: #2a1f1f; border: 1px solid #3f2a2a; border-radius: 12px; padding: 0.85rem; transition: border-color 0.2s; }
.stock-nombre { font-size: 0.8rem; color: #d1d5db; margin-bottom: 0.4rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.stock-badge { display: inline-flex; align-items: center; gap: 0.3rem; background: #3f1f1f; border: 1px solid #7f1d1d; border-radius: 999px; padding: 0.2rem 0.6rem; font-family: 'DM Mono', monospace; font-size: 0.7rem; color: #fca5a5; }
.empty-state { text-align: center; color: #4b5563; font-size: 0.85rem; padding: 1.5rem 0; }
.top-banner { display: flex; gap: 1rem; margin-bottom: 1rem; }
.top-card { flex: 1; background: linear-gradient(135deg, #1e2130, #16213e); border: 1px solid #2e3347; border-radius: 16px; padding: 1.2rem 1.5rem; display: flex; align-items: center; gap: 1rem; }
.top-card-icon { font-size: 1.8rem; width: 48px; height: 48px; background: #0f1117; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.top-card-label { font-size: 0.7rem; color: #6b7280; text-transform: uppercase; letter-spacing: 0.08em; }
.top-card-value { font-size: 1rem; font-weight: 600; color: #fff; margin-top: 0.1rem; }
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

    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-icon">📦</div>
            <div class="kpi-value">{{ $totalProductos }}</div>
            <div class="kpi-label">Productos</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon">👥</div>
            <div class="kpi-value">{{ $totalClientes }}</div>
            <div class="kpi-label">Clientes</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon">🧾</div>
            <div class="kpi-value">{{ $totalVentas }}</div>
            <div class="kpi-label">Ventas totales</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon">📅</div>
            <div class="kpi-value">{{ number_format($ventasHoy, 0) }}</div>
            <div class="kpi-label">Bs. vendidos hoy</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon">📊</div>
            <div class="kpi-value">{{ number_format($promedioVenta, 0) }}</div>
            <div class="kpi-label">Bs. promedio/venta</div>
        </div>
    </div>

    @if($productoTop || $clienteTop)
    <div class="top-banner">
        @if($productoTop)
        <div class="top-card">
            <div class="top-card-icon">🥇</div>
            <div>
                <div class="top-card-label">Producto más vendido</div>
                <div class="top-card-value">{{ $productoTop->nombre }} <span style="color:#6ee7b7;font-size:0.85rem">({{ $productoTop->total }} uds)</span></div>
            </div>
        </div>
        @endif
        @if($clienteTop)
        <div class="top-card">
            <div class="top-card-icon">👑</div>
            <div>
                <div class="top-card-label">Cliente top</div>
                <div class="top-card-value">{{ $clienteTop->nombre }} <span style="color:#6ee7b7;font-size:0.85rem">({{ $clienteTop->total }} compras)</span></div>
            </div>
        </div>
        @endif
    </div>
    @endif

    <div class="main-grid">
        <div class="card">
            <div class="card-title">📈 Ventas por día</div>
            @if($ventasPorDia->count())
            <table class="ventas-table">
                <thead><tr><th>Fecha</th><th style="text-align:right">Total (Bs.)</th></tr></thead>
                <tbody>
                    @foreach($ventasPorDia as $v)
                    <tr><td>{{ $v->fecha }}</td><td>{{ number_format($v->total, 2) }}</td></tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">Sin ventas en este período</div>
            @endif
        </div>

        <div class="card">
            <div class="card-title">🏆 Top productos</div>
            @php $maxProd = $productosVendidos->max('total') ?: 1; @endphp
            @foreach($productosVendidos as $p)
            <div class="bar-item">
                <div class="bar-header">
                    <span class="bar-name">{{ $p->nombre }}</span>
                    <span class="bar-count">{{ $p->total }}</span>
                </div>
                <div class="bar-track">
                    <div class="bar-fill" style="width:{{ ($p->total / $maxProd) * 100 }}%"></div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="card">
            <div class="card-title">👥 Top clientes</div>
            @foreach($clientesTop as $c)
            <div class="cliente-item">
                <div class="cliente-avatar">{{ strtoupper(substr($c->nombre, 0, 2)) }}</div>
                <div class="cliente-name">{{ $c->nombre }}</div>
                <div class="cliente-count">{{ $c->total }} compras</div>
            </div>
            @endforeach
        </div>

        <div class="card" style="border-color:#3f1f1f;background:#1a0f0f">
            <div class="card-title" style="color:#ef4444">🚫 Lotes vencidos</div>
            @if($lotesVencidos->count())
            <div class="stock-grid">
                @foreach($lotesVencidos as $lote)
                <div class="stock-item">
                    <div class="stock-nombre">{{ $lote->producto->nombre ?? 'N/A' }}</div>
                    <div style="font-size:0.7rem;color:#9ca3af;margin-bottom:0.3rem">Lote #{{ $lote->id }}</div>
                    <div class="stock-badge" style="background:#3f1f1f;border-color:#7f1d1d;color:#fca5a5">
                        🚫 Venció {{ \Carbon\Carbon::parse($lote->fecha_vencimiento)->diffForHumans() }}
                    </div>
                    <div style="font-size:0.7rem;color:#6b7280;margin-top:0.3rem">Stock: {{ $lote->cantidad }} uds</div>
                </div>
                @endforeach
            </div>
            @else
            <div class="empty-state">✅ Sin lotes vencidos</div>
            @endif
        </div>
    </div>

    <div class="main-grid">
        <div class="card" style="border-color:#3f2e1a;background:#1a1509">
            <div class="card-title" style="color:#f59e0b">⏳ Por vencer (30 días)</div>
            @if($lotesPorVencer->count())
            <div class="stock-grid">
                @foreach($lotesPorVencer as $lote)
                @php $dias = now()->diffInDays($lote->fecha_vencimiento); @endphp
                <div class="stock-item" style="background:{{ $dias <= 7 ? '#2a1f0f' : '#1a1a0f' }};border-color:{{ $dias <= 7 ? '#92400e' : '#3f3a1a' }}">
                    <div class="stock-nombre">{{ $lote->producto->nombre ?? 'N/A' }}</div>
                    <div style="font-size:0.7rem;color:#9ca3af;margin-bottom:0.3rem">Lote #{{ $lote->id }}</div>
                    <div class="stock-badge" style="background:#3f2e1a;border-color:#92400e;color:#fcd34d">⏳ {{ $dias }} días</div>
                    <div style="font-size:0.7rem;color:#6b7280;margin-top:0.3rem">Stock: {{ $lote->cantidad }} uds</div>
                </div>
                @endforeach
            </div>
            @else
            <div class="empty-state">✅ Sin lotes por vencer</div>
            @endif
        </div>
        
        <div class="card">
            <div class="card-title">⚠️ Stock bajo</div>
            @if($stockBajo->count())
            <div class="stock-grid">
                @foreach($stockBajo as $p)
                <div class="stock-item">
                    <div class="stock-nombre">{{ $p->nombre }}</div>
                    <div class="stock-badge">⚠ {{ $p->stock }} uds</div>
                </div>
                @endforeach
            </div>
            @else
            <div class="empty-state">✅ Todo el stock está bien</div>
            @endif
        </div>
    </div>

</div>
</x-app-layout>
