<x-layouts.admin title="Contact Messages">
    <h1 class="font-heading text-2xl font-bold text-ink-900 mb-8">Contact Messages</h1>

    <div class="rounded-lg border border-gray-200 bg-white overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-500">
                <tr>
                    <th class="px-4 py-3">From</th>
                    <th class="px-4 py-3">Subject</th>
                    <th class="px-4 py-3">Received</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($messages as $message)
                    <tr class="cursor-pointer hover:bg-gray-50" onclick="window.location='{{ route('admin.contact-messages.show', $message) }}'">
                        <td class="px-4 py-3">
                            <p class="font-medium {{ $message->is_read ? 'text-gray-700' : 'text-ink-900' }}">{{ $message->name }}</p>
                            <p class="text-gray-500">{{ $message->email }}</p>
                        </td>
                        <td class="px-4 py-3 {{ $message->is_read ? '' : 'font-semibold text-ink-900' }}">{{ $message->subject }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $message->created_at->format('M j, Y g:ia') }}</td>
                        <td class="px-4 py-3">
                            @if (! $message->is_read)
                                <span class="rounded-full bg-red-50 text-red-600 px-2 py-1 text-xs font-medium">New</span>
                            @else
                                <span class="text-gray-400">Read</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <form action="{{ route('admin.contact-messages.destroy', $message) }}" method="POST" onclick="event.stopPropagation();" onsubmit="return confirm('Delete this message?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No messages yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $messages->links() }}
    </div>
</x-layouts.admin>
