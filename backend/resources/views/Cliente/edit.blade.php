<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Cliente</h2>
</x-slot>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap');
* { font-family: 'DM Sans', sans-serif; }
.form-wrap { background: #1a1f2e; min-height: 100vh; padding: 2rem; }
.page-title { font-size: 1.6rem; font-weight: 700; color: #f0e6c8; letter-spacing: -0.03em; }
.page-title span { color: #c9a84c; }
.btn-volver { background: #242938; border: 1px solid #2e3550; color: #a0a8c0; border-radius: 10px; padding: 0.5rem 1.2rem; font-size: 0.875rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; transition: all 0.15s; }
.btn-volver:hover { border-color: #c9a84c; color: #c9a84c; }
.form-card { background: #242938; border: 1px solid #2e3550; border-radius: 16px; padding: 2rem; max-width: 560px; box-shadow: 0 4px 24px rgba(0,0,0,0.3); }
.section-divider { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.12em; color: #c9a84c; border-bottom: 1px solid #2e3550; padding-bottom: 0.5rem; margin-bottom: 1.25rem; }
.form-label { font-size: 0.78rem; font-weight: 600; color: #8892a4; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.4rem; }
.form-control { background: #1a1f2e; border: 1px solid #2e3550; color: #e8eaf0; border-radius: 10px; padding: 0.7rem 1rem; font-size: 0.875rem; }
.form-control:focus { background: #1a1f2e; border-color: #c9a84c; box-shadow: 0 0 0 3px rgba(201,168,76,0.15); color: #e8eaf0; }
.is-invalid { border-color: #ef4444 !important; }
.invalid-feedback { color: #f87171; font-size: 0.75rem; }
.btn-guardar { background: linear-gradient(135deg, #c9a84c, #e8c96a); color: #111; font-weight: 700; border: none; border-radius: 10px; padding: 0.75rem 2rem; font-size: 0.9rem; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.4rem; cursor: pointer; font-family: 'DM Sans', sans-serif; }
.btn-guardar:hover { opacity: 0.9; transform: translateY(-1px); color: #111; }
.btn-cancelar { background: #2a1f1f; border: 1px solid #7f1d1d; color: #fca5a5; border-radius: 10px; padding: 0.75rem 1.5rem; font-size: 0.9rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; transition: all 0.15s; }
.btn-cancelar:hover { background: #3f1f1f; border-color: #ef4444; color: #fecaca; }
</style>
<div class="form-wrap">
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="/clientes" class="btn-volver"><i class="bi bi-arrow-left"></i> Volver</a>
        <div class="page-title">Editar <span>Cliente</span></div>
    </div>
    <div class="form-card">
        <form action="/clientes/{{ $cliente->id }}" method="POST">
            @csrf
            @method('PUT')
            <div class="section-divider">✏️ Editar información</div>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $cliente->nombre) }}">
                    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono', $cliente->telefono) }}">
                    @error('telefono')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $cliente->email) }}">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="d-flex gap-3 mt-4">
                <button type="submit" class="btn-guardar"><i class="bi bi-check-lg"></i> Actualizar Cliente</button>
                <a href="/clientes" class="btn-cancelar"><i class="bi bi-x-lg"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>