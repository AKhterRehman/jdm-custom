<x-layouts.admin title="Contact Messages">
    <h1 class="font-display text-3xl font-medium text-white mb-8">Contact Messages</h1>

    <div class="rounded-lg border border-white/10 bg-charcoal-800 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-white/5 text-left text-silver-400">
                <tr>
                    <th class="px-4 py-3">From</th>
                    <th class="px-4 py-3">Subject</th>
                    <th class="px-4 py-3">Phone Number</th>
                    <th class="px-4 py-3">Company Name</th>
                    <th class="px-4 py-3">Inquiry Type</th>
                    <th class="px-4 py-3">Received</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/10">
                @forelse ($messages as $message)
                    <tr class="cursor-pointer hover:bg-white/5" onclick="window.location='{{ route('admin.contact-messages.show', $message) }}'">
                        <td class="px-4 py-3">
                            <p class="font-medium {{ $message->is_read ? 'text-gray-200' : 'text-ink-900' }}">{{ $message->name }}</p>
                            <p class="text-silver-400">{{ $message->email }}</p>
                        </td>
                        <td class="px-4 py-3 {{ $message->is_read ? '' : 'font-semibold text-ink-900' }}">{{ $message->subject }}</td>
                        <td class="px-4 py-3 text-silver-400">{{ $message->phone ?: '—' }}</td>
                        <td class="px-4 py-3 text-silver-400">{{ $message->company_name ?: '—' }}</td>
                        <td class="px-4 py-3 text-silver-400">{{ $message->inquiry_type ? ucfirst(str_replace('-', ' ', $message->inquiry_type)) : '—' }}</td>
                        <td class="px-4 py-3 text-silver-400">{{ $message->created_at->format('M j, Y g:ia') }}</td>
                        <td class="px-4 py-3">
                            @if (! $message->is_read)
                                <span class="rounded-full bg-gold-500/10 text-gold-400 px-2 py-1 text-xs font-medium">New</span>
                            @else
                                <span class="text-silver-500">Read</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <form action="{{ route('admin.contact-messages.destroy', $message) }}" method="POST" onclick="event.stopPropagation();" onsubmit="return confirm('Delete this message?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-silver-500 hover:text-gold-400">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="px-4 py-6 text-center text-silver-400">No messages yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <div class="dark-pagination">{{ $messages->links() }}</div>
    </div>
</x-layouts.admin>
