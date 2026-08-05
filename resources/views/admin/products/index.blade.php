<x-layouts.admin title="Products">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold">Products</h1>
        <a href="{{ route('admin.products.create') }}" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-red-600 transition">
            Add Product
        </a>
    </div>

    <form method="GET" class="flex flex-wrap gap-3 mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="rounded-md border-gray-300 text-sm">
        <select name="category_id" class="rounded-md border-gray-300 text-sm">
            <option value="">All Categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="low_stock" value="1" @checked(request('low_stock'))>
            Low stock only
        </label>
        <button type="submit" class="rounded-md border border-gray-300 px-4 py-2 text-sm hover:border-red-600">Filter</button>
    </form>

    <div class="rounded-lg border border-gray-200 bg-white overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-500">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Category</th>
                    <th class="px-4 py-3">Price</th>
                    <th class="px-4 py-3">Stock</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($products as $product)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $product->name }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $product->category->name }}</td>
                        <td class="px-4 py-3">${{ number_format($product->sale_price ?? $product->price, 2) }}</td>
                        <td class="px-4 py-3 {{ $product->stock_quantity <= 5 ? 'text-red-600 font-semibold' : '' }}">{{ $product->stock_quantity }}</td>
                        <td class="px-4 py-3">
                            <span class="rounded-full px-2 py-1 text-xs font-medium {{ $product->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $product->is_active ? 'Active' : 'Hidden' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right space-x-3">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-gray-600 hover:text-red-600">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No products found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</x-layouts.admin>
