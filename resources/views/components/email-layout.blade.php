@props(['preheader' => ''])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="dark">
    <title>{{ config('app.name') }}</title>
</head>
<body style="margin:0;padding:0;background-color:#0b0b0d;">
    <div style="display:none;max-height:0;overflow:hidden;opacity:0;">{{ $preheader }}</div>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#0b0b0d;">
        <tr>
            <td align="center" style="padding:32px 16px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;">
                    <tr>
                        <td align="center" style="padding:8px 0 28px;">
                            <img src="{{ asset('images/jdm-logo-gold.png') }}" alt="JDM Custom Creations" height="84" style="display:block;height:84px;width:auto;border:0;">
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#17171a;border:1px solid #2b2b30;border-top:3px solid #c0a062;padding:40px 36px;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:15px;line-height:1.7;color:#b4b8bf;">
                            {{ $slot }}
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding:28px 16px 8px;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:12px;line-height:1.6;color:#8f949c;">
                            &copy; {{ date('Y') }} JDM Custom Creations<br>
                            Luxury automotive art, hand finished in hardwood and epoxy.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
