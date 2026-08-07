@if ($errors->any())
    <div class="mb-6 rounded-md bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
        <ul class="list-disc pl-4">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid sm:grid-cols-2 gap-4 max-w-3xl">
    <div class="sm:col-span-2">
        <label class="text-sm font-medium text-gray-700">Name</label>
        <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required class="mt-1 w-full rounded-md border-gray-300 text-sm">
    </div>

    <div>
        <label class="text-sm font-medium text-gray-700">Slug (optional)</label>
        <input type="text" name="slug" value="{{ old('slug', $product->slug ?? '') }}" placeholder="auto-generated from name" class="mt-1 w-full rounded-md border-gray-300 text-sm">
    </div>

    <div>
        <label class="text-sm font-medium text-gray-700">Category</label>
        <select name="category_id" required class="mt-1 w-full rounded-md border-gray-300 text-sm">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? null) == $category->id)>
                    {{ $category->parent ? $category->parent->name.' / ' : '' }}{{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="sm:col-span-2">
        <label class="text-sm font-medium text-gray-700">Short Description</label>
        <input type="text" name="short_description" value="{{ old('short_description', $product->short_description ?? '') }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
    </div>

    <div class="sm:col-span-2">
        <label class="text-sm font-medium text-gray-700">Description</label>
        <textarea name="description" rows="4" class="mt-1 w-full rounded-md border-gray-300 text-sm">{{ old('description', $product->description ?? '') }}</textarea>
    </div>

    <div>
        <label class="text-sm font-medium text-gray-700">Price</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '') }}" required class="mt-1 w-full rounded-md border-gray-300 text-sm">
    </div>

    <div>
        <label class="text-sm font-medium text-gray-700">Sale Price (optional)</label>
        <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price', $product->sale_price ?? '') }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
    </div>

    <div>
        <label class="text-sm font-medium text-gray-700">SKU (optional)</label>
        <input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
    </div>

    <div>
        <label class="text-sm font-medium text-gray-700">Total Stock Quantity</label>
        <input type="number" name="total_stock_quantity" value="{{ old('total_stock_quantity', $product->total_stock_quantity ?? 0) }}" min="0" required class="mt-1 w-full rounded-md border-gray-300 text-sm">
    </div>

    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
        Active (visible on storefront)
    </label>

    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
        Featured on homepage
    </label>
</div>

<button type="submit" class="mt-6 rounded-md bg-ink-900 px-6 py-3 font-semibold text-white hover:bg-red-600 transition">
    Save Product
</button>
