<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión — Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'DM Sans', sans-serif; box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: #1a1f2e;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        /* DESTELLOS DE FONDO */
        body::before {
            content: '';
            position: absolute;
            top: -150px; left: -150px;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(201,168,76,0.07) 0%, transparent 70%);
            pointer-events: none;
        }
        body::after {
            content: '';
            position: absolute;
            bottom: -150px; right: -150px;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(201,168,76,0.05) 0%, transparent 70%);
            pointer-events: none;
        }

        .login-wrap { width: 100%; max-width: 420px; position: relative; z-index: 1; }

        /* HEADER */
        .login-header { text-align: center; margin-bottom: 2rem; }
        .logo-box {
            display: inline-flex; align-items: center; gap: 0.75rem;
            margin-bottom: 1.5rem; text-decoration: none;
        }
        .logo-icon {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, #c9a84c, #e8c96a);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }
        .logo-text { font-size: 1.4rem; font-weight: 700; color: #f0e6c8; letter-spacing: -0.03em; }
        .logo-text span { color: #c9a84c; }
        .login-title { font-size: 1.6rem; font-weight: 700; color: #f0e6c8; letter-spacing: -0.03em; margin-bottom: 0.4rem; }
        .login-subtitle { font-size: 0.875rem; color: #6b7280; }

        /* CARD */
        .login-card {
            background: #242938;
            border: 1px solid #2e3550;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.4);
        }

        /* ALERTS */
        .alert-error { background: #2a1f1f; border: 1px solid #7f1d1d; color: #fca5a5; border-radius: 12px; padding: 0.75rem 1rem; margin-bottom: 1.25rem; font-size: 0.82rem; }
        .alert-success-custom { background: #1a2e25; border: 1px solid #166534; color: #86efac; border-radius: 12px; padding: 0.75rem 1rem; margin-bottom: 1.25rem; font-size: 0.82rem; }

        /* FORM */
        .form-label { font-size: 0.78rem; font-weight: 600; color: #8892a4; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.45rem; display: block; }
        .form-group { margin-bottom: 1.1rem; }
        .form-control {
            width: 100%; background: #1a1f2e; border: 1px solid #2e3550;
            color: #e8eaf0; border-radius: 10px; padding: 0.75rem 1rem; font-size: 0.9rem;
            outline: none; transition: border-color 0.2s, box-shadow 0.2s;
            font-family: 'DM Sans', sans-serif;
        }
        .form-control::placeholder { color: #4b5563; }
        .form-control:focus { border-color: #c9a84c; box-shadow: 0 0 0 3px rgba(201,168,76,0.15); }
        .form-control.is-invalid { border-color: #ef4444; }
        .invalid-feedback { font-size: 0.75rem; color: #f87171; margin-top: 0.35rem; display: block; }

        /* PASSWORD TOGGLE */
        .input-wrap { position: relative; }
        .toggle-pass {
            position: absolute; right: 0.9rem; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer; color: #6b7280; font-size: 1rem;
            padding: 0.2rem; transition: color 0.15s;
        }
        .toggle-pass:hover { color: #c9a84c; }

        /* REMEMBER + FORGOT */
        .form-footer { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; }
        .remember-label { display: flex; align-items: center; gap: 0.5rem; font-size: 0.83rem; color: #8892a4; cursor: pointer; }
        .remember-label input[type="checkbox"] { width: 16px; height: 16px; accent-color: #c9a84c; cursor: pointer; }
        .forgot-link { font-size: 0.83rem; color: #c9a84c; text-decoration: none; transition: color 0.15s; }
        .forgot-link:hover { color: #e8c96a; }

        /* SUBMIT */
        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #c9a84c, #e8c96a);
            color: #111; font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem; font-weight: 700;
            padding: 0.85rem; border: none; border-radius: 10px;
            cursor: pointer; transition: opacity 0.2s, transform 0.15s; letter-spacing: 0.01em;
        }
        .btn-login:hover { opacity: 0.9; transform: translateY(-1px); }

        /* DIVIDER */
        .divider { display: flex; align-items: center; gap: 0.75rem; margin: 1.25rem 0; color: #4b5563; font-size: 0.75rem; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: #2e3550; }

        /* ROLES */
        .roles-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0.6rem; }
        .role-pill { background: #1a1f2e; border: 1px solid #2e3550; border-radius: 10px; padding: 0.6rem 0.75rem; text-align: center; }
        .role-pill-label { font-family: 'DM Mono', monospace; font-size: 0.65rem; color: #6b7280; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.15rem; }
        .role-pill-value { font-size: 0.75rem; color: #8892a4; }
        .role-pill-value span { color: #c9a84c; font-weight: 600; }

        /* FOOTER */
        .login-footer { text-align: center; margin-top: 1.5rem; font-size: 0.78rem; color: #4b5563; }
    </style>
</head>
<body>
    <div class="login-wrap">

        <div class="login-header">
            <a href="/" class="logo-box">
                <div class="logo-icon">📦</div>
                <span class="logo-text">Invent<span>ar</span>io</span>
            </a>
            <h1 class="login-title">Bienvenido de nuevo</h1>
            <p class="login-subtitle">Ingresa tus credenciales para continuar</p>
        </div>

        <div class="login-card">

            @if ($errors->any())
            <div class="alert-error">
                <i class="bi bi-exclamation-triangle me-2"></i>
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
            @endif

            @if (session('status'))
            <div class="alert-success-custom">
                <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Correo electrónico</label>
                    <input id="email" type="email" name="email"
                        class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        value="{{ old('email') }}" placeholder="admin@gmail.com" required autofocus>
                    @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Contraseña</label>
                    <div class="input-wrap">
                        <input id="password" type="password" name="password"
                            class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                            placeholder="••••••••" required>
                        <button type="button" class="toggle-pass" onclick="togglePass()">
                            <i class="bi bi-eye" id="eye-icon"></i>
                        </button>
                    </div>
                    @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="form-footer">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        Recordarme
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">¿Olvidaste tu contraseña?</a>
                    @endif
                </div>

                <button type="submit" class="btn-login">
                    Iniciar sesión &nbsp;→
                </button>
            </form>

            <div class="divider">accesos del sistema</div>

            <div class="roles-grid">
                <div class="role-pill">
                    <div class="role-pill-label">Admin</div>
                    <div class="role-pill-value">admin<span>@gmail.com</span></div>
                </div>
                <div class="role-pill">
                    <div class="role-pill-label">Vendedor</div>
                    <div class="role-pill-value">vendedor<span>@gmail.com</span></div>
                </div>
            </div>

        </div>

        <div class="login-footer">
            Sistema de Inventario Inteligente &copy; {{ date('Y') }}
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePass() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }
    </script>
</body>
</html>