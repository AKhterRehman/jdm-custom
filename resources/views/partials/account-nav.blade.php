<nav class="flex flex-col gap-1 text-sm">
    @php
        $links = [
            ['route' => 'account.index', 'label' => 'Overview'],
            ['route' => 'orders.index', 'label' => 'Orders'],
            ['route' => 'addresses.index', 'label' => 'Addresses'],
            ['route' => 'wishlist.index', 'label' => 'Wishlist'],
            ['route' => 'profile.edit', 'label' => 'Profile & Password'],
        ];
    @endphp

    @foreach ($links as $link)
        <a
            href="{{ route($link['route']) }}"
            class="rounded-md px-3 py-2 font-medium {{ request()->routeIs($link['route'].'*') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100' }}"
        >
            {{ $link['label'] }}
        </a>
    @endforeach
</nav>
