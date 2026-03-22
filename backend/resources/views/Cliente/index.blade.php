<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Clientes</h2>
</x-slot>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap');
* { font-family: 'DM Sans', sans-serif; }
.pg-wrap { background: #1a1f2e; min-height: 100vh; padding: 2rem; }
.page-title { font-size: 1.6rem; font-weight: 700; color: #f0e6c8; letter-spacing: -0.03em; }
.page-title span { color: #c9a84c; }
.btn-nuevo {
    background: linear-gradient(135deg, #c9a84c, #e8c96a);
    color: #111; font-weight: 700; border: none; border-radius: 10px;
    padding: 0.6rem 1.4rem; font-size: 0.875rem; transition: all 0.2s;
    text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;
}
.btn-nuevo:hover { opacity: 0.9; transform: translateY(-1px); color: #111; }
.alert-ok { background: #1a2e25; border: 1px solid #166534; color: #86efac; border-radius: 12px; }
.table-card {
    background: #242938; border: 1px solid #2e3550;
    border-radius: 16px; overflow: hidden;
    box-shadow: 0 4px 24px rgba(0,0,0,0.3);
}
.cli-table { width: 100%; border-collapse: collapse; }
.cli-table thead { background: #111520; }
.cli-table th {
    font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.12em; color: #c9a84c;
    padding: 1rem 1.25rem; text-align: left; border: none;
}
.cli-table td {
    padding: 0.9rem 1.25rem; font-size: 0.875rem;
    color: #c8cdd8; border-bottom: 1px solid #2a3045; vertical-align: middle;
}
.cli-table tbody tr:last-child td { border-bottom: none; }
.cli-table tbody tr:hover td { background: #2e3550; }
.td-id { font-family: 'DM Mono', monospace; color: #5a6280; font-size: 0.8rem; }
.td-nombre { font-weight: 600; color: #f0e6c8; }
.td-telefono { font-family: 'DM Mono', monospace; color: #8892a4; font-size: 0.85rem; }
.td-email { color: #8892a4; font-size: 0.85rem; }
.avatar-sm {
    width: 34px; height: 34px; border-radius: 50%;
    background: linear-gradient(135deg, #c9a84c, #e8c96a);
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 0.75rem; font-weight: 700; color: #111; flex-shrink: 0;
}
.btn-editar {
    background: #2e3550; border: 1px solid #3d4666; color: #a0a8c0;
    font-size: 0.78rem; border-radius: 8px; padding: 0.35rem 0.85rem;
    transition: all 0.15s; text-decoration: none;
    display: inline-flex; align-items: center; gap: 0.3rem;
}
.btn-editar:hover { border-color: #c9a84c; color: #c9a84c; }
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
        <div class="page-title">Lista de <span>Clientes</span></div>
        <a href="/clientes/create" class="btn-nuevo">
            <i class="bi bi-person-plus"></i> Nuevo Cliente
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-ok alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="table-card">
        <table class="cli-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clientes as $cliente)
                <tr>
                    <td><span class="td-id">#{{ $cliente->id }}</span></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-sm">{{ strtoupper(substr($cliente->nombre, 0, 2)) }}</div>
                            <span class="td-nombre">{{ $cliente->nombre }}</span>
                        </div>
                    </td>
                    <td><span class="td-telefono"><i class="bi bi-telephone me-1"></i>{{ $cliente->telefono }}</span></td>
                    <td><span class="td-email"><i class="bi bi-envelope me-1"></i>{{ $cliente->email }}</span></td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="/clientes/{{ $cliente->id }}/edit" class="btn-editar">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                            <form action="/clientes/{{ $cliente->id }}" method="POST" style="display:inline"
                                onsubmit="return confirm('¿Eliminar este cliente?')">
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
                    <td colspan="5">
                        <div class="empty-state">
                            <i class="bi bi-people fs-2 d-block mb-2" style="color:#c9a84c"></i>
                            No hay clientes registrados
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