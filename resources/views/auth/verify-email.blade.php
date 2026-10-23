<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verificar correo</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            background: #0b0f16;
            color: #e6edf3;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .panel {
            width: min(100% - 32px, 440px);
            padding: 32px;
            border: 1px solid rgba(0, 212, 255, 0.3);
            background: rgba(255, 255, 255, 0.02);
        }
        h1 { margin-top: 0; color: #00d4ff; }
        p { color: #9fb3c8; line-height: 1.6; }
        .status { color: #00d4ff; }
        label { display: block; margin-top: 24px; color: #e6edf3; }
        input {
            width: 100%;
            margin-top: 8px;
            padding: 12px;
            border: 1px solid rgba(0, 212, 255, 0.3);
            background: #111a26;
            color: #e6edf3;
            font: inherit;
            letter-spacing: 0.25em;
        }
        .error { color: #ff8b8b; }
        button {
            width: 100%;
            margin-top: 16px;
            padding: 12px;
            border: 1px solid #00d4ff;
            background: transparent;
            color: #00d4ff;
            font-weight: 700;
            cursor: pointer;
        }
        .logout { display: block; margin-top: 18px; color: #9fb3c8; text-align: center; }
    </style>
</head>
<body>
    <main class="panel">
        <h1>Verifica tu correo</h1>
        <p>Enviamos un código de 6 dígitos a <strong>{{ auth()->user()->email }}</strong>. Escríbelo para confirmar tu dirección. El código vence en {{ config('auth.verification.expire', 10) }} minutos.</p>

        @if (session('status'))
            <p class="status" role="status">{{ session('status') }}</p>
        @endif

        <form method="POST" action="{{ route('verification.verify') }}">
            @csrf
            <label for="code">Código de verificación</label>
            <input id="code" name="code" type="text" inputmode="numeric" autocomplete="one-time-code" pattern="[0-9]{6}" maxlength="6" required aria-describedby="code-error" @error('code') aria-invalid="true" @enderror>
            @error('code')
                <p class="error" id="code-error" role="alert">{{ $message }}</p>
            @enderror
            <button type="submit">Confirmar correo</button>
        </form>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit">Reenviar código</button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Cerrar sesión</button>
        </form>
    </main>
</body>
</html>
