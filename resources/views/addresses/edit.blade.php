<x-layouts.account title="Edit Address">
    <h1 class="font-heading text-2xl font-bold text-ink-900 mb-8">Edit Address</h1>

    <form action="{{ route('addresses.update', $address) }}" method="POST">
        @csrf
        @method('PUT')
        @include('addresses._form')
    </form>
</x-layouts.account>
