<x-layouts.admin title="Add Coupon">
    <h1 class="text-2xl font-bold mb-8">Add Coupon</h1>

    <form action="{{ route('admin.coupons.store') }}" method="POST">
        @csrf
        @include('admin.coupons._form')
    </form>
</x-layouts.admin>
