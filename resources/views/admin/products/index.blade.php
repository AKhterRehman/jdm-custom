<x-layouts.admin title="Products">
    <div class="flex items-center justify-between mb-8">
        <h1 class="font-display text-3xl font-medium text-white">Products</h1>
        <a href="{{ route('admin.products.create') }}" class="rounded-md bg-gold-500 px-4 py-2 text-sm font-semibold text-ink-900 hover:bg-gold-400 transition">
            Add Product
        </a>
    </div>

    <form method="GET" class="flex flex-wrap gap-3 mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="rounded-md border-white/15 text-sm">
        <select name="category_id" class="rounded-md border-white/15 text-sm">
            <option value="">All Categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="low_stock" value="1" @checked(request('low_stock'))>
            Low stock only
        </label>
        <button type="submit" class="rounded-md border border-white/15 px-4 py-2 text-sm hover:border-gold-500">Filter</button>
    </form>

    <div class="rounded-lg border border-white/10 bg-charcoal-800 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-white/5 text-left text-silver-400">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Category</th>
                    <th class="px-4 py-3">Price</th>
                    <th class="px-4 py-3">Total Stock</th>
                    <th class="px-4 py-3">Available Stock</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/10">
                @forelse ($products as $product)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $product->name }}</td>
                        <td class="px-4 py-3 text-silver-400">{{ $product->category->name }}</td>
                        <td class="px-4 py-3">${{ number_format($product->sale_price ?? $product->price, 2) }}</td>
                        <td class="px-4 py-3">{{ $product->total_stock_quantity }}</td>
                        <td class="px-4 py-3 {{ $product->available_stock_quantity <= 5 ? 'text-red-400 font-semibold' : '' }}">{{ $product->available_stock_quantity }}</td>
                        <td class="px-4 py-3">
                            <span class="rounded-full px-2 py-1 text-xs font-medium {{ $product->is_active ? 'bg-green-500/10 text-green-300' : 'bg-white/5 text-silver-400' }}">
                                {{ $product->is_active ? 'Active' : 'Hidden' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right space-x-3">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-silver-300 hover:text-gold-400">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-silver-500 hover:text-gold-400">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-6 text-center text-silver-400">No products found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <div class="dark-pagination">{{ $products->links() }}</div>
    </div>
</x-layouts.admin>
