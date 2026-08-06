<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title.' - ' : '' }}Admin - {{ config('app.name') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/update logo.png') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|lexend:600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 text-ink-900">
        <div class="flex min-h-screen">
            <aside class="w-60 shrink-0 bg-ink-900 text-gray-300 flex flex-col">
                <a href="{{ route('admin.dashboard') }}" class="block px-6 py-3 border-b border-white/10" aria-label="JDM Custom admin dashboard">
                    <img src="{{ asset('images/update logo.png') }}" alt="JDM Custom" class="jdm-logo object-contain" style="height: 4rem; width: auto;">
                </a>

                <nav class="flex-1 px-3 py-4 space-y-1 text-sm">
                    @php
                        $adminLinks = [
                            ['route' => 'admin.dashboard', 'label' => 'Dashboard'],
                            ['route' => 'admin.products.index', 'label' => 'Products'],
                            ['route' => 'admin.categories.index', 'label' => 'Categories'],
                            ['route' => 'admin.orders.index', 'label' => 'Orders'],
                            ['route' => 'admin.customers.index', 'label' => 'Customers'],
                            ['route' => 'admin.coupons.index', 'label' => 'Coupons'],
                            ['route' => 'admin.contact-messages.index', 'label' => 'Messages'],
                        ];
                        $unreadMessages = \App\Models\ContactMessage::where('is_read', false)->count();
                    @endphp

                    @foreach ($adminLinks as $link)
                        @php $active = request()->routeIs(str_replace('.index', '', $link['route']).'*'); @endphp
                        <a
                            href="{{ route($link['route']) }}"
                            class="flex items-center justify-between gap-2 rounded-md px-3 py-2.5 font-medium border-l-2 transition {{ $active ? 'bg-white/5 text-white border-red-600' : 'border-transparent hover:bg-white/5 hover:text-white' }}"
                        >
                            <span>{{ $link['label'] }}</span>
                            @if ($link['label'] === 'Messages' && $unreadMessages > 0)
                                <span class="rounded-full bg-red-600 px-2 py-0.5 text-[10px] font-bold text-white">{{ $unreadMessages }}</span>
                            @endif
                        </a>
                    @endforeach
                </nav>

                <div class="px-3 py-4 border-t border-white/10 text-sm space-y-1">
                    <a href="{{ route('home') }}" class="block rounded-md px-3 py-2 hover:bg-white/5 hover:text-white transition">View Store</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="block w-full text-left rounded-md px-3 py-2 hover:bg-white/5 hover:text-white transition">Log Out</button>
                    </form>
                </div>
            </aside>

            <main class="flex-1 p-8">
                @if (session('status'))
                    <div class="mb-6 rounded-md bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
                        {{ session('status') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 rounded-md bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </body>
</html>
