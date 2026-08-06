<h1>New contact enquiry</h1>

<p><strong>From:</strong> {{ $contactMessage->name }} &lt;{{ $contactMessage->email }}&gt;</p>
<p><strong>Subject:</strong> {{ $contactMessage->subject }}</p>

@if ($contactMessage->phone)
    <p><strong>Phone:</strong> {{ $contactMessage->phone }}</p>
@endif

@if ($contactMessage->company_name)
    <p><strong>Company:</strong> {{ $contactMessage->company_name }}</p>
@endif

@if ($contactMessage->inquiry_type)
    <p><strong>Enquiry type:</strong> {{ ucfirst(str_replace('-', ' ', $contactMessage->inquiry_type)) }}</p>
@endif

<hr>

<p><strong>Message</strong></p>
<p>{!! nl2br(e($contactMessage->message)) !!}</p>
