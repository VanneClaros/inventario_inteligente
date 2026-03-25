<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Panel de Inteligencia Artificial</h2>
</x-slot>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap');
* { font-family: 'DM Sans', sans-serif; }
.dash-wrap { background: #1a1f2e; min-height: 100vh; padding: 2rem; color: #e8eaf0; }
.dash-topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
.dash-title { font-size: 1.6rem; font-weight: 700; color: #f0e6c8; letter-spacing: -0.03em; }
.dash-title span { color: #c9a84c; }
.dash-rol { font-family: 'DM Mono', monospace; font-size: 0.75rem; background: #242938; border: 1px solid #2e3550; color: #c9a84c; padding: 0.35rem 0.85rem; border-radius: 999px; letter-spacing: 0.08em; text-transform: uppercase; }

/* TABS */
.ia-tabs { display: flex; gap: 0.4rem; margin-bottom: 1.5rem; background: #111520; border-radius: 14px; padding: 0.4rem; width: fit-content; }
.ia-tab { font-size: 0.82rem; font-weight: 600; padding: 0.5rem 1.2rem; border-radius: 10px; border: none; background: transparent; color: #6b7280; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 0.4rem; }
.ia-tab:hover { color: #c8cdd8; }
.ia-tab.active { background: linear-gradient(135deg, #c9a84c, #e8c96a); color: #111; }

/* IA BANNER */
.ia-banner { background: linear-gradient(135deg, #1e2435 0%, #242938 50%, #1a1f2e 100%); border: 1px solid #c9a84c33; border-left: 4px solid #c9a84c; border-radius: 16px; padding: 1.2rem 1.5rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1.2rem; }
.ia-banner-icon { width: 48px; height: 48px; background: linear-gradient(135deg, #c9a84c, #e8c96a); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0; }
.ia-banner-title { font-size: 1rem; font-weight: 700; color: #f0e6c8; }
.ia-banner-sub { font-size: 0.78rem; color: #6b7280; margin-top: 0.15rem; }
.ia-status { margin-left: auto; display: flex; align-items: center; gap: 0.5rem; font-size: 0.72rem; color: #86efac; font-family: 'DM Mono', monospace; }
.ia-status-dot { width: 8px; height: 8px; border-radius: 50%; background: #22c55e; animation: pulse 2s infinite; }
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.4} }
@keyframes spin { to { transform: rotate(360deg); } }

/* KPI */
.kpi-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
.kpi-card { background: #242938; border: 1px solid #2e3550; border-radius: 16px; padding: 1.2rem 1.4rem; transition: transform 0.2s, border-color 0.2s; }
.kpi-card:hover { transform: translateY(-3px); border-color: #c9a84c; }
.kpi-icon { font-size: 1.3rem; margin-bottom: 0.6rem; }
.kpi-value { font-size: 1.8rem; font-weight: 700; color: #f0e6c8; letter-spacing: -0.04em; line-height: 1; margin-bottom: 0.2rem; }
.kpi-label { font-size: 0.68rem; color: #6b7280; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; }

/* CARDS */
.card-dark { background: #242938; border: 1px solid #2e3550; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.3); }
.card-header-dark { background: #111520; padding: 0.85rem 1.25rem; display: flex; align-items: center; justify-content: space-between; }
.card-header-left { display: flex; align-items: center; gap: 0.5rem; }
.card-header-title { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.12em; color: #c9a84c; }
.card-body-dark { padding: 1.25rem; }

/* BTN */
.btn-ia { background: linear-gradient(135deg, #c9a84c, #e8c96a); color: #111; border: none; border-radius: 8px; padding: 0.35rem 0.9rem; font-size: 0.75rem; font-weight: 700; cursor: pointer; transition: opacity 0.2s; }
.btn-ia:hover { opacity: 0.85; }

/* ALERTAS */
.alerta-item { display: flex; align-items: flex-start; gap: 0.85rem; padding: 0.85rem; border-radius: 12px; margin-bottom: 0.6rem; border: 1px solid; transition: transform 0.15s; }
.alerta-item:hover { transform: translateX(3px); }
.alerta-item:last-child { margin-bottom: 0; }
.alerta-alta { background: #1f0f0f; border-color: #7f1d1d; }
.alerta-media { background: #1a1509; border-color: #92400e; }
.alerta-baja { background: #0f1a14; border-color: #166534; }
.alerta-icon { width: 34px; height: 34px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 0.95rem; flex-shrink: 0; }
.alerta-icon-alta { background: #3f1f1f; }
.alerta-icon-media { background: #3f2e1a; }
.alerta-icon-baja { background: #1a3f2a; }
.alerta-tipo { font-size: 0.63rem; font-family: 'DM Mono', monospace; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.2rem; }
.alerta-tipo-alta { color: #fca5a5; }
.alerta-tipo-media { color: #fcd34d; }
.alerta-tipo-baja { color: #86efac; }
.alerta-msg { font-size: 0.8rem; color: #c8cdd8; line-height: 1.4; }
.badge-pr { font-size: 0.6rem; font-weight: 700; padding: 0.12rem 0.45rem; border-radius: 999px; margin-left: auto; flex-shrink: 0; font-family: 'DM Mono', monospace; }
.badge-alta { background: #7f1d1d; color: #fca5a5; }
.badge-media { background: #92400e; color: #fcd34d; }
.badge-baja { background: #166534; color: #86efac; }

/* PREDICCION */
.pred-card { background: #1a1f2e; border: 1px solid #2e3550; border-radius: 12px; padding: 1rem 1.2rem; margin-bottom: 0.6rem; display: flex; align-items: center; gap: 1rem; transition: border-color 0.2s; }
.pred-card:hover { border-color: #c9a84c44; }
.pred-nombre { font-size: 0.85rem; font-weight: 600; color: #f0e6c8; }
.pred-stock { font-size: 0.7rem; color: #6b7280; margin-top: 0.15rem; }
.pred-obs { font-size: 0.72rem; color: #6b7280; margin-top: 0.25rem; font-style: italic; }
.pred-valor { font-family: 'DM Mono', monospace; font-size: 1.2rem; font-weight: 700; color: #c9a84c; }
.pred-sub { font-size: 0.63rem; color: #6b7280; text-align: right; }
.confianza-bar { width: 60px; height: 4px; background: #2e3550; border-radius: 999px; overflow: hidden; margin-top: 0.3rem; margin-left: auto; }
.confianza-fill { height: 100%; background: linear-gradient(90deg, #c9a84c, #e8c96a); border-radius: 999px; }
.tend-badge { font-size: 0.65rem; padding: 0.18rem 0.5rem; border-radius: 999px; font-weight: 600; display: inline-block; margin-top: 0.25rem; }
.tend-creciente { background: #1a3f2a; color: #86efac; }
.tend-estable { background: #242938; color: #8892a4; border: 1px solid #2e3550; }
.tend-decreciente { background: #3f1f1f; color: #fca5a5; }

/* RIESGO */
.riesgo-card { background: #1a1f2e; border: 1px solid #2e3550; border-radius: 12px; padding: 1rem 1.2rem; height: 100%; transition: border-color 0.2s; }
.riesgo-card:hover { border-color: #c9a84c33; }
.riesgo-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem; }
.riesgo-nombre { font-size: 0.85rem; font-weight: 600; color: #f0e6c8; }
.riesgo-nivel { font-size: 0.62rem; font-weight: 700; padding: 0.15rem 0.5rem; border-radius: 999px; font-family: 'DM Mono', monospace; }
.nivel-bajo { background: #1a3f2a; color: #86efac; }
.nivel-medio { background: #3f2e1a; color: #fcd34d; }
.nivel-alto { background: #3f1f0a; color: #fb923c; }
.nivel-critico { background: #3f1f1f; color: #fca5a5; }
.riesgo-score { font-family: 'DM Mono', monospace; font-size: 2rem; font-weight: 700; line-height: 1; margin-bottom: 0.4rem; }
.score-bajo { color: #86efac; }
.score-medio { color: #fcd34d; }
.score-alto { color: #fb923c; }
.score-critico { color: #fca5a5; }
.riesgo-bar-track { background: #2e3550; border-radius: 999px; height: 6px; overflow: hidden; margin-bottom: 0.6rem; }
.riesgo-bar-fill { height: 100%; border-radius: 999px; transition: width 1s ease; }
.fill-bajo { background: linear-gradient(90deg, #22c55e, #86efac); }
.fill-medio { background: linear-gradient(90deg, #f59e0b, #fcd34d); }
.fill-alto { background: linear-gradient(90deg, #f97316, #fb923c); }
.fill-critico { background: linear-gradient(90deg, #ef4444, #fca5a5); }
.riesgo-accion { font-size: 0.75rem; color: #8892a4; line-height: 1.4; }
.riesgo-dias { font-size: 0.68rem; color: #6b7280; margin-top: 0.4rem; }

/* LOADING */
.ia-loading { text-align: center; padding: 2.5rem; color: #6b7280; }
.ia-loading-spinner { display: inline-block; width: 22px; height: 22px; border: 2px solid #2e3550; border-top-color: #c9a84c; border-radius: 50%; animation: spin 0.8s linear infinite; margin-bottom: 0.6rem; }
.empty-state { text-align: center; color: #4b5563; font-size: 0.85rem; padding: 2rem 0; }

/* SECCIONES */
.ia-section { display: none; }
.ia-section.active { display: block; }
</style>

<div class="dash-wrap">

    {{-- TOPBAR --}}
    <div class="dash-topbar">
        <div class="dash-title">Panel de <span>Inteligencia Artificial</span></div>
        <div class="dash-rol">{{ Auth::user()->rol }}</div>
    </div>

    {{-- BANNER --}}
    <div class="ia-banner">
        <div class="ia-banner-icon">🤖</div>
        <div>
            <div class="ia-banner-title">Motor de IA Activo — Claude Sonnet 4</div>
            <div class="ia-banner-sub">Análisis en tiempo real de tu inventario · FastAPI + Anthropic AI</div>
        </div>
        <div class="ia-status">
            <div class="ia-status-dot"></div> ONLINE
        </div>
    </div>

    {{-- KPIs --}}
    <div class="kpi-grid">
        <div class="kpi-card"><div class="kpi-icon">🔴</div><div class="kpi-value" id="kpi-criticas">—</div><div class="kpi-label">Alertas críticas</div></div>
        <div class="kpi-card"><div class="kpi-icon">🟡</div><div class="kpi-value" id="kpi-medias">—</div><div class="kpi-label">Alertas medias</div></div>
        <div class="kpi-card"><div class="kpi-icon">🟢</div><div class="kpi-value" id="kpi-bajas">—</div><div class="kpi-label">Sin riesgo</div></div>
        <div class="kpi-card"><div class="kpi-icon">📦</div><div class="kpi-value" id="kpi-productos">—</div><div class="kpi-label">Productos analizados</div></div>
    </div>

    {{-- TABS --}}
    <div class="ia-tabs">
        <button class="ia-tab active" onclick="cambiarTab('alertas', this)">🔔 Alertas</button>
        <button class="ia-tab" onclick="cambiarTab('predicciones', this)">📈 Predicciones</button>
        <button class="ia-tab" onclick="cambiarTab('riesgos', this)">⚠️ Riesgos</button>
    </div>

    {{-- SECCIÓN ALERTAS --}}
    <div id="section-alertas" class="ia-section active">
        <div class="card-dark">
            <div class="card-header-dark">
                <div class="card-header-left">
                    <i class="bi bi-bell" style="color:#c9a84c"></i>
                    <span class="card-header-title">Alertas de Inventario generadas por IA</span>
                </div>
                <button class="btn-ia" onclick="cargarAlertas()">↻ Actualizar</button>
            </div>
            <div class="card-body-dark" id="alertas-container">
                <div class="ia-loading"><div class="ia-loading-spinner"></div><div>Analizando inventario con IA...</div></div>
            </div>
        </div>
    </div>

    {{-- SECCIÓN PREDICCIONES --}}
    <div id="section-predicciones" class="ia-section">
        <div class="card-dark">
            <div class="card-header-dark">
                <div class="card-header-left">
                    <i class="bi bi-graph-up-arrow" style="color:#c9a84c"></i>
                    <span class="card-header-title">Predicción de Demanda — próximos 30 días</span>
                </div>
                <button class="btn-ia" onclick="cargarPredicciones()">↻ Actualizar</button>
            </div>
            <div class="card-body-dark" id="predicciones-container">
                <div class="ia-loading"><div class="ia-loading-spinner"></div><div>Calculando predicciones...</div></div>
            </div>
        </div>
    </div>

    {{-- SECCIÓN RIESGOS --}}
    <div id="section-riesgos" class="ia-section">
        <div class="card-dark">
            <div class="card-header-dark">
                <div class="card-header-left">
                    <i class="bi bi-shield-exclamation" style="color:#c9a84c"></i>
                    <span class="card-header-title">Score de Riesgo por Producto</span>
                </div>
                <button class="btn-ia" onclick="cargarRiesgos()">↻ Actualizar</button>
            </div>
            <div class="card-body-dark">
                <div class="row g-3" id="riesgos-container">
                    <div class="col-12"><div class="ia-loading"><div class="ia-loading-spinner"></div><div>Evaluando riesgos...</div></div></div>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ─── TABS ───────────────────────────────────────────────
function cambiarTab(tab, btn) {
    document.querySelectorAll('.ia-section').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('.ia-tab').forEach(b => b.classList.remove('active'));
    document.getElementById('section-' + tab).classList.add('active');
    btn.classList.add('active');

    // Cargar si no tiene contenido aún
    const container = document.getElementById(tab === 'alertas' ? 'alertas-container' : tab === 'predicciones' ? 'predicciones-container' : 'riesgos-container');
    if (container && container.querySelector('.ia-loading')) {
        if (tab === 'alertas') cargarAlertas();
        if (tab === 'predicciones') cargarPredicciones();
        if (tab === 'riesgos') cargarRiesgos();
    }
}

// ─── PRODUCTOS ──────────────────────────────────────────
async function obtenerProductos() {
    const res = await fetch('/productos-list');
    return await res.json();
}

// ─── ALERTAS ────────────────────────────────────────────
async function cargarAlertas() {
    const el = document.getElementById('alertas-container');
    el.innerHTML = `<div class="ia-loading"><div class="ia-loading-spinner"></div><div>Analizando con IA...</div></div>`;
    try {
        const res = await fetch('/ia/alertas');
        const data = await res.json();
        const alertas = data.alertas?.alertas || [];

        document.getElementById('kpi-criticas').textContent = alertas.filter(a => a.prioridad === 'alta').length;
        document.getElementById('kpi-medias').textContent   = alertas.filter(a => a.prioridad === 'media').length;
        document.getElementById('kpi-bajas').textContent    = alertas.filter(a => a.prioridad === 'baja').length;
        document.getElementById('kpi-productos').textContent = data.total_productos || '—';

        if (!alertas.length) {
            el.innerHTML = `<div class="empty-state">✅ La IA no detectó alertas en tu inventario</div>`;
            return;
        }
        const iconos = { stock_bajo:'📦', stock_critico:'🚨', sobrestock:'📈', sin_movimiento:'💤', vencimiento_proximo:'⏰' };
        el.innerHTML = alertas.map(a => `
            <div class="alerta-item alerta-${a.prioridad}">
                <div class="alerta-icon alerta-icon-${a.prioridad}">${iconos[a.tipo] || '⚠️'}</div>
                <div style="flex:1">
                    <div class="alerta-tipo alerta-tipo-${a.prioridad}">${(a.tipo||'').replace(/_/g,' ')}</div>
                    <div class="alerta-msg">${a.mensaje}</div>
                </div>
                <span class="badge-pr badge-${a.prioridad}">${(a.prioridad||'').toUpperCase()}</span>
            </div>`).join('');
    } catch(e) {
        el.innerHTML = `<div class="empty-state">❌ Error al conectar con el servicio IA<br><small style="color:#4b5563">Verifica que FastAPI esté corriendo en :8001</small></div>`;
    }
}

// ─── PREDICCIONES ───────────────────────────────────────
async function cargarPredicciones() {
    const el = document.getElementById('predicciones-container');
    el.innerHTML = `<div class="ia-loading"><div class="ia-loading-spinner"></div><div>Calculando predicciones con IA...</div></div>`;
    try {
        const productos = await obtenerProductos();
        if (!productos.length) { el.innerHTML = `<div class="empty-state">Sin productos</div>`; return; }

        const chunk = productos.slice(0, 6);
        const resultados = await Promise.all(
            chunk.map(p => fetch(`/ia/predecir/${p.id}`).then(r => r.json()).catch(() => null))
        );

        const tendIcon = { creciente:'📈', estable:'➡️', decreciente:'📉' };
        el.innerHTML = resultados.filter(Boolean).map(p => {
            const pred = p.prediccion || {};
            const tend = pred.tendencia || 'estable';
            const conf = Math.round((pred.confianza || 0) * 100);
            return `
            <div class="pred-card">
                <div style="flex:1">
                    <div class="pred-nombre">${p.producto || 'Producto'}</div>
                    <div class="pred-stock">Stock actual: <strong style="color:#c9a84c">${p.stock_actual ?? '—'}</strong> uds</div>
                    <div><span class="tend-badge tend-${tend}">${tendIcon[tend]} ${tend}</span></div>
                    ${pred.observaciones ? `<div class="pred-obs">${pred.observaciones}</div>` : ''}
                </div>
                <div style="text-align:right;flex-shrink:0">
                    <div class="pred-valor">${pred.prediccion_proximos_30_dias ?? '—'}</div>
                    <div class="pred-sub">uds / 30 días</div>
                    <div class="pred-sub" style="margin-top:0.3rem">Stock rec: ${pred.recomendacion_stock ?? '—'}</div>
                    <div class="confianza-bar"><div class="confianza-fill" style="width:${conf}%"></div></div>
                    <div class="pred-sub">${conf}% confianza</div>
                </div>
            </div>`;
        }).join('');
    } catch(e) {
        el.innerHTML = `<div class="empty-state">❌ Error al cargar predicciones<br><small style="color:#4b5563">Verifica que FastAPI esté corriendo en :8001</small></div>`;
    }
}

// ─── RIESGOS ────────────────────────────────────────────
async function cargarRiesgos() {
    const el = document.getElementById('riesgos-container');
    el.innerHTML = `<div class="col-12"><div class="ia-loading"><div class="ia-loading-spinner"></div><div>Evaluando riesgos con IA...</div></div></div>`;
    try {
        const productos = await obtenerProductos();
        if (!productos.length) { el.innerHTML = `<div class="col-12"><div class="empty-state">Sin productos</div></div>`; return; }

        const chunk = productos.slice(0, 9);
        const resultados = await Promise.all(
            chunk.map(p => fetch(`/ia/riesgo/${p.id}`).then(r => r.json()).catch(() => null))
        );

        el.innerHTML = resultados.filter(Boolean).map(r => {
            const riesgo = r.riesgo || {};
            const nivel  = riesgo.nivel || 'bajo';
            const score  = riesgo.score_riesgo ?? 0;
            return `
            <div class="col-md-4 col-sm-6">
                <div class="riesgo-card">
                    <div class="riesgo-header">
                        <div class="riesgo-nombre">${r.producto || 'Producto'}</div>
                        <span class="riesgo-nivel nivel-${nivel}">${nivel.toUpperCase()}</span>
                    </div>
                    <div class="riesgo-score score-${nivel}">${score}<span style="font-size:1rem;color:#6b7280">/100</span></div>
                    <div class="riesgo-bar-track">
                        <div class="riesgo-bar-fill fill-${nivel}" style="width:${score}%"></div>
                    </div>
                    <div class="riesgo-accion">${riesgo.accion_recomendada || ''}</div>
                    ${riesgo.dias_estimados_agotamiento ? `<div class="riesgo-dias">⏱ Agotamiento estimado: <strong>${riesgo.dias_estimados_agotamiento} días</strong></div>` : ''}
                </div>
            </div>`;
        }).join('');
    } catch(e) {
        el.innerHTML = `<div class="col-12"><div class="empty-state">❌ Error al cargar riesgos<br><small style="color:#4b5563">Verifica que FastAPI esté corriendo en :8001</small></div></div>`;
    }
}

// Cargar alertas al iniciar
document.addEventListener('DOMContentLoaded', () => cargarAlertas());
</script>
</x-app-layout>