<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Recuperar Contraseña</title>
</head>
<body style="margin:0; padding:0; font-family: 'Nunito', Arial, sans-serif; background: #ffffff;">

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
  <td align="center">
    <table width="560" cellpadding="0" cellspacing="0" style="background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 30px 60px rgba(0,0,0,.08); border: 1px solid #000000;">

      <!-- Header -->
      <tr>
        <td align="center" style="background:#8B2E00; color:#fff; padding:48px 24px;">
          <h1 style="font-family:'Nova', sans-serif; font-size:40px; margin:0 0 8px; color:#fff;">Recuperar Contraseña</h1>
          <div style="width:56px; height:6px; background:#f5b301; border-radius:999px; margin:0 auto 10px;"></div>
          <p style="opacity:.9; font-size:14px; margin:0;">Sigue el enlace para restablecer tu contraseña</p>
        </td>
      </tr>

      <!-- Body -->
      <tr>
        <td style="padding:40px 48px; color:#1f2937; font-size:15px; line-height:1.5;">
          
          <p>Hola {{ $user->name ?? 'usuario' }},</p>

          @isset($introLines)
            @foreach ($introLines as $line)
              <p>{{ $line }}</p>
            @endforeach
          @endisset

          @isset($actionText)
            <p style="text-align:center; margin:24px 0;">
              <a href="{{ $actionUrl }}" style="background:#8B2E00; color:#fff; border-radius:10px; font-weight:700; text-decoration:none; display:inline-block; padding:14px 20px;">
                {{ $actionText }}
              </a>
            </p>
          @endisset

          @isset($outroLines)
            @foreach ($outroLines as $line)
              <p>{{ $line }}</p>
            @endforeach
          @endisset

          <p>Saludos,<br>{{ config('app.name') }}</p>

          @isset($actionText)
            <p style="font-size:.85rem; color:#6b7280; margin-top:20px;">
              Si tienes problemas haciendo clic en el botón "{{ $actionText }}", copia y pega la URL en tu navegador:<br>
              <a href="{{ $actionUrl }}" style="word-break: break-all; color:#8B2E00;">{{ $actionUrl }}</a>
            </p>
          @endisset

        </td>
      </tr>

    </table>
  </td>
</tr>
</table>

</body>
</html>
