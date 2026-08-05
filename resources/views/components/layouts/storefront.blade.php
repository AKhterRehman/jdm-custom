<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title.' - ' : '' }}{{ config('app.name') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-white text-gray-900">
        <header class="border-b border-gray-200 bg-white sticky top-0 z-30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight text-gray-900">
                        JDM <span class="text-red-600">Custom</span>
                    </a>

                    <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-700">
                        @foreach (\App\Models\Category::whereNull('parent_id')->where('is_active', true)->orderBy('sort_order')->get() as $navCategory)
                            <a href="{{ route('category.show', $navCategory) }}" class="hover:text-red-600 transition">
                                {{ $navCategory->name }}
                            </a>
                        @endforeach
                    </nav>

                    <div class="flex items-center gap-4 text-sm font-medium">
                        @auth
                            <a href="{{ route('wishlist.index') }}" class="hover:text-red-600 transition">Wishlist</a>
                            <a href="{{ route('cart.index') }}" class="hover:text-red-600 transition">
                                Cart
                                @if (($itemCount = auth()->user()->cart?->items()->sum('quantity')) > 0)
                                    <span class="ml-1 inline-flex h-5 w-5 items-center justify-center rounded-full bg-red-600 text-xs text-white">{{ $itemCount }}</span>
                                @endif
                            </a>
                            <a href="{{ route('account.index') }}" class="hover:text-red-600 transition">My Account</a>
                        @else
                            <a href="{{ route('login') }}" class="hover:text-red-600 transition">Login</a>
                            <a href="{{ route('register') }}" class="rounded-md bg-gray-900 px-4 py-2 text-white hover:bg-red-600 transition">Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <main>
            {{ $slot }}
        </main>

        <footer class="mt-20 border-t border-gray-200 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-sm text-gray-600">
                <p class="font-semibold text-gray-900 mb-2">JDM Custom</p>
                <p>Premium JDM parts and accessories, built for performance.</p>
                <p class="mt-6 text-gray-400">&copy; {{ date('Y') }} JDM Custom. All rights reserved.</p>
            </div>
        </footer>
    </body>
</html>
