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

        <header x-data="{ mobileOpen: false }" class="bg-ink-900 text-gray-200 sticky top-0 z-30 border-b border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex h-20 items-center justify-between">
                    <a href="{{ route('home') }}" class="font-heading text-2xl font-bold tracking-tight text-white">
                        JDM <span class="text-red-600">CUSTOM</span>
                    </a>

                    <div class="flex items-center gap-5 text-sm">
                        <button type="button" @click="mobileOpen = !mobileOpen" class="lg:hidden text-gray-300 hover:text-white transition" aria-label="Toggle menu">
                            <svg x-cloak x-show="!mobileOpen" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                            </svg>
                            <svg x-cloak x-show="mobileOpen" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>

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

            <nav class="hidden lg:block bg-black/30 border-t border-white/10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <ul class="flex items-center justify-center gap-10 py-3 text-sm font-bold uppercase tracking-wide">
                        <li>
                            <a href="{{ route('home') }}" class="transition {{ request()->routeIs('home') ? 'text-red-600' : 'text-white hover:text-red-600' }}">Home</a>
                        </li>
                        <li>
                            <a href="{{ route('shop.index') }}" class="transition {{ request()->routeIs('shop.*') ? 'text-red-600' : 'text-white hover:text-red-600' }}">Shop</a>
                        </li>
                        <li class="relative group">
                            <button type="button" class="flex items-center gap-1 transition {{ request()->routeIs('category.*') ? 'text-red-600' : 'text-white hover:text-red-600' }}">
                                Categories
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="h-3 w-3 mt-0.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                                </svg>
                            </button>
                            <div class="invisible opacity-0 group-hover:visible group-hover:opacity-100 transition absolute left-1/2 -translate-x-1/2 top-full pt-3 w-56 z-40">
                                <div class="rounded-lg bg-white text-ink-900 shadow-xl border border-gray-100 py-2 normal-case tracking-normal font-medium">
                                    @foreach ($navCategories as $navCategory)
                                        <a href="{{ route('category.show', $navCategory) }}" class="block px-4 py-2 text-sm hover:bg-gray-50 hover:text-red-600 transition">
                                            {{ $navCategory->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                        <li>
                            <a href="{{ route('pages.about') }}" class="transition {{ request()->routeIs('pages.about') ? 'text-red-600' : 'text-white hover:text-red-600' }}">About</a>
                        </li>
                        <li>
                            <a href="{{ route('pages.contact') }}" class="transition {{ request()->routeIs('pages.contact') ? 'text-red-600' : 'text-white hover:text-red-600' }}">Contact Us</a>
                        </li>
                        <li>
                            <a href="{{ route('pages.privacy') }}" class="transition {{ request()->routeIs('pages.privacy') ? 'text-red-600' : 'text-white hover:text-red-600' }}">Privacy Policy</a>
                        </li>
                        <li>
                            <a href="{{ route('pages.terms') }}" class="transition {{ request()->routeIs('pages.terms') ? 'text-red-600' : 'text-white hover:text-red-600' }}">Terms and Condition</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div x-cloak x-show="mobileOpen" x-transition class="lg:hidden bg-ink-900 border-t border-white/10">
                <nav class="max-w-7xl mx-auto px-4 sm:px-6 py-4 text-sm font-bold uppercase tracking-wide divide-y divide-white/10">
                    <a href="{{ route('home') }}" class="block py-3 {{ request()->routeIs('home') ? 'text-red-600' : 'text-white' }}">Home</a>
                    <a href="{{ route('shop.index') }}" class="block py-3 {{ request()->routeIs('shop.*') ? 'text-red-600' : 'text-white' }}">Shop</a>

                    <div x-data="{ open: false }" class="py-3">
                        <button type="button" @click="open = !open" class="flex items-center justify-between w-full {{ request()->routeIs('category.*') ? 'text-red-600' : 'text-white' }}">
                            Categories
                            <svg :class="open ? 'rotate-180' : ''" class="h-3 w-3 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                            </svg>
                        </button>
                        <div x-cloak x-show="open" x-transition class="mt-2 pl-3 space-y-2 normal-case font-medium">
                            @foreach ($navCategories as $navCategory)
                                <a href="{{ route('category.show', $navCategory) }}" class="block py-1 text-gray-300 hover:text-white">{{ $navCategory->name }}</a>
                            @endforeach
                        </div>
                    </div>

                    <a href="{{ route('pages.about') }}" class="block py-3 {{ request()->routeIs('pages.about') ? 'text-red-600' : 'text-white' }}">About</a>
                    <a href="{{ route('pages.contact') }}" class="block py-3 {{ request()->routeIs('pages.contact') ? 'text-red-600' : 'text-white' }}">Contact Us</a>
                    <a href="{{ route('pages.privacy') }}" class="block py-3 {{ request()->routeIs('pages.privacy') ? 'text-red-600' : 'text-white' }}">Privacy Policy</a>
                    <a href="{{ route('pages.terms') }}" class="block py-3 {{ request()->routeIs('pages.terms') ? 'text-red-600' : 'text-white' }}">Terms and Condition</a>

                    <div class="py-3 normal-case font-medium space-y-2">
                        @auth
                            <a href="{{ route('account.index') }}" class="block text-gray-300 hover:text-white">My Account</a>
                            <a href="{{ route('wishlist.index') }}" class="block text-gray-300 hover:text-white">Wishlist</a>
                            <a href="{{ route('cart.index') }}" class="block text-gray-300 hover:text-white">Cart</a>
                            @if (auth()->user()->is_admin)
                                <a href="{{ route('admin.dashboard') }}" class="block text-gray-300 hover:text-white">Admin</a>
                            @endif
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-gray-300 hover:text-white">Log Out</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="block text-gray-300 hover:text-white">Login</a>
                            <a href="{{ route('register') }}" class="block text-gray-300 hover:text-white">Register</a>
                        @endauth
                    </div>
                </nav>
            </div>
        </header>

        <main>
            {{ $slot }}
        </main>

        <footer class="mt-24 bg-ink-900 text-gray-400">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 grid sm:grid-cols-2 lg:grid-cols-5 gap-10">
                <div>
                    <p class="font-heading text-xl font-bold text-white">JDM <span class="text-red-600">CUSTOM</span></p>
                    <p class="mt-3 text-sm leading-relaxed">Premium engine, body, and performance parts engineered for serious JDM builds.</p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-white mb-4">Shop</p>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('shop.index') }}" class="hover:text-white transition">All Products</a></li>
                        @foreach ($navCategories->take(5) as $navCategory)
                            <li><a href="{{ route('category.show', $navCategory) }}" class="hover:text-white transition">{{ $navCategory->name }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-white mb-4">Company</p>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('pages.about') }}" class="hover:text-white transition">About Us</a></li>
                        <li><a href="{{ route('pages.contact') }}" class="hover:text-white transition">Contact Us</a></li>
                        <li><a href="{{ route('pages.privacy') }}" class="hover:text-white transition">Privacy Policy</a></li>
                        <li><a href="{{ route('pages.terms') }}" class="hover:text-white transition">Terms and Condition</a></li>
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
