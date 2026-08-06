<x-layouts.admin :title="$message->subject">
    <a href="{{ route('admin.contact-messages.index') }}" class="text-sm text-gray-500 hover:text-red-600">&larr; Back to messages</a>

    <div class="mt-2 max-w-2xl">
        <h1 class="font-heading text-2xl font-bold text-ink-900">{{ $message->subject }}</h1>
        <p class="mt-1 text-gray-500">
            From <strong class="text-ink-900">{{ $message->name }}</strong>
            &lt;<a href="mailto:{{ $message->email }}" class="text-red-600 hover:underline">{{ $message->email }}</a>&gt;
            &middot; {{ $message->created_at->format('M j, Y g:ia') }}
        </p>

        <dl class="mt-6 grid gap-x-6 gap-y-4 rounded-lg border border-gray-200 bg-gray-50 p-5 text-sm sm:grid-cols-2">
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wider text-gray-400">Phone</dt>
                <dd class="mt-1 text-gray-700">{{ $message->phone ?: 'Not provided' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wider text-gray-400">Company</dt>
                <dd class="mt-1 text-gray-700">{{ $message->company_name ?: 'Not provided' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wider text-gray-400">Enquiry type</dt>
                <dd class="mt-1 text-gray-700">{{ $message->inquiry_type ? ucfirst(str_replace('-', ' ', $message->inquiry_type)) : 'Not specified' }}</dd>
            </div>
        </dl>

        <div class="mt-6 rounded-lg border border-gray-200 bg-white p-6 text-gray-700 leading-relaxed whitespace-pre-line">{{ $message->message }}</div>

        <div class="mt-6 flex gap-3">
            <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}" class="rounded-md bg-ink-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-600 transition">Reply by Email</a>
            <form action="{{ route('admin.contact-messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Delete this message?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="rounded-md border border-gray-300 px-5 py-2.5 text-sm hover:border-red-600">Delete</button>
            </form>
        </div>
    </div>
</x-layouts.admin>
