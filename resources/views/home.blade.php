<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
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
</body>
</html>