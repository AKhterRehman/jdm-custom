@if ($errors->any())
    <div class="mb-6 rounded-md bg-red-500/10 border border-red-500/30 px-4 py-3 text-sm text-red-300">
        <ul class="list-disc pl-4">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid sm:grid-cols-2 gap-4 max-w-xl">
    <div class="sm:col-span-2">
        <label class="text-sm font-medium text-gray-200">Name</label>
        <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" required class="mt-1 w-full rounded-md border-white/15 text-sm">
    </div>

    <div>
        <label class="text-sm font-medium text-gray-200">Slug (optional)</label>
        <input type="text" name="slug" value="{{ old('slug', $category->slug ?? '') }}" placeholder="auto-generated from name" class="mt-1 w-full rounded-md border-white/15 text-sm">
    </div>

    <div>
        <label class="text-sm font-medium text-gray-200">Parent Category</label>
        <select name="parent_id" class="mt-1 w-full rounded-md border-white/15 text-sm">
            <option value="">None (top-level)</option>
            @foreach ($parents as $parent)
                <option value="{{ $parent->id }}" @selected(old('parent_id', $category->parent_id ?? null) == $parent->id)>{{ $parent->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="sm:col-span-2">
        <label class="text-sm font-medium text-gray-200">Description</label>
        <textarea name="description" rows="3" class="mt-1 w-full rounded-md border-white/15 text-sm">{{ old('description', $category->description ?? '') }}</textarea>
    </div>

    <div>
        <label class="text-sm font-medium text-gray-200">Sort Order</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" class="mt-1 w-full rounded-md border-white/15 text-sm">
    </div>

    <label class="flex items-center gap-2 text-sm mt-6">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
        Active (visible on storefront)
    </label>
</div>

<button type="submit" class="mt-6 rounded-md bg-gold-500 px-6 py-3 font-semibold text-ink-900 hover:bg-gold-400 transition">
    Save Category
</button>
