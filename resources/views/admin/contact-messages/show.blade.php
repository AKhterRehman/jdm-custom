<x-layouts.admin :title="$message->subject">
    <a href="{{ route('admin.contact-messages.index') }}" class="text-sm text-silver-400 hover:text-gold-400">&larr; Back to messages</a>

    <div class="mt-2 max-w-2xl">
        <h1 class="font-display text-3xl font-medium text-white">{{ $message->subject }}</h1>
        <p class="mt-1 text-silver-400">
            From <strong class="text-white">{{ $message->name }}</strong>
            &lt;<a href="mailto:{{ $message->email }}" class="text-gold-400 hover:underline">{{ $message->email }}</a>&gt;
            &middot; {{ $message->created_at->format('M j, Y g:ia') }}
        </p>

        <dl class="mt-6 grid gap-x-6 gap-y-4 rounded-lg border border-white/10 bg-white/5 p-5 text-sm sm:grid-cols-2">
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wider text-silver-500">Phone</dt>
                <dd class="mt-1 text-gray-200">{{ $message->phone ?: 'Not provided' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wider text-silver-500">Company</dt>
                <dd class="mt-1 text-gray-200">{{ $message->company_name ?: 'Not provided' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wider text-silver-500">Enquiry type</dt>
                <dd class="mt-1 text-gray-200">{{ $message->inquiry_type ? ucfirst(str_replace('-', ' ', $message->inquiry_type)) : 'Not specified' }}</dd>
            </div>
        </dl>

        <div class="mt-6 rounded-lg border border-white/10 bg-charcoal-800 p-6 text-gray-200 leading-relaxed whitespace-pre-line">{{ $message->message }}</div>

        <div class="mt-6 flex gap-3">
            <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}" class="rounded-md bg-gold-500 px-5 py-2.5 text-sm font-semibold text-ink-900 hover:bg-gold-400 transition">Reply by Email</a>
            <form action="{{ route('admin.contact-messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Delete this message?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="rounded-md border border-white/15 px-5 py-2.5 text-sm hover:border-gold-500">Delete</button>
            </form>
        </div>
    </div>
</x-layouts.admin>
