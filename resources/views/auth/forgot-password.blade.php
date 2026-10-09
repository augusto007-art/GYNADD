<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar contraseña</title>
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
            font-family: 'Consolas', monospace; font-size: 11px; letter-spacing: 4px;
            color: #00d4ff; opacity: 0.8; display: block; margin-bottom: 6px;
        }
        .marca h1 { font-size: 40px; font-weight: 800; letter-spacing: 3px; margin: 0; text-transform: uppercase; }
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
            content: ""; position: absolute; width: 14px; height: 14px; border: 2px solid #00d4ff;
        }
        .panel::before { top: -1px; left: -1px; border-right: none; border-bottom: none; }
        .panel::after { bottom: -1px; right: -1px; border-left: none; border-top: none; }

        .ref-tag {
            font-family: 'Consolas', monospace; font-size: 11px; letter-spacing: 2px;
            color: #00d4ff; opacity: 0.7; margin-bottom: 10px;
        }

        .descripcion { color: #9fb3c8; font-size: 13px; margin-bottom: 18px; line-height: 1.5; }

        label {
            display: block; font-size: 11px; text-transform: uppercase; letter-spacing: 1px;
            color: #9fb3c8; margin-bottom: 6px; margin-top: 6px;
        }
        input[type="email"] {
            width: 100%; padding: 11px 12px; background: #0d1420;
            border: 1px solid rgba(0, 212, 255, 0.25); border-radius: 3px;
            color: #e6edf3; font-size: 14px;
        }
        input:focus { outline: none; border-color: #00d4ff; }

        button[type="submit"] {
            width: 100%; margin-top: 20px; background: transparent; border: 1px solid #00d4ff;
            color: #00d4ff; padding: 13px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 1px; font-size: 13px; cursor: pointer; transition: 0.2s; border-radius: 3px;
        }
        button[type="submit"]:hover { background: #00d4ff; color: #0b0f16; }

        .status-ok {
            background: rgba(0, 212, 255, 0.1); border: 1px solid rgba(0, 212, 255, 0.4);
            color: #00d4ff; padding: 10px 12px; border-radius: 3px; font-size: 13px; margin-bottom: 16px;
        }
        .error {
            background: rgba(255, 80, 80, 0.08); border: 1px solid rgba(255, 80, 80, 0.4);
            color: #ff8080; padding: 10px 12px; border-radius: 3px; font-size: 13px; margin-bottom: 16px;
        }

        .enlaces { margin-top: 20px; text-align: center; font-size: 13px; }
        .enlaces a { color: #00d4ff; text-decoration: none; }
        .enlaces a:hover { text-decoration: underline; }
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
            <div class="ref-tag"> RECUPERAR CONTRASEÑA</div>
            <p class="descripcion">Escribe tu correo y te enviaremos un enlace para restablecer tu contraseña.</p>

            @if (session('status'))
                <div class="status-ok">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <label>Correo</label>
                <input type="email" name="email">
                <button type="submit">Enviar enlace de recuperación</button>
            </form>

            <div class="enlaces">
                <p><a href="{{ route('login') }}">Volver a iniciar sesión</a></p>
            </div>
        </div>
    </div>
</body>
</html>