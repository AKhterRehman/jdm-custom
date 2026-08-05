<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title.' - ' : '' }}{{ config('app.name') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|lexend:600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-white text-ink-900">
        @php
            $navCategories = \App\Models\Category::whereNull('parent_id')->where('is_active', true)->orderBy('sort_order')->get();
            $cartCount = auth()->check() ? auth()->user()->cart?->items()->sum('quantity') : null;
        @endphp

        <header class="bg-ink-900 text-gray-200 sticky top-0 z-30 border-b border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex h-20 items-center justify-between">
                    <a href="{{ route('home') }}" class="font-heading text-2xl font-bold tracking-tight text-white">
                        JDM <span class="text-red-600">CUSTOM</span>
                    </a>

                    <nav class="hidden lg:flex items-center gap-8 text-xs font-semibold uppercase tracking-widest">
                        @foreach ($navCategories as $navCategory)
                            <a href="{{ route('category.show', $navCategory) }}" class="relative py-2 text-gray-300 hover:text-white transition after:absolute after:left-0 after:-bottom-0.5 after:h-0.5 after:w-0 after:bg-red-600 after:transition-all hover:after:w-full">
                                {{ $navCategory->name }}
                            </a>
                        @endforeach
                    </nav>

                    <div class="flex items-center gap-5 text-sm">
                        @auth
                            <a href="{{ route('wishlist.index') }}" title="Wishlist" class="text-gray-300 hover:text-white transition">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" class="h-5 w-5">
                                    <path d="M12 21s-7.5-4.6-10-9.3C.4 8 2 4.5 5.6 4c2-.3 3.8.6 5 2.2C11.6 4.6 13.4 3.7 15.4 4c3.6.5 5.2 4 3.6 7.7C16.5 16.4 12 21 12 21z" />
                                </svg>
                            </a>
                            <a href="{{ route('cart.index') }}" title="Cart" class="relative text-gray-300 hover:text-white transition">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l3.4-8H5.4M7 13L5.4 5M7 13l-2.3 4.6A1 1 0 0 0 5.6 19H17M17 19a2 2 0 1 0 0 4 2 2 0 0 0 0-4ZM9 19a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z" />
                                </svg>
                                @if ($cartCount > 0)
                                    <span class="absolute -top-2 -right-2 flex h-4 w-4 items-center justify-center rounded-full bg-red-600 text-[10px] font-bold text-white">{{ $cartCount }}</span>
                                @endif
                            </a>
                            <a href="{{ route('account.index') }}" class="hidden sm:inline text-gray-300 hover:text-white transition font-medium">Account</a>
                            @if (auth()->user()->is_admin)
                                <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline text-gray-300 hover:text-white transition font-medium">Admin</a>
                            @endif
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="hidden sm:inline text-gray-300 hover:text-white transition font-medium">Log Out</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition font-medium">Login</a>
                            <a href="{{ route('register') }}" class="rounded-md bg-red-600 px-4 py-2 text-xs font-bold uppercase tracking-wide text-white hover:bg-red-500 transition">Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <main>
            {{ $slot }}
        </main>

        <footer class="mt-24 bg-ink-900 text-gray-400">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 grid sm:grid-cols-2 lg:grid-cols-4 gap-10">
                <div>
                    <p class="font-heading text-xl font-bold text-white">JDM <span class="text-red-600">CUSTOM</span></p>
                    <p class="mt-3 text-sm leading-relaxed">Premium engine, body, and performance parts engineered for serious JDM builds.</p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-white mb-4">Shop</p>
                    <ul class="space-y-2 text-sm">
                        @foreach ($navCategories->take(6) as $navCategory)
                            <li><a href="{{ route('category.show', $navCategory) }}" class="hover:text-white transition">{{ $navCategory->name }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-white mb-4">Account</p>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ auth()->check() ? route('account.index') : route('login') }}" class="hover:text-white transition">My Account</a></li>
                        <li><a href="{{ auth()->check() ? route('orders.index') : route('login') }}" class="hover:text-white transition">Order History</a></li>
                        <li><a href="{{ auth()->check() ? route('wishlist.index') : route('login') }}" class="hover:text-white transition">Wishlist</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-white transition">Cart</a></li>
                    </ul>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-white mb-4">Stay in the loop</p>
                    <p class="text-sm mb-3">New drops, restocks, and build features — straight to your inbox.</p>
                    <form class="flex gap-2">
                        <input type="email" placeholder="Email address" class="flex-1 rounded-md border-white/10 bg-white/5 text-sm text-white placeholder:text-gray-500 focus:border-red-600 focus:ring-red-600">
                        <button type="submit" class="rounded-md bg-red-600 px-4 text-sm font-semibold text-white hover:bg-red-500 transition">Join</button>
                    </form>
                </div>
            </div>

            <div class="border-t border-white/10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-gray-500">
                    <p>&copy; {{ date('Y') }} JDM Custom. All rights reserved.</p>
                    <p>Built for the JDM faithful.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
