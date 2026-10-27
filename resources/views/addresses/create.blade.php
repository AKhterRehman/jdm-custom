<x-layouts.account title="Add Address">
    <h1 class="font-lux text-2xl font-normal text-[#ece7da] mb-8 text-[clamp(2.2rem,4vw,3.4rem)] leading-[1.05] tracking-[-0.01em]">Add Address</h1>

    <form action="{{ route('addresses.store') }}" method="POST">
        @csrf
        @include('addresses._form')
    </form>
</x-layouts.account>
