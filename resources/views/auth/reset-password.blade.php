<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva contraseña</title>
    <style>
        .password-field { display: flex; gap: 8px; margin: 6px 0 12px; }
        .password-field input { min-width: 0; }
        .toggle-password { cursor: pointer; }
    </style>
</head>
<body>
    <h1>Nueva contraseña</h1>

    @if ($errors->any())
        <ul style="color:red">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <label for="password">Nueva contraseña</label>
        <div class="password-field">
            <input id="password" type="password" name="password" autocomplete="new-password" required>
            <button class="toggle-password" type="button" data-password-toggle aria-controls="password" aria-label="Mostrar contraseña" aria-pressed="false">Mostrar</button>
        </div>

        <label for="password_confirmation">Confirmar contraseña</label>
        <div class="password-field">
            <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required>
            <button class="toggle-password" type="button" data-password-toggle aria-controls="password_confirmation" aria-label="Mostrar contraseña" aria-pressed="false">Mostrar</button>
        </div>

        <button type="submit">Actualizar contraseña</button>
    </form>
    <script>
        document.querySelectorAll('[data-password-toggle]').forEach((button) => {
            button.addEventListener('click', () => {
                const input = document.getElementById(button.getAttribute('aria-controls'));
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