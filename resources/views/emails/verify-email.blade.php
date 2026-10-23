<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light">
    <title>Confirma tu correo electrónico</title>
</head>
<body style="margin:0; padding:0; background-color:#f1f5f9; color:#172033; font-family:Arial,Helvetica,sans-serif;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#f1f5f9; padding:32px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:620px; background-color:#ffffff; border-radius:16px; overflow:hidden;">
                    <tr>
                        <td style="background-color:#10243a; padding:32px 40px; text-align:center;">
                            <p style="margin:0 0 8px; color:#65d5c4; font-size:13px; font-weight:bold; letter-spacing:2px; text-transform:uppercase;">{{ $appName }}</p>
                            <h1 style="margin:0; color:#ffffff; font-size:26px; line-height:1.3;">Un paso más para comenzar</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:36px 40px 24px;">
                            <p style="margin:0 0 16px; font-size:17px; line-height:1.6;">Hola, <strong>{{ $user->name }}</strong>:</p>
                            <p style="margin:0 0 18px; color:#475569; font-size:15px; line-height:1.7;">
                                Gracias por crear tu cuenta en <strong>{{ $appName }}</strong>. Usa este código para confirmar que esta dirección de correo te pertenece y activar el acceso a tu cuenta:
                            </p>
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin:28px auto;">
                                <tr>
                                    <td align="center" style="border-radius:8px; background-color:#f0fdfa; border:1px solid #14b8a6; padding:16px 28px; color:#087f72; font-size:32px; font-weight:bold; letter-spacing:8px;">
                                        {{ $code }}
                                    </td>
                                </tr>
                            </table>
                            <p style="margin:0 0 22px; color:#475569; font-size:14px; line-height:1.7;">
                                El código es personal y caduca en {{ $expirationMinutes }} minutos. Introdúcelo en la pantalla de verificación de tu cuenta.
                            </p>
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin:0 0 24px; background-color:#f0fdfa; border-left:4px solid #14b8a6;">
                                <tr>
                                    <td style="padding:16px 18px; color:#334155; font-size:13px; line-height:1.7;">
                                        <strong>¿No creaste esta cuenta?</strong><br>
                                        No tienes que hacer nada. Ignora este mensaje y tu dirección no se verificará.
                                    </td>
                                </tr>
                            </table>
                            <p style="margin:0; color:#475569; font-size:14px; line-height:1.7;">
                                Por seguridad, no compartas este código con otras personas. Si necesitas uno nuevo, vuelve a la pantalla de verificación y solicita otro.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px 40px 28px; border-top:1px solid #e2e8f0; color:#64748b; font-size:12px; line-height:1.7; text-align:center;">
                            <p style="margin:0 0 4px;">Este mensaje se envió a {{ $user->email }} porque se creó una cuenta con esta dirección.</p>
                            <p style="margin:0;">© {{ date('Y') }} {{ $appName }}. Mensaje automático; no respondas a este correo.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
