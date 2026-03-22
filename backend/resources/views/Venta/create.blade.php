<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nueva Venta</h2>
</x-slot>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap');
* { font-family: 'DM Sans', sans-serif; }
.form-wrap { background: #1a1f2e; min-height: 100vh; padding: 2rem; }
.page-title { font-size: 1.6rem; font-weight: 700; color: #f0e6c8; letter-spacing: -0.03em; }
.page-title span { color: #c9a84c; }
.btn-volver {
    background: #242938; border: 1px solid #2e3550; color: #a0a8c0;
    border-radius: 10px; padding: 0.5rem 1.2rem; font-size: 0.875rem;
    text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; transition: all 0.15s;
}
.btn-volver:hover { border-color: #c9a84c; color: #c9a84c; }
.form-card {
    background: #242938; border: 1px solid #2e3550;
    border-radius: 16px; padding: 2rem;
    box-shadow: 0 4px 24px rgba(0,0,0,0.3); margin-bottom: 1.5rem;
}
.section-divider {
    font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.12em; color: #c9a84c;
    border-bottom: 1px solid #2e3550; padding-bottom: 0.5rem; margin-bottom: 1.25rem;
}
.form-label { font-size: 0.78rem; font-weight: 600; color: #8892a4; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.4rem; }
.form-control, .form-select {
    background: #1a1f2e; border: 1px solid #2e3550;
    color: #e8eaf0; border-radius: 10px; padding: 0.7rem 1rem; font-size: 0.875rem;
}
.form-control:focus, .form-select:focus {
    background: #1a1f2e; border-color: #c9a84c;
    box-shadow: 0 0 0 3px rgba(201,168,76,0.15); color: #e8eaf0;
}
.form-select option { background: #242938; color: #e8eaf0; }

/* AGREGAR PRODUCTO */
.add-row {
    display: flex; gap: 0.75rem; align-items: flex-end; flex-wrap: wrap;
}
.btn-agregar {
    background: #2e3550; border: 1px solid #3d4666; color: #a0a8c0;
    border-radius: 10px; padding: 0.7rem 1.25rem; font-size: 0.875rem; font-weight: 600;
    cursor: pointer; transition: all 0.15s; display: inline-flex; align-items: center; gap: 0.4rem;
    font-family: 'DM Sans', sans-serif; white-space: nowrap;
}
.btn-agregar:hover { border-color: #c9a84c; color: #c9a84c; }

/* TABLA CARRITO */
.carrito-table { width: 100%; border-collapse: collapse; }
.carrito-table th {
    font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em;
    color: #c9a84c; padding: 0.85rem 1rem; text-align: left; border-bottom: 1px solid #2e3550;
}
.carrito-table td {
    padding: 0.8rem 1rem; font-size: 0.875rem; color: #c8cdd8; border-bottom: 1px solid #2a3045;
    vertical-align: middle;
}
.carrito-table tbody tr:last-child td { border-bottom: none; }
.td-prod { font-weight: 600; color: #f0e6c8; }
.td-mono { font-family: 'DM Mono', monospace; color: #8892a4; }
.td-sub { font-family: 'DM Mono', monospace; color: #c9a84c; font-weight: 700; }
.btn-del-item {
    background: #2a1f1f; border: 1px solid #7f1d1d; color: #fca5a5;
    font-size: 0.75rem; border-radius: 8px; padding: 0.3rem 0.7rem;
    cursor: pointer; font-family: 'DM Sans', sans-serif; transition: all 0.15s;
}
.btn-del-item:hover { background: #3f1f1f; border-color: #ef4444; }

/* TOTAL */
.total-bar {
    display: flex; align-items: center; justify-content: space-between;
    background: #1a1f2e; border: 1px solid #2e3550; border-radius: 12px;
    padding: 1rem 1.5rem; margin-top: 1rem;
}
.total-label { font-size: 0.8rem; font-weight: 600; color: #8892a4; text-transform: uppercase; letter-spacing: 0.08em; }
.total-value { font-family: 'DM Mono', monospace; font-size: 1.5rem; font-weight: 700; color: #c9a84c; }

/* ALERTS */
.alert-error { background: #2a1f1f; border: 1px solid #7f1d1d; color: #fca5a5; border-radius: 12px; padding: 0.75rem 1rem; margin-bottom: 1rem; font-size: 0.82rem; }
.alert-ok { background: #1a2e25; border: 1px solid #166534; color: #86efac; border-radius: 12px; }

.btn-guardar {
    background: linear-gradient(135deg, #c9a84c, #e8c96a);
    color: #111; font-weight: 700; border: none; border-radius: 10px;
    padding: 0.75rem 2rem; font-size: 0.9rem; transition: all 0.2s;
    display: inline-flex; align-items: center; gap: 0.4rem; cursor: pointer;
    font-family: 'DM Sans', sans-serif;
}
.btn-guardar:hover { opacity: 0.9; transform: translateY(-1px); color: #111; }
.btn-cancelar {
    background: #2a1f1f; border: 1px solid #7f1d1d; color: #fca5a5;
    border-radius: 10px; padding: 0.75rem 1.5rem; font-size: 0.9rem;
    text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; transition: all 0.15s;
}
.btn-cancelar:hover { background: #3f1f1f; border-color: #ef4444; color: #fecaca; }
.empty-carrito { text-align: center; color: #4b5563; padding: 2rem; font-size: 0.85rem; }
</style>

<div class="form-wrap">
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="/ventas" class="btn-volver">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
        <div class="page-title">Nueva <span>Venta</span></div>
    </div>

    @if(session('error'))
    <div class="alert-error mb-3"><i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}</div>
    @endif
    @if(session('success'))
    <div class="alert alert-ok alert-dismissible fade show mb-3" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <form action="{{ route('ventas.store') }}" method="POST" onsubmit="return validarCarrito()">
        @csrf

        {{-- DATOS GENERALES --}}
        <div class="form-card">
            <div class="section-divider">🧾 Datos de la venta</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Cliente</label>
                    <select name="cliente_id" class="form-select">
                        <option value="">Seleccionar cliente...</option>
                        @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="fecha" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
            </div>
        </div>

        {{-- AGREGAR PRODUCTOS --}}
        <div class="form-card">
            <div class="section-divider">📦 Agregar productos</div>
            <div class="add-row">
                <div style="flex:2; min-width:200px">
                    <label class="form-label">Producto</label>
                    <select id="producto" class="form-select">
                        @foreach($productos as $producto)
                        <option value="{{ $producto->id }}" data-precio="{{ $producto->precio }}">
                            {{ $producto->nombre }} — Bs. {{ number_format($producto->precio, 2) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div style="flex:1; min-width:120px">
                    <label class="form-label">Cantidad</label>
                    <input type="number" id="cantidad" class="form-control" min="1" placeholder="0">
                </div>
                <div>
                    <label class="form-label" style="opacity:0">.</label>
                    <button type="button" class="btn-agregar" onclick="agregarProducto()">
                        <i class="bi bi-cart-plus"></i> Agregar
                    </button>
                </div>
            </div>
        </div>

        {{-- CARRITO --}}
        <div class="form-card">
            <div class="section-divider">🛒 Productos en la venta</div>
            <table class="carrito-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio unit.</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tablaProductos">
                    <tr id="emptyRow">
                        <td colspan="5"><div class="empty-carrito"><i class="bi bi-cart fs-3 d-block mb-2"></i>Sin productos agregados</div></td>
                    </tr>
                </tbody>
            </table>

            <div class="total-bar">
                <span class="total-label">Total de la venta</span>
                <span class="total-value">Bs. <span id="total">0.00</span></span>
            </div>

            <div id="hiddenInputs"></div>
            <input type="hidden" name="total" id="inputTotal">

            <div class="d-flex gap-3 mt-4">
                <button type="submit" class="btn-guardar">
                    <i class="bi bi-check-lg"></i> Guardar Venta
                </button>
                <a href="/ventas" class="btn-cancelar">
                    <i class="bi bi-x-lg"></i> Cancelar
                </a>
            </div>
        </div>

    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
let carrito = [];
let total = 0;

function agregarProducto() {
    let productoSelect = document.getElementById("producto");
    let producto_id = productoSelect.value;
    let nombre = productoSelect.options[productoSelect.selectedIndex].text.split(' —')[0];
    let precio = parseFloat(productoSelect.options[productoSelect.selectedIndex].dataset.precio);
    let cantidad = parseInt(document.getElementById("cantidad").value);

    if (!cantidad || cantidad <= 0) {
        alert("Ingrese una cantidad válida");
        return;
    }

    let existente = carrito.find(i => i.producto_id === producto_id);
    if (existente) {
        existente.cantidad += cantidad;
        existente.subtotal = existente.precio * existente.cantidad;
    } else {
        carrito.push({ producto_id, nombre, precio, cantidad, subtotal: precio * cantidad });
    }

    document.getElementById("cantidad").value = "";
    total = carrito.reduce((s, i) => s + i.subtotal, 0);
    renderCarrito();
}

function renderCarrito() {
    let tbody = document.getElementById("tablaProductos");
    let hiddenInputs = document.getElementById("hiddenInputs");
    hiddenInputs.innerHTML = "";

    if (carrito.length === 0) {
        tbody.innerHTML = '<tr id="emptyRow"><td colspan="5"><div class="empty-carrito"><i class="bi bi-cart fs-3 d-block mb-2"></i>Sin productos agregados</div></td></tr>';
        document.getElementById("total").innerText = "0.00";
        document.getElementById("inputTotal").value = 0;
        return;
    }

    tbody.innerHTML = "";
    carrito.forEach((item, index) => {
        tbody.innerHTML += `
            <tr>
                <td><span class="td-prod">${item.nombre}</span></td>
                <td><span class="td-mono">${item.cantidad}</span></td>
                <td><span class="td-mono">Bs. ${item.precio.toFixed(2)}</span></td>
                <td><span class="td-sub">Bs. ${item.subtotal.toFixed(2)}</span></td>
                <td><button type="button" class="btn-del-item" onclick="eliminar(${index})"><i class="bi bi-trash"></i></button></td>
            </tr>`;
        hiddenInputs.innerHTML += `
            <input type="hidden" name="productos[]" value="${item.producto_id}">
            <input type="hidden" name="cantidades[]" value="${item.cantidad}">`;
    });

    document.getElementById("total").innerText = total.toFixed(2);
    document.getElementById("inputTotal").value = total;
}

function eliminar(index) {
    total -= carrito[index].subtotal;
    carrito.splice(index, 1);
    total = carrito.reduce((s, i) => s + i.subtotal, 0);
    renderCarrito();
}

function validarCarrito() {
    if (carrito.length === 0) {
        alert("Debe agregar al menos un producto antes de guardar la venta");
        return false;
    }
    return true;
}
</script>
</x-app-layout>