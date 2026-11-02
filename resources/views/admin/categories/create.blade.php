<x-layouts.admin title="Add Category">
    <h1 class="font-display text-3xl font-medium text-white mb-8">Add Category</h1>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        @include('admin.categories._form')
    </form>
</x-layouts.admin>
