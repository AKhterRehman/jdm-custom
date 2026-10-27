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
            class="rounded-none px-3 py-2.5 font-medium transition {{ request()->routeIs($link['route'].'*') ? 'bg-ink-900 text-white' : 'text-[#b9b5ab] hover:bg-white/5' }}"
        >
            {{ $link['label'] }}
        </a>
    @endforeach
</nav>
