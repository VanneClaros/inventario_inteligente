<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Productos</h2>
</x-slot>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap');
* { font-family: 'DM Sans', sans-serif; }
.pg-wrap { background: #1a1f2e; min-height: 100vh; padding: 2rem; }
.page-title { font-size: 1.6rem; font-weight: 700; color: #f0e6c8; letter-spacing: -0.03em; }
.page-title span { color: #c9a84c; }
.btn-nuevo {
    background: linear-gradient(135deg, #c9a84c, #e8c96a);
    color: #111; font-weight: 700; border: none; border-radius: 10px;
    padding: 0.6rem 1.4rem; font-size: 0.875rem; transition: all 0.2s; text-decoration: none;
    display: inline-flex; align-items: center; gap: 0.4rem;
}
.btn-nuevo:hover { opacity: 0.9; transform: translateY(-1px); color: #111; }

.alert-ok { background: #1a2e25; border: 1px solid #166534; color: #86efac; border-radius: 12px; }

.table-card {
    background: #242938;
    border: 1px solid #2e3550;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(0,0,0,0.3);
}
.prod-table { width: 100%; border-collapse: collapse; margin: 0; }
.prod-table thead { background: #111520; }
.prod-table th {
    font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.12em; color: #c9a84c;
    padding: 1rem 1.25rem; text-align: left; border: none;
}
.prod-table td {
    padding: 0.9rem 1.25rem; font-size: 0.875rem;
    color: #c8cdd8; border-bottom: 1px solid #2a3045;
    vertical-align: middle;
}
.prod-table tbody tr:last-child td { border-bottom: none; }
.prod-table tbody tr:hover td { background: #2e3550; }
.prod-id { font-family: monospace; color: #5a6280; font-size: 0.8rem; }
.prod-nombre { font-weight: 600; color: #f0e6c8; }
.prod-precio { font-family: monospace; color: #c9a84c; font-weight: 700; font-size: 0.9rem; }
.prod-desc { color: #8892a4; }
.badge-ok {
    background: #1a2e25; border: 1px solid #166534;
    color: #86efac; border-radius: 999px; padding: 0.25rem 0.75rem;
    font-size: 0.72rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.3rem;
}
.badge-low {
    background: #2a1f1f; border: 1px solid #7f1d1d;
    color: #fca5a5; border-radius: 999px; padding: 0.25rem 0.75rem;
    font-size: 0.72rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.3rem;
}
.btn-editar {
    background: #2e3550; border: 1px solid #3d4666; color: #a0a8c0;
    font-size: 0.78rem; border-radius: 8px; padding: 0.35rem 0.85rem;
    transition: all 0.15s; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;
}
.btn-editar:hover { border-color: #c9a84c; color: #c9a84c; background: #35300a; }
.btn-eliminar {
    background: #2a1f1f; border: 1px solid #7f1d1d; color: #fca5a5;
    font-size: 0.78rem; border-radius: 8px; padding: 0.35rem 0.85rem;
    transition: all 0.15s; cursor: pointer; font-family: 'DM Sans', sans-serif;
    display: inline-flex; align-items: center; gap: 0.3rem;
}
.btn-eliminar:hover { background: #3f1f1f; border-color: #ef4444; color: #fecaca; }
.empty-state { text-align: center; color: #4b5563; padding: 3rem; }
</style>

<div class="pg-wrap">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="page-title">Lista de <span>Productos</span></div>
        <a href="/productos/create" class="btn-nuevo">
            <i class="bi bi-plus-lg"></i> Nuevo Producto
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-ok alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="table-card">
        <table class="prod-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Stock Mínimo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productos as $producto)
                <tr>
                    <td><span class="prod-id">#{{ $producto->id }}</span></td>
                    <td><span class="prod-nombre">{{ $producto->nombre }}</span></td>
                    <td><span class="prod-desc">{{ $producto->descripcion }}</span></td>
                    <td><span class="prod-precio">Bs. {{ number_format($producto->precio, 2) }}</span></td>
                    <td>
                        <span class="{{ $producto->stock <= $producto->stock_minimo ? 'badge-low' : 'badge-ok' }}">
                            <i class="bi bi-{{ $producto->stock <= $producto->stock_minimo ? 'exclamation-triangle' : 'check-lg' }}"></i>
                            {{ $producto->stock }} uds
                        </span>
                    </td>
                    <td><span class="prod-id">{{ $producto->stock_minimo }}</span></td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="/productos/{{ $producto->id }}/edit" class="btn-editar">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                            <form action="/productos/{{ $producto->id }}" method="POST" style="display:inline"
                                onsubmit="return confirm('¿Eliminar este producto?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-eliminar">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="bi bi-box-seam fs-2 d-block mb-2" style="color:#c9a84c"></i>
                            No hay productos registrados
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>