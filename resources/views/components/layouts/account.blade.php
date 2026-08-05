<x-layouts.storefront :title="$title ?? 'My Account'">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if (session('status'))
            <div class="mb-6 rounded-md bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid md:grid-cols-4 gap-10">
            <div class="md:col-span-1">
                @include('partials.account-nav')
            </div>

            <div class="md:col-span-3">
                {{ $slot }}
            </div>
        </div>
    </div>
</x-layouts.storefront>
