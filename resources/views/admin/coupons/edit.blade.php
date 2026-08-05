<x-layouts.admin :title="'Edit '.$coupon->code">
    <h1 class="font-heading text-2xl font-bold text-ink-900 mb-8">Edit Coupon</h1>

    <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.coupons._form')
    </form>
</x-layouts.admin>
