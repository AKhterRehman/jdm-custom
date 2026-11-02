<x-layouts.admin :title="'Edit '.$category->name">
    <h1 class="font-display text-3xl font-medium text-white mb-8">Edit Category</h1>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.categories._form')
    </form>
</x-layouts.admin>
