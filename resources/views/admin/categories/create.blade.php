<x-layouts.admin title="Add Category">
    <h1 class="text-2xl font-bold mb-8">Add Category</h1>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        @include('admin.categories._form')
    </form>
</x-layouts.admin>
