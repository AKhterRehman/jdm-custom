<x-layouts.admin title="Categories">
    <div class="flex items-center justify-between mb-8">
        <h1 class="font-display text-3xl font-medium text-white">Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="rounded-md bg-gold-500 px-4 py-2 text-sm font-semibold text-ink-900 hover:bg-gold-400 transition">
            Add Category
        </a>
    </div>

    <div class="rounded-lg border border-white/10 bg-charcoal-800 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-white/5 text-left text-silver-400">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Parent</th>
                    <th class="px-4 py-3">Products</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/10">
                @forelse ($categories as $category)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $category->name }}</td>
                        <td class="px-4 py-3 text-silver-400">{{ $category->parent?->name ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $category->products_count }}</td>
                        <td class="px-4 py-3">
                            <span class="rounded-full px-2 py-1 text-xs font-medium {{ $category->is_active ? 'bg-green-500/10 text-green-300' : 'bg-white/5 text-silver-400' }}">
                                {{ $category->is_active ? 'Active' : 'Hidden' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right space-x-3">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-silver-300 hover:text-gold-400">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Delete this category?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-silver-500 hover:text-gold-400">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-6 text-center text-silver-400">No categories yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <div class="dark-pagination">{{ $categories->links() }}</div>
    </div>
</x-layouts.admin>
