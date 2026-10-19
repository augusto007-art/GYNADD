<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicio</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            background-color: #0b0f16;
            background-image:
                linear-gradient(rgba(0, 212, 255, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 212, 255, 0.05) 1px, transparent 1px);
            background-size: 40px 40px;
            color: #e6edf3;
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 40px;
            border-bottom: 2px solid #00d4ff;
            background: linear-gradient(180deg, rgba(0,212,255,0.08), transparent);
        }

        .usuario-box {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }

        .usuario-tag {
            font-family: 'Consolas', monospace;
            font-size: 11px;
            letter-spacing: 2px;
            color: #00d4ff;
            opacity: 0.8;
        }

        .usuario-nombre {
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .logo-frame {
            border: 1px dashed rgba(0, 212, 255, 0.5);
            padding: 6px 14px;
            position: relative;
        }

        .logo-frame::before {
            content: "LOGO";
            position: absolute;
            top: -9px;
            left: 8px;
            background: #0b0f16;
            padding: 0 6px;
            font-family: 'Consolas', monospace;
            font-size: 9px;
            letter-spacing: 2px;
            color: rgba(0, 212, 255, 0.6);
        }

        .logo-frame img {
            height: 42px;
            display: block;
        }

        main {
            padding: 60px 40px;
            max-width: 800px;
            margin: 0 auto;
        }

        .ref-tag {
            font-family: 'Consolas', monospace;
            font-size: 12px;
            letter-spacing: 3px;
            color: #00d4ff;
            margin-bottom: 10px;
            opacity: 0.8;
        }

        .panel {
            border: 1px solid rgba(0, 212, 255, 0.3);
            border-radius: 4px;
            padding: 40px;
            position: relative;
            background: rgba(255,255,255,0.02);
        }

        .panel::before, .panel::after,
        .panel .corner-tl, .panel .corner-br {
            content: "";
            position: absolute;
            width: 14px;
            height: 14px;
            border: 2px solid #00d4ff;
        }
        .panel::before { top: -1px; left: -1px; border-right: none; border-bottom: none; }
        .panel::after { bottom: -1px; right: -1px; border-left: none; border-top: none; }

        h1 {
            font-size: 34px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0 0 10px;
        }

        h1 span {
            color: #00d4ff;
        }

        .subtitulo {
            color: #9fb3c8;
            margin-bottom: 30px;
        }

        button {
            background: transparent;
            border: 1px solid #00d4ff;
            color: #00d4ff;
            padding: 12px 28px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 13px;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            background: #00d4ff;
            color: #0b0f16;
        }

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

        header {
            padding: 18px clamp(20px, 5vw, 64px);
            animation: slide-in 650ms cubic-bezier(0.2, 0.75, 0.25, 1) both;
        }

        main {
            width: min(100%, 880px);
            padding: clamp(36px, 8vh, 72px) clamp(20px, 5vw, 40px);
        }

        .panel {
            border-radius: 10px;
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.055), rgba(255, 255, 255, 0.015));
            box-shadow: 0 24px 70px rgba(0, 0, 0, 0.28);
            backdrop-filter: blur(10px);
            animation: rise-in 750ms 100ms cubic-bezier(0.2, 0.75, 0.25, 1) both;
            transition: border-color 220ms ease, box-shadow 220ms ease, transform 220ms ease;
        }

        button {
            min-height: 44px;
            border-radius: 5px;
            transition: color 180ms ease, background-color 180ms ease, box-shadow 180ms ease, transform 180ms ease;
        }

        button:focus-visible {
            outline: 2px solid #00d4ff;
            outline-offset: 3px;
        }

        @media (hover: hover) {
            .panel:hover {
                border-color: rgba(0, 212, 255, 0.48);
                box-shadow: 0 28px 80px rgba(0, 0, 0, 0.36), 0 0 30px rgba(0, 212, 255, 0.05);
                transform: translateY(-3px);
            }

            button:hover {
                box-shadow: 0 8px 24px rgba(0, 212, 255, 0.16);
                transform: translateY(-2px);
            }
        }

        button:active {
            transform: translateY(0) scale(0.985);
        }

        @keyframes slide-in {
            from { opacity: 0; transform: translateY(-12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes rise-in {
            from { opacity: 0; transform: translateY(18px) scale(0.985); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        @keyframes ambient-drift {
            from { transform: translate3d(-3%, -2%, 0) scale(0.95); }
            to { transform: translate3d(3%, 2%, 0) scale(1.08); }
        }

        @media (max-width: 520px) {
            header {
                gap: 16px;
                padding-block: 16px;
            }

            .usuario-nombre {
                font-size: clamp(15px, 4vw, 20px);
                overflow-wrap: anywhere;
            }

            .logo-frame img {
                max-width: min(38vw, 150px);
                height: auto;
                max-height: 42px;
            }

            .ref-tag {
                font-size: 10px;
                letter-spacing: 2px;
            }

            .panel {
                padding: 30px 24px;
            }

            h1 {
                font-size: clamp(26px, 7vw, 34px);
            }

            .subtitulo {
                line-height: 1.6;
            }

            button {
                width: 100%;
            }
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
    <header>
        <div class="usuario-box">
            <span class="usuario-tag">USR // ACTIVO</span>
            <span class="usuario-nombre">{{ auth()->user()->name }}</span>
        </div>

        <div class="logo-frame">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-full">
        </div>
    </header>

    <main>
        <div class="ref-tag">SEC // 01 · PANEL PRINCIPAL</div>

        <div class="panel">
            <h1>Bienvenido<span>.</span></h1>
            <p class="subtitulo">Tu sesión está activa. Todo listo para continuar.</p>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Cerrar sesión</button>
            </form>
        </div>
    </main>
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