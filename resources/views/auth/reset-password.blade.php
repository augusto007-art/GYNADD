<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva contraseña</title>
    <style>
        .password-field { display: flex; gap: 8px; margin: 6px 0 12px; }
        .password-field input { min-width: 0; }
        .toggle-password { cursor: pointer; }
        .error-field { color: red; margin: 6px 0 12px; }
    </style>
</head>
<body>
    <h1>Nueva contraseña</h1>

    @if ($errors->has('email') || $errors->has('token'))
        <ul style="color:red">
            @error('email')
                <li>{{ $message }}</li>
            @enderror
            @error('token')
                <li>{{ $message }}</li>
            @enderror
        </ul>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <label for="password">Nueva contraseña</label>
        <div class="password-field">
            <input id="password" type="password" name="password" autocomplete="new-password" minlength="8" maxlength="12" required @error('password') aria-invalid="true" aria-describedby="password-error" @enderror>
            <button class="toggle-password" type="button" data-password-toggle aria-controls="password" aria-label="Mostrar contraseña" aria-pressed="false">Mostrar</button>
        </div>
        @error('password')
            <p class="error-field" id="password-error" role="alert">{{ $message }}</p>
        @enderror
        <small>Usa entre 8 y 12 caracteres, incluyendo mayúsculas, minúsculas, números y símbolos permitidos (!@#$%&amp;*_-.). No uses espacios, otros símbolos, secuencias predecibles ni repeticiones largas.</small>

        <label for="password_confirmation">Confirmar contraseña</label>
        <div class="password-field">
            <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required @error('password_confirmation') aria-invalid="true" aria-describedby="password-confirmation-error" @enderror>
            <button class="toggle-password" type="button" data-password-toggle aria-controls="password_confirmation" aria-label="Mostrar contraseña" aria-pressed="false">Mostrar</button>
        </div>
        @error('password_confirmation')
            <p class="error-field" id="password-confirmation-error" role="alert">{{ $message }}</p>
        @enderror

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