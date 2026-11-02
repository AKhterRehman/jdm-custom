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
            class="border-l-2 px-3 py-2.5 font-medium transition {{ request()->routeIs(explode('.', $link['route'])[0].'.*') ? 'border-gold-500 bg-white/5 text-gold-300' : 'border-transparent text-silver-300 hover:bg-white/5 hover:text-white' }}"
        >
            {{ $link['label'] }}
        </a>
    @endforeach
</nav>
