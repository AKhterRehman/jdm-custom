<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title.' - ' : '' }}{{ config('app.name') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/jdm-custom-logo.png') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|lexend:600,700,800&display=swap" rel="stylesheet" />

        <style>
            .payment-methods {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
            }

            .payment-strip { border-bottom: 1px solid #e5e7eb; background: linear-gradient(100deg, #fbfcfe 0%, #ffffff 50%, #fbfcfe 100%); padding: 1.15rem 1rem; }
            .payment-strip__inner { display: grid; max-width: 80rem; margin: 0 auto; grid-template-columns: minmax(11rem, 1fr) auto minmax(11rem, 1fr); align-items: center; gap: 1.5rem; }
            .payment-strip__label { display: flex; align-items: center; gap: 0.55rem; color: #475569; font-size: 0.68rem; font-weight: 800; letter-spacing: 0.12em; text-transform: uppercase; }
            .payment-strip__label svg { color: #dc2626; }

            .footer-payment-actions {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: center;
                gap: 1.25rem;
            }

            .footer-social-links {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                border-left: 1px solid #dbe1e8;
                padding-left: 1.25rem;
                justify-self: end;
            }

            .footer-social-label { color: #64748b; font-size: 0.64rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; }

            @media (max-width: 640px) {
                .footer-social-links { border-left: 0; padding-left: 0; }
            }

            @media (max-width: 900px) {
                .payment-strip__inner { grid-template-columns: 1fr; justify-items: center; gap: 0.85rem; }
                .payment-strip__label { justify-content: center; }
                .footer-social-links { justify-self: center; border-left: 0; padding-left: 0; }
            }

            .payment-badge {
                display: inline-flex;
                min-width: 2.75rem;
                height: 1.75rem;
                align-items: center;
                justify-content: center;
                border: 1px solid #dbe1e8;
                border-radius: 0.25rem;
                background: #fff;
                color: #172033;
                font-size: 0.62rem;
                font-weight: 800;
                letter-spacing: -0.03em;
                line-height: 1;
                padding: 0 0.35rem;
                transition: transform 150ms ease, box-shadow 150ms ease;
            }

            .payment-badge:hover { box-shadow: 0 4px 10px rgba(15, 23, 42, 0.12); transform: translateY(-1px); }

            .payment-badge--amex { background: #1674c7; border-color: #1674c7; color: #fff; }
            .payment-badge--apple { background: #171717; border-color: #171717; color: #fff; }
            .payment-badge--discover { color: #222; font-size: 0.54rem; }
            .payment-badge--google { font-size: 0.58rem; }
            .payment-badge--mastercard { background: #101010; border-color: #101010; color: #fff; }
            .payment-badge--venmo { background: #008cff; border-color: #008cff; color: #fff; }
            .payment-badge--usbank { background: #d71920; border-color: #d71920; color: #fff; }
            .payment-badge--stripe { background: #635bff; border-color: #635bff; color: #fff; }
            .payment-badge--shop { background: #5a31c9; border-color: #5a31c9; color: #fff; }
            .payment-badge--visa { background: #1434cb; border-color: #1434cb; color: #fff; font-style: italic; }
            .social-badge { display: inline-flex; width: 1.75rem; height: 1.75rem; align-items: center; justify-content: center; border-radius: 0.375rem; color: #fff; transition: transform 150ms ease, opacity 150ms ease; }
            .social-badge:hover { transform: translateY(-1px); opacity: 0.9; }
            .social-badge--facebook { background: #1877f2; }
            .social-badge--instagram { background: linear-gradient(135deg, #833ab4, #fd1d1d, #fcb045); }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-white text-ink-900">
        @php
            $navCategories = \App\Models\Category::whereNull('parent_id')->where('is_active', true)->orderBy('sort_order')->get();
            $cartCount = auth()->check() ? auth()->user()->cart?->items()->sum('quantity') : null;
        @endphp

        <header x-data="{ mobileOpen: false }" class="bg-ink-900 text-gray-200 sticky top-0 z-30 border-b border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex h-24 items-center justify-between gap-8">
                    <a href="{{ route('home') }}" class="shrink-0 inline-flex items-center justify-center rounded-full bg-white overflow-hidden shadow-md" style="height: 4rem; width: 4rem;" aria-label="JDM Custom Creations home">
                        <img src="{{ asset('images/jdm-custom-logo.png') }}" alt="JDM Custom Creations" class="object-contain" style="height: 3.6rem; width: 3.6rem;">
                    </a>

                    <nav class="hidden lg:flex items-center gap-8 text-sm font-bold uppercase tracking-wide">
                        <a href="{{ route('home') }}" class="transition {{ request()->routeIs('home') ? 'text-red-600' : 'text-white hover:text-red-600' }}">Home</a>
                        <a href="{{ route('shop.index') }}" class="transition {{ request()->routeIs('shop.*') ? 'text-red-600' : 'text-white hover:text-red-600' }}">Shop</a>
                        <div class="relative group">
                            <button type="button" class="flex items-center gap-1 transition {{ request()->routeIs('category.*') ? 'text-red-600' : 'text-white hover:text-red-600' }}">
                                Categories
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="h-3 w-3 mt-0.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                                </svg>
                            </button>
                            <div class="invisible opacity-0 group-hover:visible group-hover:opacity-100 transition absolute left-1/2 -translate-x-1/2 top-full pt-4 w-56 z-40">
                                <div class="rounded-lg bg-white text-ink-900 shadow-xl border border-gray-100 py-2 normal-case tracking-normal font-medium">
                                    @foreach ($navCategories as $navCategory)
                                        <a href="{{ route('category.show', $navCategory) }}" class="block px-4 py-2 text-sm hover:bg-gray-50 hover:text-red-600 transition">
                                            {{ $navCategory->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('pages.about') }}" class="transition {{ request()->routeIs('pages.about') ? 'text-red-600' : 'text-white hover:text-red-600' }}">About</a>
                        <a href="{{ route('pages.contact') }}" class="transition {{ request()->routeIs('pages.contact') ? 'text-red-600' : 'text-white hover:text-red-600' }}">Contact Us</a>
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
                            <a href="{{ route('account.index') }}" class="hidden lg:inline text-gray-300 hover:text-white transition font-medium">Account</a>
                            @if (auth()->user()->is_admin)
                                <a href="{{ route('admin.dashboard') }}" class="hidden lg:inline text-gray-300 hover:text-white transition font-medium">Admin</a>
                            @endif
                            <form action="{{ route('logout') }}" method="POST" class="hidden lg:block">
                                @csrf
                                <button type="submit" class="text-gray-300 hover:text-white transition font-medium">Log Out</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="hidden lg:inline text-gray-300 hover:text-white transition font-medium">Login</a>
                            <a href="{{ route('register') }}" class="hidden lg:inline rounded-md bg-red-600 px-4 py-2 text-xs font-bold uppercase tracking-wide text-white hover:bg-red-500 transition">Register</a>
                        @endauth

                        <button type="button" @click="mobileOpen = true" class="lg:hidden text-gray-300 hover:text-white transition" aria-label="Open menu">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div
                @click="mobileOpen = false"
                :class="mobileOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'"
                class="lg:hidden fixed inset-0 z-40 bg-black/60 backdrop-blur-sm transition-opacity duration-300"
            ></div>

            <div
                :class="mobileOpen ? 'translate-x-0' : 'translate-x-full'"
                class="lg:hidden fixed inset-y-0 right-0 z-50 w-80 max-w-[85vw] bg-ink-900 shadow-2xl flex flex-col transition-transform duration-300 ease-out"
            >
                <div class="flex items-center justify-between px-6 h-20 border-b border-white/10 shrink-0">
                    <span class="inline-flex items-center justify-center rounded-full bg-white overflow-hidden shadow-md" style="height: 3rem; width: 3rem;">
                        <img src="{{ asset('images/jdm-custom-logo.png') }}" alt="JDM Custom Creations" class="object-contain" style="height: 2.7rem; width: 2.7rem;">
                    </span>
                    <button type="button" @click="mobileOpen = false" class="text-gray-400 hover:text-white transition" aria-label="Close menu">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <nav class="flex-1 overflow-y-auto px-6 py-6 text-sm font-bold uppercase tracking-wide">
                    <a href="{{ route('home') }}" class="flex items-center py-3.5 border-l-2 pl-4 -ml-6 transition {{ request()->routeIs('home') ? 'border-red-600 text-red-600' : 'border-transparent text-white hover:border-white/30' }}">Home</a>
                    <a href="{{ route('shop.index') }}" class="flex items-center py-3.5 border-l-2 pl-4 -ml-6 transition {{ request()->routeIs('shop.*') ? 'border-red-600 text-red-600' : 'border-transparent text-white hover:border-white/30' }}">Shop</a>

                    <div x-data="{ open: false }">
                        <button type="button" @click="open = !open" class="flex items-center justify-between w-full py-3.5 border-l-2 pl-4 -ml-6 transition {{ request()->routeIs('category.*') ? 'border-red-600 text-red-600' : 'border-transparent text-white hover:border-white/30' }}">
                            Categories
                            <svg :class="open ? 'rotate-180' : ''" class="h-3 w-3 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                            </svg>
                        </button>
                        <div x-cloak x-show="open" x-transition class="pl-8 pb-2 space-y-3 normal-case font-medium">
                            @foreach ($navCategories as $navCategory)
                                <a href="{{ route('category.show', $navCategory) }}" class="block text-gray-400 hover:text-white transition">{{ $navCategory->name }}</a>
                            @endforeach
                        </div>
                    </div>

                    <a href="{{ route('pages.about') }}" class="flex items-center py-3.5 border-l-2 pl-4 -ml-6 transition {{ request()->routeIs('pages.about') ? 'border-red-600 text-red-600' : 'border-transparent text-white hover:border-white/30' }}">About</a>
                    <a href="{{ route('pages.contact') }}" class="flex items-center py-3.5 border-l-2 pl-4 -ml-6 transition {{ request()->routeIs('pages.contact') ? 'border-red-600 text-red-600' : 'border-transparent text-white hover:border-white/30' }}">Contact Us</a>

                    @auth
                        <div class="mt-6 pt-6 border-t border-white/10 space-y-3 normal-case font-medium">
                            <a href="{{ route('account.index') }}" class="block text-gray-300 hover:text-white transition">My Account</a>
                            <a href="{{ route('wishlist.index') }}" class="block text-gray-300 hover:text-white transition">Wishlist</a>
                            <a href="{{ route('cart.index') }}" class="block text-gray-300 hover:text-white transition">Cart</a>
                            @if (auth()->user()->is_admin)
                                <a href="{{ route('admin.dashboard') }}" class="block text-gray-300 hover:text-white transition">Admin</a>
                            @endif
                        </div>
                    @endauth
                </nav>

                <div class="p-6 border-t border-white/10 shrink-0">
                    @auth
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full rounded-md border border-white/20 px-4 py-3 text-xs font-bold uppercase tracking-wide text-white hover:border-white/50 transition">Log Out</button>
                        </form>
                    @else
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('login') }}" class="rounded-md border border-white/20 px-4 py-3 text-center text-xs font-bold uppercase tracking-wide text-white hover:border-white/50 transition">Login</a>
                            <a href="{{ route('register') }}" class="rounded-md bg-red-600 px-4 py-3 text-center text-xs font-bold uppercase tracking-wide text-white hover:bg-red-500 transition">Register</a>
                        </div>
                    @endauth
                </div>
            </div>
        </header>

        <main>
            {{ $slot }}
        </main>

        <footer class="bg-ink-900 text-gray-400">
            <div class="payment-strip">
                <div class="payment-strip__inner">
                    <p class="payment-strip__label"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="11" width="18" height="10" rx="2" /><path d="M7 11V7a5 5 0 0 1 10 0v4" /></svg> Secure payments</p>
                    <div class="payment-methods" aria-label="Accepted payment methods">
                        <span class="payment-badge" title="PayPal" style="color:#003087">Pay<span style="color:#009cde">Pal</span></span>
                        <span class="payment-badge payment-badge--venmo" title="Venmo">V venmo</span>
                        <span class="payment-badge payment-badge--usbank" title="U.S. Bank">usbank</span>
                        <span class="payment-badge payment-badge--stripe" title="Stripe">stripe</span>
                    </div>
                    <div class="footer-social-links" aria-label="Follow us on social media">
                        <span class="footer-social-label">Follow us</span>
                        <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer" class="social-badge social-badge--facebook" aria-label="Visit us on Facebook" title="Facebook">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor" aria-hidden="true"><path d="M13.5 21v-8h2.75l.41-3.12H13.5V7.89c0-.9.25-1.52 1.55-1.52h1.66V3.58A22.3 22.3 0 0 0 14.29 3c-2.4 0-4.05 1.46-4.05 4.15v2.73H7.5V13h2.74v8h3.26Z" /></svg>
                        </a>
                        <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" class="social-badge social-badge--instagram" aria-label="Visit us on Instagram" title="Instagram">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5" /><circle cx="12" cy="12" r="4" fill="none" /><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" /></svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 grid sm:grid-cols-2 lg:grid-cols-5 gap-10">
                <div>
                    <span class="inline-flex items-center justify-center rounded-full bg-white overflow-hidden shadow-md" style="height: 3.75rem; width: 3.75rem;">
                        <img src="{{ asset('images/jdm-custom-logo.png') }}" alt="JDM Custom Creations" class="object-contain" style="height: 3.35rem; width: 3.35rem;">
                    </span>
                    <p class="mt-3 text-sm leading-relaxed">Handcrafted custom wood creations,  engraving, CNC art, shadow boxes, and more, made your way.</p>
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
                    <p class="text-sm mb-3">New drops, restocks, and build features,   straight to your inbox.</p>
                    @if (session('newsletter_status'))
                        <p class="mb-3 text-sm text-green-400">{{ session('newsletter_status') }}</p>
                    @endif
                    @error('email', 'newsletter')
                        <p class="mb-3 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email address" required autocomplete="email" class="min-w-0 flex-1 rounded-md border-white/10 bg-white/5 text-sm text-white placeholder:text-gray-500 focus:border-red-600 focus:ring-red-600">
                        <button type="submit" class="rounded-md bg-red-600 px-4 text-sm font-semibold text-white hover:bg-red-500 transition">Join</button>
                    </form>
                </div>
            </div>

            <div class="border-t border-white/10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-gray-500">
                    <p>&copy; {{ date('Y') }} JDM Custom Creations. All rights reserved.</p>
                    <p>Handcrafted, made your way.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
