<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mi Perfil</h2>
</x-slot>

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap');

.profile-wrap {
    font-family: 'DM Sans', sans-serif;
    background: #0f1117;
    min-height: 100vh;
    padding: 2.5rem 1.5rem;
    color: #e8eaf0;
}
.profile-inner {
    max-width: 600px;
    margin: 0 auto;
}

/* PAGE TITLE */
.page-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: #fff;
    letter-spacing: -0.03em;
    margin-bottom: 0.3rem;
}
.page-sub {
    font-size: 0.83rem;
    color: #6b7280;
    margin-bottom: 2rem;
}

/* AVATAR SECTION */
.avatar-section {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    background: #1e2130;
    border: 1px solid #2e3347;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}
.avatar-big {
    width: 64px; height: 64px;
    border-radius: 16px;
    background: linear-gradient(135deg, #6ee7b7, #3b82f6);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
    font-weight: 700;
    color: #0f1117;
    flex-shrink: 0;
}
.avatar-info {}
.avatar-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 0.2rem;
}
.avatar-email {
    font-size: 0.82rem;
    color: #6b7280;
    margin-bottom: 0.4rem;
}
.avatar-rol {
    display: inline-flex;
    align-items: center;
    background: #0f1117;
    border: 1px solid #2e3347;
    border-radius: 999px;
    padding: 0.2rem 0.7rem;
    font-family: 'DM Mono', monospace;
    font-size: 0.65rem;
    color: #6ee7b7;
    text-transform: uppercase;
    letter-spacing: 0.08em;
}

/* CARDS */
.card {
    background: #1e2130;
    border: 1px solid #2e3347;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1rem;
}
.card-title {
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #6b7280;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.card-title::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #2e3347;
}

/* ALERT */
.alert-success {
    background: #1a2e25;
    border: 1px solid #166534;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    margin-bottom: 1.5rem;
    font-size: 0.83rem;
    color: #86efac;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* FORM */
.form-group { margin-bottom: 1.1rem; }
.form-label {
    display: block;
    font-size: 0.78rem;
    font-weight: 600;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 0.45rem;
}
.form-input {
    width: 100%;
    background: #0f1117;
    border: 1px solid #2e3347;
    border-radius: 10px;
    padding: 0.7rem 1rem;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem;
    color: #e8eaf0;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.form-input::placeholder { color: #4b5563; }
.form-input:focus {
    border-color: #6ee7b7;
    box-shadow: 0 0 0 3px rgba(110,231,183,0.08);
}
.field-error {
    font-size: 0.75rem;
    color: #f87171;
    margin-top: 0.35rem;
}

/* BUTTONS */
.btn-primary {
    background: linear-gradient(135deg, #6ee7b7, #34d399);
    color: #0f1117;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem;
    font-weight: 700;
    padding: 0.7rem 1.5rem;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: opacity 0.2s, transform 0.15s;
}
.btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }

.btn-danger {
    background: #2a1f1f;
    color: #fca5a5;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem;
    font-weight: 600;
    padding: 0.7rem 1.5rem;
    border: 1px solid #7f1d1d;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-danger:hover {
    background: #3f1f1f;
    border-color: #ef4444;
    color: #fecaca;
}

/* DANGER ZONE */
.danger-zone {
    background: #1a0f0f;
    border: 1px solid #3f1f1f;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1rem;
}
.danger-title {
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #ef4444;
    margin-bottom: 0.6rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.danger-title::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #3f1f1f;
}
.danger-desc {
    font-size: 0.82rem;
    color: #9ca3af;
    margin-bottom: 1rem;
}
</style>

<div class="profile-wrap">
    <div class="profile-inner">

        <div class="page-title">Mi Perfil</div>
        <div class="page-sub">Gestiona tu información personal y configuración de cuenta</div>

        {{-- ALERT SUCCESS --}}
        @if (session('status') === 'profile-updated')
        <div class="alert-success">
            ✅ Perfil actualizado correctamente.
        </div>
        @endif

        {{-- AVATAR CARD --}}
        <div class="avatar-section">
            <div class="avatar-big">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
            <div class="avatar-info">
                <div class="avatar-name">{{ Auth::user()->name }}</div>
                <div class="avatar-email">{{ Auth::user()->email }}</div>
                <div class="avatar-rol">{{ Auth::user()->rol }}</div>
            </div>
        </div>

        {{-- EDITAR PERFIL --}}
        <div class="card">
            <div class="card-title">✏️ Información personal</div>

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label class="form-label" for="name">Nombre</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        class="form-input"
                        value="{{ old('name', $user->name) }}"
                        required
                    >
                    @error('name')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Correo electrónico</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        class="form-input"
                        value="{{ old('email', $user->email) }}"
                        required
                    >
                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-primary">Guardar cambios</button>
            </form>
        </div>

        {{-- DANGER ZONE --}}
        <div class="danger-zone">
            <div class="danger-title">⚠️ Zona de peligro</div>
            <div class="danger-desc">
                Al eliminar tu cuenta se borrarán permanentemente todos tus datos. Esta acción no se puede deshacer.
            </div>
            <form method="POST" action="{{ route('profile.destroy') }}"
                onsubmit="return confirm('¿Estás seguro? Esta acción es irreversible.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">🗑 Eliminar cuenta</button>
            </form>
        </div>

    </div>
</div>
</x-app-layout>