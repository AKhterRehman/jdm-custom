<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title.' - ' : '' }}Admin - {{ config('app.name') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/jdm-custom-logo-gold.png') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|lexend:600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .admin-table-wrap { overflow-x: auto; border: 1px solid #e5e7eb; border-radius: 0.75rem; background: #fff; box-shadow: 0 8px 24px rgba(15,23,42,.04); }
            .admin-table { min-width: 760px; width: 100%; border-collapse: collapse; }
            .admin-table thead { background: #f8fafc; }
            .admin-table th { padding: .8rem 1rem; color: #64748b; font-size: .7rem; font-weight: 700; letter-spacing: .08em; text-align: left; text-transform: uppercase; white-space: nowrap; }
            .admin-table td { padding: .85rem 1rem; border-top: 1px solid #f1f5f9; vertical-align: middle; }
            .admin-table tbody tr { transition: background-color .15s ease; }
            .admin-table tbody tr:hover { background: #fafafa; }
            .admin-action { display: inline-flex; height: 2rem; width: 2rem; align-items: center; justify-content: center; border-radius: .5rem; color: #64748b; transition: color .15s ease, background-color .15s ease, transform .15s ease; }
            .admin-action:hover { background: #fef2f2; color: #dc2626; transform: translateY(-1px); }
            .admin-action--danger:hover { background: #fef2f2; color: #dc2626; }
            main table { min-width: 760px; width: 100%; border-collapse: collapse; }
            main table thead { background: #f8fafc; }
            main table th { padding: .8rem 1rem; color: #64748b; font-size: .7rem; font-weight: 700; letter-spacing: .08em; text-align: left; text-transform: uppercase; white-space: nowrap; }
            main table td { padding: .85rem 1rem; border-top: 1px solid #f1f5f9; vertical-align: middle; }
            main table tbody tr:hover { background: #fafafa; }
            main table td:last-child { white-space: nowrap; }
            main table td:last-child a:not(.admin-action), main table td:last-child button { display: inline-flex; height: 2rem; width: 2rem; align-items: center; justify-content: center; border-radius: .5rem; color: #64748b; font-size: 0; vertical-align: middle; transition: color .15s ease, background-color .15s ease; }
            main table td:last-child a:not(.admin-action)::before, main table td:last-child button::before { content: ''; display: block; height: 1.05rem; width: 1.05rem; background-position: center; background-repeat: no-repeat; background-size: contain; }
            main table td:last-child a:not(.admin-action)::before { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b' stroke-width='1.8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125'/%3E%3C/svg%3E"); }
            main table td:last-child button::before { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b' stroke-width='1.8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0 1 15.916 21.75H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.11 48.11 0 0 0-3.478-.562m-10.978.562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0C8.91 2.63 8 3.613 8 4.794v.916'/%3E%3C/svg%3E"); }
            main table td:last-child a:not(.admin-action):hover, main table td:last-child button:hover, .admin-action:hover { background: #fef2f2; color: #dc2626; }
            .admin-sidebar-link { min-height: 2.75rem; }
            @media (max-width: 1023px) { .admin-sidebar { display: none; } .admin-main { padding: 1rem; } }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50 text-ink-900">
        <div class="flex min-h-screen">
            <aside class="admin-sidebar w-60 shrink-0 bg-ink-900 text-gray-300 flex flex-col">
                <a href="{{ route('admin.dashboard') }}" class="block px-6 py-3 border-b border-white/10" aria-label="JDM Custom Creations admin dashboard">
                    <span class="inline-flex items-center justify-center">
                        <img src="{{ asset('images/jdm-logo-gold.png') }}" alt="JDM Custom Creations" class="object-contain" style="height: 3.5rem; width: auto;">
                    </span>
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
                            class="admin-sidebar-link flex items-center justify-between gap-2 rounded-md px-3 py-2.5 font-medium border-l-2 transition {{ $active ? 'bg-white/5 text-white border-red-600' : 'border-transparent hover:bg-white/5 hover:text-white' }}"
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

            <main class="admin-main min-w-0 flex-1 p-8">
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
