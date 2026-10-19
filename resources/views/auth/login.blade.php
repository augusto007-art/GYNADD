<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #0b0f16;
            background-image:
                linear-gradient(rgba(0, 212, 255, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 212, 255, 0.05) 1px, transparent 1px);
            background-size: 40px 40px;
            color: #e6edf3;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        .contenedor {
            width: 100%;
            max-width: 380px;
            padding: 20px;
        }

        .marca {
            text-align: center;
            margin-bottom: 28px;
        }

        .marca .tag {
            font-family: 'Consolas', monospace;
            font-size: 11px;
            letter-spacing: 4px;
            color: #00d4ff;
            opacity: 0.8;
            display: block;
            margin-bottom: 6px;
        }

        .marca h1 {
            font-size: 40px;
            font-weight: 800;
            letter-spacing: 3px;
            margin: 0;
            text-transform: uppercase;
        }

        .marca h1 span { color: #00d4ff; }

        .marca .slogan {
            font-size: 12px;
            color: #9fb3c8;
            letter-spacing: 1px;
            margin-top: 6px;
        }

        .panel {
            border: 1px solid rgba(0, 212, 255, 0.3);
            border-radius: 4px;
            padding: 36px 32px;
            position: relative;
            background: rgba(255,255,255,0.02);
        }

        .panel::before, .panel::after {
            content: "";
            position: absolute;
            width: 14px;
            height: 14px;
            border: 2px solid #00d4ff;
        }
        .panel::before { top: -1px; left: -1px; border-right: none; border-bottom: none; }
        .panel::after { bottom: -1px; right: -1px; border-left: none; border-top: none; }

        .ref-tag {
            font-family: 'Consolas', monospace;
            font-size: 11px;
            letter-spacing: 2px;
            color: #00d4ff;
            opacity: 0.7;
            margin-bottom: 16px;
        }

        label {
            display: block;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #9fb3c8;
            margin-bottom: 6px;
            margin-top: 16px;
        }

        input[type="email"],
        input[type="password"],
        .password-field input {
            width: 100%;
            padding: 11px 12px;
            background: #0d1420;
            border: 1px solid rgba(0, 212, 255, 0.25);
            border-radius: 3px;
            color: #e6edf3;
            font-size: 14px;
        }

        input[type="email"]:focus,
        input[type="password"]:focus,
        .password-field input:focus {
            outline: none;
            border-color: #00d4ff;
        }

        .password-field { display: flex; gap: 8px; }
        .password-field input { min-width: 0; flex: 1; }
        .toggle-password {
            padding: 0 10px;
            color: #00d4ff;
            background: #0d1420;
            border: 1px solid rgba(0, 212, 255, 0.25);
            border-radius: 3px;
            cursor: pointer;
        }

        .recordar {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 16px;
            font-size: 13px;
            color: #9fb3c8;
        }

        button[type="submit"] {
            width: 100%;
            margin-top: 24px;
            background: transparent;
            border: 1px solid #00d4ff;
            color: #00d4ff;
            padding: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 13px;
            cursor: pointer;
            transition: 0.2s;
            border-radius: 3px;
        }

        button[type="submit"]:hover {
            background: #00d4ff;
            color: #0b0f16;
        }

        .divisor {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 22px 0;
            color: #5c6b7a;
            font-size: 11px;
            letter-spacing: 1px;
        }
        .divisor::before, .divisor::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid rgba(0, 212, 255, 0.2);
        }
        .divisor span { padding: 0 10px; }

        .google-btn {
            display: block;
            text-align: center;
            width: 100%;
            padding: 11px;
            border: 1px solid rgba(230,237,243,0.25);
            color: #e6edf3;
            text-decoration: none;
            border-radius: 3px;
            font-size: 13px;
            transition: 0.2s;
        }
        .google-btn:hover {
            border-color: #e6edf3;
        }

        .enlaces {
            margin-top: 20px;
            text-align: center;
            font-size: 13px;
        }
        .enlaces a {
            color: #00d4ff;
            text-decoration: none;
        }
        .enlaces a:hover { text-decoration: underline; }
        .enlaces p { margin: 8px 0; color: #9fb3c8; }

        .status-ok {
            background: rgba(0, 212, 255, 0.1);
            border: 1px solid rgba(0, 212, 255, 0.4);
            color: #00d4ff;
            padding: 10px 12px;
            border-radius: 3px;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .error-field {
            color: #ff8080;
            font-size: 12px;
            margin: 6px 0 0;
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <div class="marca">
            <h1>GYNADD<span>.</span></h1>
            <div class="slogan">AQUÍ NO SE VIENE A INTENTAR
SE VIENE A LOGRAR</div>
        </div>

        <div class="panel">
            <div class="ref-tag"> INICIAR SESIÓN</div>

            @if (session('status'))
                <div class="status-ok">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}" autocomplete="off">
                @csrf
                <label for="email">Correo</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
                @error('email')
                    <p class="error-field" id="email-error" role="alert">{{ $message }}</p>
                @enderror

                <label for="password">Contraseña</label>
                <div class="password-field">
                    <input id="password" type="password" name="password" autocomplete="current-password" required @error('password') aria-invalid="true" aria-describedby="password-error" @enderror>
                    <button class="toggle-password" type="button" data-password-toggle aria-controls="password" aria-label="Mostrar contraseña" aria-pressed="false">Mostrar</button>
                </div>
                @error('password')
                    <p class="error-field" id="password-error" role="alert">{{ $message }}</p>
                @enderror

                <label class="recordar">
                    <input type="checkbox" name="recordar" style="width:auto;" checked>
                    Recordarme
                </label>

                <button type="submit">Entrar</button>
            </form>

            <div class="divisor"><span>O</span></div>

            <a href="{{ route('google.redirect') }}" class="google-btn">Iniciar sesión con Google</a>

            <div class="enlaces">
                <p><a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a></p>
                <p>¿No tienes cuenta? <a href="{{ route('registro') }}">Regístrate</a></p>
            </div>
        </div>
    </div>
    <script>
        document.querySelector('[data-password-toggle]').addEventListener('click', (event) => {
            const button = event.currentTarget;
            const input = document.getElementById(button.getAttribute('aria-controls'));
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            button.textContent = show ? 'Ocultar' : 'Mostrar';
            button.setAttribute('aria-label', `${show ? 'Ocultar' : 'Mostrar'} contraseña`);
            button.setAttribute('aria-pressed', String(show));
        });
    </script>
</body>
</html>