<x-layouts.admin title="Add Product">
    <h1 class="font-heading text-2xl font-bold text-ink-900 mb-8">Add Product</h1>

    <form action="{{ route('admin.products.store') }}" method="POST">
        @csrf
        @include('admin.products._form')
    </form>

    <p class="mt-4 text-sm text-gray-500">Save the product first, then add gallery images, specifications, and variations from the edit page.</p>
</x-layouts.admin>
