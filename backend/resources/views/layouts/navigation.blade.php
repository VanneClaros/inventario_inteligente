<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&display=swap');

.navbar {
    font-family: 'DM Sans', sans-serif;
    background: #0f1117;
    border-bottom: 1px solid #1e2130;
    position: sticky;
    top: 0;
    z-index: 100;
}
.navbar-inner {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 60px;
    gap: 1.5rem;
}

/* LOGO */
.navbar-logo {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    text-decoration: none;
    flex-shrink: 0;
}
.navbar-logo svg {
    fill: #6ee7b7 !important;
    width: 28px; height: 28px;
}
.navbar-brand {
    font-size: 0.95rem;
    font-weight: 700;
    color: #fff;
    letter-spacing: -0.02em;
}
.navbar-brand span { color: #6ee7b7; }

/* NAV LINKS */
.navbar-links {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    flex: 1;
}
.nav-link {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4rem 0.85rem;
    border-radius: 8px;
    font-size: 0.83rem;
    font-weight: 500;
    color: #9ca3af;
    text-decoration: none;
    transition: all 0.15s;
    white-space: nowrap;
}
.nav-link:hover {
    background: #1e2130;
    color: #e8eaf0;
}
.nav-link.active {
    background: #1e2130;
    color: #6ee7b7;
}
.nav-link .nav-icon { font-size: 0.9rem; }

/* DIVIDER */
.nav-divider {
    width: 1px;
    height: 20px;
    background: #2e3347;
    margin: 0 0.25rem;
}

/* USER DROPDOWN */
.user-area {
    position: relative;
    flex-shrink: 0;
}
.user-btn {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    background: #1e2130;
    border: 1px solid #2e3347;
    border-radius: 10px;
    padding: 0.4rem 0.75rem;
    cursor: pointer;
    transition: border-color 0.15s;
    font-family: 'DM Sans', sans-serif;
}
.user-btn:hover { border-color: #6ee7b7; }
.user-avatar {
    width: 26px; height: 26px;
    border-radius: 6px;
    background: linear-gradient(135deg, #6ee7b7, #3b82f6);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.65rem;
    font-weight: 700;
    color: #0f1117;
    flex-shrink: 0;
}
.user-info { text-align: left; }
.user-name {
    font-size: 0.8rem;
    font-weight: 600;
    color: #e8eaf0;
    line-height: 1;
}
.user-rol {
    font-size: 0.65rem;
    color: #6b7280;
    line-height: 1.3;
}
.user-chevron {
    color: #6b7280;
    font-size: 0.7rem;
    transition: transform 0.2s;
}
.user-area.open .user-chevron { transform: rotate(180deg); }

/* DROPDOWN MENU */
.dropdown-menu {
    display: none;
    position: absolute;
    right: 0;
    top: calc(100% + 0.5rem);
    background: #1e2130;
    border: 1px solid #2e3347;
    border-radius: 12px;
    min-width: 180px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0,0,0,0.4);
}
.user-area.open .dropdown-menu { display: block; }
.dropdown-header {
    padding: 0.85rem 1rem;
    border-bottom: 1px solid #2e3347;
}
.dropdown-email {
    font-size: 0.72rem;
    color: #6b7280;
}
.dropdown-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.65rem 1rem;
    font-size: 0.82rem;
    color: #9ca3af;
    text-decoration: none;
    transition: all 0.15s;
    cursor: pointer;
    background: none;
    border: none;
    width: 100%;
    font-family: 'DM Sans', sans-serif;
}
.dropdown-link:hover {
    background: #16213e;
    color: #e8eaf0;
}
.dropdown-link.danger:hover {
    background: #2a1f1f;
    color: #fca5a5;
}
.dropdown-divider {
    height: 1px;
    background: #2e3347;
    margin: 0.2rem 0;
}

/* HAMBURGER */
.hamburger {
    display: none;
    background: none;
    border: 1px solid #2e3347;
    border-radius: 8px;
    padding: 0.4rem;
    cursor: pointer;
    color: #9ca3af;
}

/* MOBILE MENU */
.mobile-menu {
    display: none;
    background: #0f1117;
    border-top: 1px solid #1e2130;
    padding: 0.75rem 1.5rem 1rem;
}
.mobile-menu.open { display: block; }
.mobile-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.65rem 0.75rem;
    border-radius: 8px;
    font-size: 0.85rem;
    color: #9ca3af;
    text-decoration: none;
    transition: all 0.15s;
}
.mobile-link:hover { background: #1e2130; color: #e8eaf0; }
.mobile-divider { height: 1px; background: #2e3347; margin: 0.5rem 0; }
.mobile-user {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    margin-bottom: 0.5rem;
}
.mobile-user-name { font-size: 0.85rem; font-weight: 600; color: #e8eaf0; }
.mobile-user-email { font-size: 0.72rem; color: #6b7280; }

@media (max-width: 768px) {
    .navbar-links { display: none; }
    .user-area { display: none; }
    .hamburger { display: flex; }
}
</style>

<nav class="navbar" x-data="{ open: false, userOpen: false }">
    <div class="navbar-inner">

        {{-- LOGO --}}
        <a href="{{ route('dashboard') }}" class="navbar-logo">
            <x-application-logo class="block h-9 w-auto fill-current" style="fill:#6ee7b7" />
            <span class="navbar-brand">Invent<span>ar</span>io</span>
        </a>

        {{-- NAV LINKS --}}
        <div class="navbar-links">
            @if(Auth::check() && Auth::user()->rol == 'admin')
                <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">⬛</span> Dashboard
                </a>
                <a href="/reportes/ventas" class="nav-link {{ request()->is('reportes*') ? 'active' : '' }}">
                    <span class="nav-icon">📈</span> Reportes
                </a>
                <div class="nav-divider"></div>
                <a href="/productos" class="nav-link {{ request()->is('productos*') ? 'active' : '' }}">
                    <span class="nav-icon">📦</span> Productos
                </a>
                <a href="/lotes" class="nav-link {{ request()->is('lotes*') ? 'active' : '' }}">
                    <span class="nav-icon">🗂️</span> Lotes
                </a>
                <div class="nav-divider"></div>
            @endif

            @if(Auth::check() && in_array(Auth::user()->rol, ['admin', 'vendedor']))
                <a href="/ventas" class="nav-link {{ request()->is('ventas*') ? 'active' : '' }}">
                    <span class="nav-icon">🧾</span> Ventas
                </a>
                <a href="/clientes" class="nav-link {{ request()->is('clientes*') ? 'active' : '' }}">
                    <span class="nav-icon">👥</span> Clientes
                </a>
            @endif
        </div>

        {{-- USER DROPDOWN --}}
        <div class="user-area" :class="{ 'open': userOpen }" @click.outside="userOpen = false">
            <button class="user-btn" @click="userOpen = !userOpen">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-rol">{{ Auth::user()->rol }}</div>
                </div>
                <span class="user-chevron">▼</span>
            </button>

            <div class="dropdown-menu">
                <div class="dropdown-header">
                    <div class="user-name" style="font-size:0.82rem">{{ Auth::user()->name }}</div>
                    <div class="dropdown-email">{{ Auth::user()->email }}</div>
                </div>
                <a href="{{ route('profile.edit') }}" class="dropdown-link">
                    👤 Mi perfil
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-link danger">
                        🚪 Cerrar sesión
                    </button>
                </form>
            </div>
        </div>

        {{-- HAMBURGER --}}
        <button class="hamburger" @click="open = !open">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

    </div>

    {{-- MOBILE MENU --}}
    <div class="mobile-menu" :class="{ 'open': open }">
        <div class="mobile-user">
            <div class="user-avatar" style="width:36px;height:36px;font-size:0.8rem;border-radius:8px">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </div>
            <div>
                <div class="mobile-user-name">{{ Auth::user()->name }}</div>
                <div class="mobile-user-email">{{ Auth::user()->email }}</div>
            </div>
        </div>
        <div class="mobile-divider"></div>

        @if(Auth::check() && Auth::user()->rol == 'admin')
            <a href="/dashboard" class="mobile-link">⬛ Dashboard</a>
            <a href="/reportes/ventas" class="mobile-link">📈 Reportes</a>
            <a href="/productos" class="mobile-link">📦 Productos</a>
            <a href="/lotes" class="mobile-link">🗂️ Lotes</a>
        @endif
        @if(Auth::check() && in_array(Auth::user()->rol, ['admin', 'vendedor']))
            <a href="/ventas" class="mobile-link">🧾 Ventas</a>
            <a href="/clientes" class="mobile-link">👥 Clientes</a>
        @endif

        <div class="mobile-divider"></div>
        <a href="{{ route('profile.edit') }}" class="mobile-link">👤 Mi perfil</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="mobile-link" style="width:100%;text-align:left;background:none;border:none;cursor:pointer;font-family:inherit">
                🚪 Cerrar sesión
            </button>
        </form>
    </div>
</nav>