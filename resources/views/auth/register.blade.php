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

        .error-field {
            color: #ff8080;
            font-size: 12px;
            margin: 6px 0 0;
        }
        .error-field[hidden] { display: none; }
        .field-status {
            min-height: 16px;
            margin: 6px 0 0;
            font-size: 12px;
        }
        .field-status.success { color: #48d597; }
        .field-status.pending { color: #ffad42; }
        input[aria-invalid="true"] { border-color: #ff8080; }
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

            <form method="POST" action="{{ route('registro') }}" novalidate data-email-check-url="{{ route('registro.email') }}">
                @csrf
                <label for="name">Nombre</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" autocomplete="name" required aria-describedby="name-error" @error('name') aria-invalid="true" @enderror>
                @error('name')
                    <p class="error-field" id="name-error" role="alert">{{ $message }}</p>
                @else
                    <p class="error-field" id="name-error" role="alert" hidden></p>
                @enderror

                <label for="email">Correo</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required aria-describedby="email-error email-status" @error('email') aria-invalid="true" @enderror>
                @error('email')
                    <p class="error-field" id="email-error" role="alert">{{ $message }}</p>
                @else
                    <p class="error-field" id="email-error" role="alert" hidden></p>
                @enderror
                <p id="email-status" class="field-status" aria-live="polite"></p>

                <label for="password">Contraseña</label>
                <div class="password-field">
                    <input id="password" type="password" name="password" autocomplete="new-password" required aria-describedby="password-strength password-error" @error('password') aria-invalid="true" @enderror>
                    <button class="toggle-password" type="button" data-password-toggle="password" aria-controls="password" aria-label="Mostrar contraseña" aria-pressed="false">Mostrar</button>
                </div>
                @error('password')
                    <p class="error-field" id="password-error" role="alert">{{ $message }}</p>
                @else
                    <p class="error-field" id="password-error" role="alert" hidden></p>
                @enderror
                <div id="password-strength" class="password-strength strength-neutral" aria-live="polite">
                    <p id="strength-status">Seguridad: escribe una contraseña</p>
                    <ul>
                        <li id="length-check">Entre 8 y 12 caracteres</li>
                        <li id="composition-check">Una mayúscula, una minúscula, un número y un símbolo permitido</li>
                        <li id="characters-check">Solo letras, números y símbolos !@#$%&amp;*_-.</li>
                        <li id="common-check">No usar secuencias, repeticiones o contraseñas comunes</li>
                    </ul>
                </div>
                <small>Usa entre 8 y 12 caracteres, combinando mayúsculas, minúsculas, números y símbolos permitidos (!@#$%&amp;*_-.). No se permiten espacios ni otros símbolos.</small>
                <small>Se rechazan contraseñas comunes, secuencias predecibles y repeticiones largas.</small>

                <label for="password-confirmation">Confirmar contraseña</label>
                <div class="password-field">
                    <input id="password-confirmation" type="password" name="password_confirmation" autocomplete="new-password" required aria-describedby="password-confirmation-error" @error('password_confirmation') aria-invalid="true" @enderror>
                    <button class="toggle-password" type="button" data-password-toggle="password-confirmation" aria-controls="password-confirmation" aria-label="Mostrar contraseña" aria-pressed="false">Mostrar</button>
                </div>
                @error('password_confirmation')
                    <p class="error-field" id="password-confirmation-error" role="alert">{{ $message }}</p>
                @else
                    <p class="error-field" id="password-confirmation-error" role="alert" hidden></p>
                @enderror

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
        const registrationForm = document.querySelector('form[data-email-check-url]');
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const confirmationInput = document.getElementById('password-confirmation');
        const strengthStatus = document.getElementById('strength-status');
        const lengthCheck = document.getElementById('length-check');
        const compositionCheck = document.getElementById('composition-check');
        const charactersCheck = document.getElementById('characters-check');
        const commonCheck = document.getElementById('common-check');
        const emailStatus = document.getElementById('email-status');
        const submitButton = registrationForm.querySelector('[type="submit"]');
        let emailCheckState = 'idle';
        let emailAvailabilityMessage = '';
        let emailCheckTimer;
        let emailCheckController;
        let submitAfterEmailCheck = false;
        const commonPasswords = new Set([
            '123456789012345', '1234567890123456', '111111111111111',
            'password', 'password123', 'password12345678', 'passwordpassword',
            'contrasena', 'contrasena123456', 'contraseña', 'qwerty',
            'qwerty123456789', 'letmein', 'iloveyou', 'admin'
        ]);
        const commonPatterns = [
            'password', 'contrasena', 'contraseña', 'qwerty', 'letmein',
            'iloveyou', 'admin', '123456', 'abcdef', 'asdfgh'
        ];

        function setFieldError(input, message) {
            const error = document.getElementById(`${input.id}-error`);
            error.textContent = message;
            error.hidden = !message;
            input.setAttribute('aria-invalid', String(Boolean(message)));
            input.setCustomValidity(message);
            return !message;
        }

        function validateName(showEmpty = false) {
            const name = nameInput.value.trim();
            const message = !name && showEmpty
                ? 'Escribe tu nombre para crear la cuenta.'
                : (name.length > 255 ? 'El nombre no puede superar los 255 caracteres.' : '');

            return setFieldError(nameInput, message);
        }

        function validateEmailFormat(showEmpty = false) {
            const email = emailInput.value;
            let message = '';

            if (!email && showEmpty) {
                message = 'Escribe tu correo electrónico.';
            } else if (email && email.length > 255) {
                message = 'El correo no puede superar los 255 caracteres.';
            } else if (email && (/\s/.test(email) || emailInput.validity.typeMismatch || !/^[^@\s]+@[^@\s]+\.[a-zA-Z]{2,}$/.test(email))) {
                message = 'Escribe un correo electrónico válido, sin espacios.';
            }

            return setFieldError(emailInput, message);
        }

        function setEmailStatus(message, state = '') {
            emailStatus.textContent = message;
            emailStatus.className = `field-status${state ? ` ${state}` : ''}`;
        }

        async function checkEmailAvailability() {
            window.clearTimeout(emailCheckTimer);
            if (!validateEmailFormat()) {
                emailCheckState = 'idle';
                setEmailStatus('');
                return false;
            }

            if (emailCheckController) {
                emailCheckController.abort();
            }

            const controller = new AbortController();
            emailCheckController = controller;
            const emailBeingChecked = emailInput.value;
            emailCheckState = 'checking';
            setEmailStatus('Comprobando si el correo está disponible…', 'pending');

            try {
                const url = new URL(registrationForm.dataset.emailCheckUrl, window.location.href);
                url.searchParams.set('email', emailBeingChecked);
                const response = await fetch(url, {
                    headers: { Accept: 'application/json' },
                    signal: controller.signal,
                });
                const result = await response.json();

                if (controller.signal.aborted || emailInput.value !== emailBeingChecked) {
                    return false;
                }

                if (response.status === 422) {
                    emailCheckState = 'invalid';
                    emailAvailabilityMessage = result.message || 'Revisa el formato del correo.';
                    setFieldError(emailInput, emailAvailabilityMessage);
                    setEmailStatus('');
                    return false;
                }

                if (!response.ok) {
                    throw new Error(`No se pudo comprobar el correo (HTTP ${response.status}).`);
                }

                if (!result.available) {
                    emailCheckState = 'unavailable';
                    emailAvailabilityMessage = result.message;
                    setFieldError(emailInput, emailAvailabilityMessage);
                    setEmailStatus('');
                    return false;
                }

                emailCheckState = 'available';
                emailAvailabilityMessage = '';
                setFieldError(emailInput, '');
                setEmailStatus(result.message, 'success');
                return true;
            } catch (error) {
                if (error.name === 'AbortError') {
                    return false;
                }

                emailCheckState = 'error';
                setEmailStatus('No pudimos comprobar el correo ahora. Al registrarte, el sistema volverá a validarlo.', 'pending');
                return false;
            }
        }

        function scheduleEmailCheck() {
            window.clearTimeout(emailCheckTimer);
            if (emailCheckController) {
                emailCheckController.abort();
            }

            emailCheckState = 'idle';
            emailAvailabilityMessage = '';
            if (!validateEmailFormat()) {
                setEmailStatus('');
                return;
            }

            emailCheckTimer = window.setTimeout(checkEmailAvailability, 500);
        }

        function validatePassword(showEmpty = false) {
            const password = passwordInput.value;
            const length = Array.from(password).length;
            const isAllowed = /^[A-Za-z0-9!@#$%&*_.-]+$/.test(password);
            const hasComposition = /[A-Z]/.test(password)
                && /[a-z]/.test(password)
                && /[0-9]/.test(password)
                && /[!@#$%&*_.-]/.test(password);
            const normalizedPassword = password.toLowerCase();
            const isCommon = commonPasswords.has(normalizedPassword)
                || commonPatterns.some((pattern) => normalizedPassword.includes(pattern))
                || /(.)\1{4,}/.test(password);
            let message = '';

            if (!password && showEmpty) {
                message = 'Escribe una contraseña.';
            } else if (password && (length < 8 || length > 12)) {
                message = 'La contraseña debe tener entre 8 y 12 caracteres.';
            } else if (password && !isAllowed) {
                message = 'La contraseña solo puede contener letras sin acentos, números y estos símbolos: ! @ # $ % & * _ - .';
            } else if (password && !hasComposition) {
                message = 'Incluye al menos una mayúscula, una minúscula, un número y un símbolo permitido.';
            } else if (password && isCommon) {
                message = 'Elige una contraseña que no sea común o fácil de adivinar.';
            }

            setFieldError(passwordInput, message);
            return !message;
        }

        function validateConfirmation(showEmpty = false) {
            const confirmation = confirmationInput.value;
            const message = !confirmation && showEmpty
                ? 'Confirma tu contraseña.'
                : (confirmation && confirmation !== passwordInput.value ? 'La confirmación no coincide con la contraseña.' : '');

            return setFieldError(confirmationInput, message);
        }

        function updatePasswordStrength() {
            const password = passwordInput.value;
            const length = Array.from(password).length;
            const normalizedPassword = password.toLowerCase();
            const isAllowed = /^[A-Za-z0-9!@#$%&*_.-]+$/.test(password);
            const hasComposition = /[A-Z]/.test(password)
                && /[a-z]/.test(password)
                && /[0-9]/.test(password)
                && /[!@#$%&*_.-]/.test(password);
            const isCommon = commonPasswords.has(normalizedPassword)
                || commonPatterns.some((pattern) => normalizedPassword.includes(pattern))
                || /(.)\1{4,}/.test(password);
            const isStrong = length >= 8 && length <= 12 && isAllowed && hasComposition && !isCommon;
            const isMedium = length >= 8 && length <= 12 && isAllowed && !isCommon && !isStrong;
            const state = isStrong ? 'strong' : (isMedium ? 'medium' : 'weak');
            const labels = { weak: 'Insegura', medium: 'Intermedia', strong: 'Segura' };

            lengthCheck.className = length >= 8 && length <= 12
                ? 'strength-strong'
                : (length < 8 ? 'strength-weak' : 'strength-medium');
            compositionCheck.className = hasComposition ? 'strength-strong' : (password ? 'strength-weak' : 'strength-neutral');
            charactersCheck.className = isAllowed ? 'strength-strong' : (password ? 'strength-weak' : 'strength-neutral');
            commonCheck.className = isCommon ? 'strength-weak' : (password ? 'strength-strong' : 'strength-neutral');
            strengthStatus.textContent = password ? `Seguridad: ${labels[state]}` : 'Seguridad: escribe una contraseña';
            document.getElementById('password-strength').className = `password-strength strength-${password ? state : 'neutral'}`;
        }

        nameInput.addEventListener('input', () => {
            validateName();
        });
        nameInput.addEventListener('blur', () => {
            validateName(true);
        });
        emailInput.addEventListener('input', () => {
            scheduleEmailCheck();
        });
        emailInput.addEventListener('blur', () => {
            if (validateEmailFormat(true)) {
                checkEmailAvailability();
            }
        });
        passwordInput.addEventListener('input', () => {
            validatePassword();
            updatePasswordStrength();
            if (confirmationInput.value) {
                validateConfirmation();
            }
        });
        passwordInput.addEventListener('blur', () => {
            validatePassword(true);
        });
        confirmationInput.addEventListener('input', () => {
            validateConfirmation();
        });
        confirmationInput.addEventListener('blur', () => {
            validateConfirmation(true);
        });

        registrationForm.addEventListener('submit', (event) => {
            const fieldsAreValid = [
                validateName(true),
                validateEmailFormat(true),
                validatePassword(true),
                validateConfirmation(true),
            ].every(Boolean);

            if (!fieldsAreValid) {
                event.preventDefault();
                registrationForm.querySelector('[aria-invalid="true"]')?.focus();
                return;
            }

            if (emailCheckState === 'unavailable' || emailCheckState === 'invalid') {
                event.preventDefault();
                setFieldError(emailInput, emailAvailabilityMessage);
                emailInput.focus();
                return;
            }

            if (emailCheckState === 'checking') {
                event.preventDefault();
                submitAfterEmailCheck = true;
                setEmailStatus('Espera un momento mientras comprobamos el correo…', 'pending');
                checkEmailAvailability().then((available) => {
                    if (submitAfterEmailCheck && (available || emailCheckState === 'error')) {
                        submitAfterEmailCheck = false;
                        registrationForm.requestSubmit(submitButton);
                    } else {
                        submitAfterEmailCheck = false;
                        if (emailCheckState === 'unavailable' || emailCheckState === 'invalid') {
                            emailInput.focus();
                        }
                    }
                });
                return;
            }

            if (emailCheckState === 'idle') {
                event.preventDefault();
                submitAfterEmailCheck = true;
                checkEmailAvailability().then((available) => {
                    if (submitAfterEmailCheck && (available || emailCheckState === 'error')) {
                        submitAfterEmailCheck = false;
                        registrationForm.requestSubmit(submitButton);
                    } else {
                        submitAfterEmailCheck = false;
                        if (emailCheckState === 'unavailable') {
                            emailInput.focus();
                        }
                    }
                });
            }
        });

        if (nameInput.value) {
            validateName();
        }
        if (emailInput.value && validateEmailFormat()) {
            checkEmailAvailability();
        }
        if (passwordInput.value) {
            validatePassword();
            updatePasswordStrength();
        }
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