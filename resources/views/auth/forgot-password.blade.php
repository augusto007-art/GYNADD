<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        .error-field { color: #ff8080; font-size: 12px; margin: 6px 0 0; }

        .enlaces { margin-top: 20px; text-align: center; font-size: 13px; }
        .enlaces a { color: #00d4ff; text-decoration: none; }
        .enlaces a:hover { text-decoration: underline; }

        body {
            position: relative;
            isolation: isolate;
            overflow-x: hidden;
            background-image:
                linear-gradient(rgba(0, 212, 255, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 212, 255, 0.05) 1px, transparent 1px),
                radial-gradient(ellipse at 50% 0%, rgba(0, 212, 255, 0.12), transparent 55%);
            background-size: 40px 40px, 40px 40px, auto;
            background-repeat: repeat, repeat, no-repeat;
            padding: 28px 0;
        }

        body::before {
            content: "";
            position: fixed;
            z-index: -1;
            inset: -35%;
            pointer-events: none;
            background: radial-gradient(ellipse, rgba(0, 212, 255, 0.1), transparent 45%);
            animation: ambient-drift 18s ease-in-out infinite alternate;
        }

        body::after {
            content: "";
            position: fixed;
            z-index: -1;
            top: 0;
            left: 0;
            width: 180px;
            height: 180px;
            pointer-events: none;
            opacity: 0;
            background: radial-gradient(circle, rgba(0, 212, 255, 0.1), transparent 72%);
            transform: translate3d(var(--cursor-x, -200px), var(--cursor-y, -200px), 0) translate(-50%, -50%);
            transition: opacity 100ms ease;
            will-change: transform;
        }

        body.cursor-light-visible::after {
            opacity: 1;
        }

        .marca {
            animation: fade-down 550ms cubic-bezier(0.2, 0.75, 0.25, 1) both;
        }

        .marca h1 { font-size: clamp(34px, 9vw, 40px); }

        .panel {
            border-radius: 10px;
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.055), rgba(255, 255, 255, 0.015));
            box-shadow: 0 24px 70px rgba(0, 0, 0, 0.28);
            backdrop-filter: blur(10px);
            animation: rise-in 700ms 120ms cubic-bezier(0.2, 0.75, 0.25, 1) both;
            transition: border-color 220ms ease, box-shadow 220ms ease, transform 220ms ease;
        }

        input[type="email"] {
            min-height: 44px;
            transition: border-color 180ms ease, box-shadow 180ms ease, background-color 180ms ease;
        }

        input[type="email"]:focus {
            background-color: #101a29;
            box-shadow: 0 0 0 3px rgba(0, 212, 255, 0.12);
        }

        button[type="submit"] {
            min-height: 44px;
            transition: color 180ms ease, background-color 180ms ease, border-color 180ms ease, box-shadow 180ms ease, transform 180ms ease;
        }

        button:focus-visible,
        a:focus-visible,
        input:focus-visible {
            outline: 2px solid #00d4ff;
            outline-offset: 3px;
        }

        .enlaces a {
            display: inline-block;
            transition: color 180ms ease, transform 180ms ease;
        }

        @media (hover: hover) {
            .panel:hover {
                border-color: rgba(0, 212, 255, 0.48);
                box-shadow: 0 28px 80px rgba(0, 0, 0, 0.36), 0 0 30px rgba(0, 212, 255, 0.05);
                transform: translateY(-3px);
            }

            button[type="submit"]:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 24px rgba(0, 212, 255, 0.16);
            }

            .enlaces a:hover {
                color: #7aeaff;
                transform: translateY(-1px);
            }
        }

        button[type="submit"]:active {
            transform: translateY(0) scale(0.985);
        }

        @keyframes rise-in {
            from { opacity: 0; transform: translateY(18px) scale(0.985); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        @keyframes fade-down {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes ambient-drift {
            from { transform: translate3d(-3%, -2%, 0) scale(0.95); }
            to { transform: translate3d(3%, 2%, 0) scale(1.08); }
        }

        @media (max-width: 480px) {
            .contenedor { padding: 16px; }
            .marca { margin-bottom: 22px; }
            .marca .slogan { font-size: 10px; line-height: 1.5; }
            .panel { padding: 28px 22px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            body::after {
                display: none;
            }
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
            <div class="ref-tag"> RECUPERAR CONTRASEÑA</div>
            <p class="descripcion">Escribe tu correo y te enviaremos un enlace para restablecer tu contraseña.</p>

            @if (session('status'))
                <div class="status-ok">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <label for="email">Correo</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
                @error('email')
                    <p class="error-field" id="email-error" role="alert">{{ $message }}</p>
                @enderror
                <button type="submit">Enviar enlace de recuperación</button>
            </form>

            <div class="enlaces">
                <p><a href="{{ route('login') }}">Volver a iniciar sesión</a></p>
            </div>
        </div>
    </div>
    <script>
        if (window.matchMedia('(prefers-reduced-motion: no-preference)').matches) {
            let cursorFrame = 0;
            let cursorX = 0;
            let cursorY = 0;

            window.addEventListener('pointermove', (event) => {
                if (event.pointerType !== 'mouse') return;
                cursorX = event.clientX;
                cursorY = event.clientY;
                if (cursorFrame) return;

                cursorFrame = window.requestAnimationFrame(() => {
                    cursorFrame = 0;
                    document.body.style.setProperty('--cursor-x', `${cursorX}px`);
                    document.body.style.setProperty('--cursor-y', `${cursorY}px`);
                    document.body.classList.add('cursor-light-visible');
                });
            });
            window.addEventListener('pointerleave', () => {
                document.body.classList.remove('cursor-light-visible');
            });
        }
    </script>
</body>
</html>