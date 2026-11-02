<x-email-layout preheader="Your one-time code to reset your JDM Custom password.">
    <p style="margin:0 0 12px;font-size:11px;font-weight:700;letter-spacing:0.3em;text-transform:uppercase;color:#c0a062;">Account recovery</p>
    <h1 style="margin:0 0 20px;font-family:Georgia,'Times New Roman',serif;font-size:30px;font-weight:400;line-height:1.2;color:#ffffff;">Password reset verification</h1>

    <p style="margin:0 0 24px;">Use the following one-time code to continue resetting your JDM Custom password.</p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 24px;">
        <tr>
            <td align="center" style="background-color:#0b0b0d;border:1px solid #2b2b30;padding:22px 12px;font-family:'Courier New',Courier,monospace;font-size:34px;font-weight:700;letter-spacing:0.4em;color:#e0c993;">{{ $code }}</td>
        </tr>
    </table>

    <p style="margin:0 0 8px;">This code expires in 10 minutes.</p>
    <p style="margin:0;color:#8f949c;font-size:13px;">If you did not request a password reset, you can safely ignore this email. Your password will not change.</p>
</x-email-layout>
