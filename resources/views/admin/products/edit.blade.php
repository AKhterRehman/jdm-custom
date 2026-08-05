<x-layouts.admin :title="'Edit '.$product->name">
    <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-500 hover:text-red-600">&larr; Back to products</a>

    <h1 class="text-2xl font-bold mt-2 mb-8">Edit Product</h1>

    <form action="{{ route('admin.products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.products._form')
    </form>

    <div class="mt-14 grid lg:grid-cols-3 gap-10 max-w-5xl">
        <section>
            <h2 class="font-semibold mb-3">Gallery Images</h2>
            <ul class="space-y-2 mb-4 text-sm">
                @forelse ($product->images as $image)
                    <li class="flex items-center justify-between gap-2 rounded-md border border-gray-200 px-3 py-2">
                        <span class="flex items-center gap-2 truncate">
                            <img src="{{ $image->url() }}" alt="" class="h-8 w-8 rounded object-cover shrink-0">
                            <span class="truncate">{{ $image->alt_text ?: 'Image #'.$image->id }}</span>
                        </span>
                        <form action="{{ route('admin.products.images.destroy', [$product, $image]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-600">&times;</button>
                        </form>
                    </li>
                @empty
                    <li class="text-gray-400">No images yet.</li>
                @endforelse
            </ul>
            <form action="{{ route('admin.products.images.store', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-2">
                @csrf
                <input type="file" name="image" accept="image/*" required class="w-full rounded-md border-gray-300 text-sm">
                <input type="text" name="alt_text" placeholder="Alt text (optional)" class="w-full rounded-md border-gray-300 text-sm">
                <button type="submit" class="w-full rounded-md border border-gray-300 py-2 text-sm hover:border-red-600">Upload Image</button>
            </form>
        </section>

        <section>
            <h2 class="font-semibold mb-3">Specifications</h2>
            <ul class="space-y-2 mb-4 text-sm">
                @forelse ($product->specifications as $spec)
                    <li class="flex items-center justify-between gap-2 rounded-md border border-gray-200 px-3 py-2">
                        <span class="truncate">{{ $spec->spec_key }}: {{ $spec->spec_value }}</span>
                        <form action="{{ route('admin.products.specifications.destroy', [$product, $spec]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-600">&times;</button>
                        </form>
                    </li>
                @empty
                    <li class="text-gray-400">No specifications yet.</li>
                @endforelse
            </ul>
            <form action="{{ route('admin.products.specifications.store', $product) }}" method="POST" class="space-y-2">
                @csrf
                <input type="text" name="spec_key" placeholder="Key (e.g. Brand)" required class="w-full rounded-md border-gray-300 text-sm">
                <input type="text" name="spec_value" placeholder="Value" required class="w-full rounded-md border-gray-300 text-sm">
                <button type="submit" class="w-full rounded-md border border-gray-300 py-2 text-sm hover:border-red-600">Add Specification</button>
            </form>
        </section>

        <section>
            <h2 class="font-semibold mb-3">Variations</h2>
            <ul class="space-y-2 mb-4 text-sm">
                @forelse ($product->variations as $variation)
                    <li class="flex items-center justify-between gap-2 rounded-md border border-gray-200 px-3 py-2">
                        <span class="truncate">{{ $variation->attribute_name }}: {{ $variation->attribute_value }} (+${{ number_format($variation->price_adjustment, 2) }}, {{ $variation->stock_quantity }} in stock)</span>
                        <form action="{{ route('admin.products.variations.destroy', [$product, $variation]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-600">&times;</button>
                        </form>
                    </li>
                @empty
                    <li class="text-gray-400">No variations yet.</li>
                @endforelse
            </ul>
            <form action="{{ route('admin.products.variations.store', $product) }}" method="POST" class="space-y-2">
                @csrf
                <input type="text" name="attribute_name" placeholder="Attribute (e.g. Size)" required class="w-full rounded-md border-gray-300 text-sm">
                <input type="text" name="attribute_value" placeholder="Value (e.g. 18-inch)" required class="w-full rounded-md border-gray-300 text-sm">
                <input type="number" step="0.01" name="price_adjustment" value="0" placeholder="Price adjustment" class="w-full rounded-md border-gray-300 text-sm">
                <input type="number" name="stock_quantity" value="0" placeholder="Stock quantity" class="w-full rounded-md border-gray-300 text-sm">
                <button type="submit" class="w-full rounded-md border border-gray-300 py-2 text-sm hover:border-red-600">Add Variation</button>
            </form>
        </section>
    </div>
</x-layouts.admin>
