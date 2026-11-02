@php
    $row = 'padding:10px 0;border-bottom:1px solid #2b2b30;vertical-align:top;';
    $label = 'width:120px;font-size:11px;font-weight:700;letter-spacing:0.18em;text-transform:uppercase;color:#c0a062;';
@endphp
<x-email-layout preheader="New enquiry from {{ $contactMessage->name }}: {{ $contactMessage->subject }}">
    <p style="margin:0 0 12px;font-size:11px;font-weight:700;letter-spacing:0.3em;text-transform:uppercase;color:#c0a062;">Contact form</p>
    <h1 style="margin:0 0 24px;font-family:Georgia,'Times New Roman',serif;font-size:30px;font-weight:400;line-height:1.2;color:#ffffff;">New contact enquiry</h1>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 28px;">
        <tr>
            <td style="{{ $row }}{{ $label }}">From</td>
            <td style="{{ $row }}color:#ffffff;">{{ $contactMessage->name }} &lt;<a href="mailto:{{ $contactMessage->email }}" style="color:#e0c993;text-decoration:none;">{{ $contactMessage->email }}</a>&gt;</td>
        </tr>
        <tr>
            <td style="{{ $row }}{{ $label }}">Subject</td>
            <td style="{{ $row }}color:#ffffff;">{{ $contactMessage->subject }}</td>
        </tr>
        @if ($contactMessage->phone)
            <tr>
                <td style="{{ $row }}{{ $label }}">Phone</td>
                <td style="{{ $row }}color:#ffffff;">{{ $contactMessage->phone }}</td>
            </tr>
        @endif
        @if ($contactMessage->company_name)
            <tr>
                <td style="{{ $row }}{{ $label }}">Company</td>
                <td style="{{ $row }}color:#ffffff;">{{ $contactMessage->company_name }}</td>
            </tr>
        @endif
        @if ($contactMessage->inquiry_type)
            <tr>
                <td style="{{ $row }}{{ $label }}">Enquiry type</td>
                <td style="{{ $row }}color:#ffffff;">{{ ucfirst(str_replace('-', ' ', $contactMessage->inquiry_type)) }}</td>
            </tr>
        @endif
    </table>

    <p style="margin:0 0 10px;font-size:11px;font-weight:700;letter-spacing:0.18em;text-transform:uppercase;color:#c0a062;">Message</p>
    <div style="margin:0;padding:18px 20px;background-color:#0b0b0d;border-left:3px solid #c0a062;color:#d4d7dc;">{!! nl2br(e($contactMessage->message)) !!}</div>
</x-email-layout>
