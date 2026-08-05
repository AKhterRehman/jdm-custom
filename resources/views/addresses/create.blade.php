<x-layouts.account title="Add Address">
    <h1 class="font-heading text-2xl font-bold text-ink-900 mb-8">Add Address</h1>

    <form action="{{ route('addresses.store') }}" method="POST">
        @csrf
        @include('addresses._form')
    </form>
</x-layouts.account>
