<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
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

        .contenedor { width: 100%; max-width: 380px; padding: 20px; }

        .marca { text-align: center; margin-bottom: 28px; }
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
        .marca .slogan { font-size: 12px; color: #9fb3c8; letter-spacing: 1px; margin-top: 6px; }

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

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 11px 12px;
            background: #0d1420;
            border: 1px solid rgba(0, 212, 255, 0.25);
            border-radius: 3px;
            color: #e6edf3;
            font-size: 14px;
        }
        input:focus { outline: none; border-color: #00d4ff; }

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
        .password-strength { margin-top: 10px; }
        .password-strength p { margin: 0 0 6px; font-size: 12px; }
        .password-strength ul { margin: 0; padding-left: 18px; font-size: 11px; line-height: 1.7; }
        .strength-weak { color: #ff6b6b; }
        .strength-medium { color: #ffad42; }
        .strength-strong { color: #48d597; }
        .strength-neutral { color: #9fb3c8; }

        small {
            display: block;
            color: #5c6b7a;
            font-size: 11px;
            margin-top: 6px;
            line-height: 1.4;
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
        button[type="submit"]:hover { background: #00d4ff; color: #0b0f16; }

        .divisor {
            display: flex; align-items: center; text-align: center;
            margin: 22px 0; color: #5c6b7a; font-size: 11px; letter-spacing: 1px;
        }
        .divisor::before, .divisor::after {
            content: ""; flex: 1; border-bottom: 1px solid rgba(0, 212, 255, 0.2);
        }
        .divisor span { padding: 0 10px; }

        .google-btn {
            display: block; text-align: center; width: 100%; padding: 11px;
            border: 1px solid rgba(230,237,243,0.25); color: #e6edf3;
            text-decoration: none; border-radius: 3px; font-size: 13px; transition: 0.2s;
        }
        .google-btn:hover { border-color: #e6edf3; }

        .enlaces { margin-top: 20px; text-align: center; font-size: 13px; }
        .enlaces a { color: #00d4ff; text-decoration: none; }
        .enlaces a:hover { text-decoration: underline; }
        .enlaces p { margin: 8px 0; color: #9fb3c8; }

        .errores {
            background: rgba(255, 80, 80, 0.08);
            border: 1px solid rgba(255, 80, 80, 0.4);
            color: #ff8080;
            padding: 10px 12px;
            border-radius: 3px;
            font-size: 13px;
            margin-bottom: 16px;
            list-style: none;
        }
        .errores li { margin: 2px 0; }
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
            <div class="ref-tag">CREAR CUENTA</div>

            @if ($errors->any())
                <ul class="errores">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('registro') }}">
                @csrf
                <label for="name">Nombre</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" autocomplete="name" required>

                <label for="email">Correo</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required>

                <label for="password">Contraseña</label>
                <div class="password-field">
                    <input id="password" type="password" name="password" autocomplete="new-password" required aria-describedby="password-strength">
                    <button class="toggle-password" type="button" data-password-toggle="password" aria-controls="password" aria-label="Mostrar contraseña" aria-pressed="false">Mostrar</button>
                </div>
                <div id="password-strength" class="password-strength strength-neutral" aria-live="polite">
                    <p id="strength-status">Seguridad: escribe una contraseña</p>
                    <ul>
                        <li id="length-check">Al menos 15 caracteres</li>
                        <li id="common-check">No usar una contraseña común o fácil de adivinar</li>
                    </ul>
                </div>
                <small>Este sitio no usa autenticación multifactor: por eso exige 15 caracteres. Puedes usar espacios, frases y cualquier tipo de carácter.</small>
                <small>La lista de contraseñas comunes es local y no comprueba bases de datos de contraseñas filtradas.</small>

                <label for="password_confirmation">Confirmar contraseña</label>
                <div class="password-field">
                    <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required>
                    <button class="toggle-password" type="button" data-password-toggle="password_confirmation" aria-controls="password_confirmation" aria-label="Mostrar contraseña" aria-pressed="false">Mostrar</button>
                </div>

                <button type="submit">Registrarme</button>
            </form>

            <div class="divisor"><span>O</span></div>

            <a href="{{ route('google.redirect') }}" class="google-btn">Registrarme con Google</a>

            <div class="enlaces">
                <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
            </div>
        </div>
    </div>
    <script>
        const passwordInput = document.getElementById('password');
        const strengthStatus = document.getElementById('strength-status');
        const lengthCheck = document.getElementById('length-check');
        const commonCheck = document.getElementById('common-check');
        const commonPasswords = new Set([
            '123456789012345', '1234567890123456', '111111111111111',
            'password', 'password123', 'password12345678', 'passwordpassword',
            'contrasena', 'contrasena123456', 'contraseña', 'qwerty',
            'qwerty123456789', 'letmein', 'iloveyou', 'admin'
        ]);

        function updatePasswordStrength() {
            const password = passwordInput.value;
            const length = Array.from(password).length;
            const isCommon = commonPasswords.has(password.toLowerCase());
            const isStrong = length >= 15 && !isCommon;
            const isMedium = length >= 8 && !isStrong && !isCommon;
            const state = isStrong ? 'strong' : (isMedium ? 'medium' : 'weak');
            const labels = { weak: 'Insegura', medium: 'Intermedia', strong: 'Segura' };

            lengthCheck.className = length >= 15 ? 'strength-strong' : (length >= 8 ? 'strength-medium' : 'strength-weak');
            commonCheck.className = isCommon ? 'strength-weak' : (password ? 'strength-strong' : 'strength-neutral');
            strengthStatus.textContent = password ? `Seguridad: ${labels[state]}` : 'Seguridad: escribe una contraseña';
            document.getElementById('password-strength').className = `password-strength strength-${password ? state : 'neutral'}`;
        }

        passwordInput.addEventListener('input', updatePasswordStrength);
        document.querySelectorAll('[data-password-toggle]').forEach((button) => {
            button.addEventListener('click', () => {
                const input = document.getElementById(button.dataset.passwordToggle);
                const show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                button.textContent = show ? 'Ocultar' : 'Mostrar';
                button.setAttribute('aria-label', `${show ? 'Ocultar' : 'Mostrar'} contraseña`);
                button.setAttribute('aria-pressed', String(show));
            });
        });
    </script>
</body>
</html>