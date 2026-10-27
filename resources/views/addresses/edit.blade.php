<x-layouts.account title="Edit Address">
    <h1 class="font-lux text-2xl font-normal text-[#ece7da] mb-8 text-[clamp(2.2rem,4vw,3.4rem)] leading-[1.05] tracking-[-0.01em]">Edit Address</h1>

    <form action="{{ route('addresses.update', $address) }}" method="POST">
        @csrf
        @method('PUT')
        @include('addresses._form')
    </form>
</x-layouts.account>
