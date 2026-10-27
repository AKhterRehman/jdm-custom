@props(['title' => null, 'dark' => false, 'overlay' => false])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title.' - ' : '' }}{{ config('app.name') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/jdm-custom-logo-gold.png') }}">

        <script>document.documentElement.classList.add('js');try{var t=localStorage.getItem('jdm-theme');if(t==='light'||t==='dark'){document.documentElement.dataset.theme=t;}}catch(e){}</script>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|lexend:600,700,800|cormorant-garamond:400,500,600,700|bodoni-moda:400,500,600,400i,500i|jost:300,400,500&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased {{ $dark ? 'bg-ink-900 text-gray-300 is-dark' : 'bg-white text-ink-900' }}">
        @php
            $navCategories = \App\Models\Category::whereNull('parent_id')->where('is_active', true)->orderBy('sort_order')->get();
            $automotiveCategory = $navCategories->firstWhere('slug', 'automotive-art');
            $cartCount = auth()->check() ? auth()->user()->cart?->items()->sum('quantity') : null;
        @endphp

        <header x-data="{ mobileOpen: false, scrolled: false }" @scroll.window="scrolled = window.scrollY > 24"
                :class="{{ $overlay ? "scrolled ? 'bg-ink-900/95 backdrop-blur border-white/10' : 'bg-transparent border-transparent'" : "'bg-ink-900/95 backdrop-blur border-white/10'" }}"
                class="text-gray-200 {{ $overlay ? 'fixed inset-x-0 top-0' : 'sticky top-0' }} z-30 border-b transition-colors duration-500">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex h-24 items-center justify-between gap-8">
                    <a href="{{ route('home') }}" class="shrink-0 inline-flex items-center justify-center" aria-label="JDM Custom Creations home">
                        <img src="{{ asset('images/jdm-logo-gold.png') }}" alt="JDM Custom Creations" class="object-contain" style="height: 5rem; width: auto;">
                    </a>

                    <nav class="hidden lg:flex items-center gap-5 xl:gap-9 whitespace-nowrap text-[0.78rem] xl:text-[0.9rem] font-semibold uppercase tracking-[0.14em] xl:tracking-[0.2em]">
                        <a href="{{ route('home') }}" class="transition {{ request()->routeIs('home') ? 'text-gold-400' : 'text-white hover:text-gold-400' }}">Home</a>
                        @if ($automotiveCategory)
                            <a href="{{ route('category.show', $automotiveCategory) }}" class="transition {{ request()->is('category/'.$automotiveCategory->slug) ? 'text-gold-400' : 'text-white hover:text-gold-400' }}">Automotive Art</a>
                        @endif
                        <a href="{{ route('shop.index') }}" class="transition {{ request()->routeIs('shop.*') ? 'text-gold-400' : 'text-white hover:text-gold-400' }}">Shop</a>
                        <div class="relative group">
                            <button type="button" class="flex items-center gap-1 uppercase transition {{ request()->routeIs('category.*') ? 'text-gold-400' : 'text-white hover:text-gold-400' }}">
                                Categories
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="h-3 w-3 mt-0.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                                </svg>
                            </button>
                            <div class="invisible opacity-0 group-hover:visible group-hover:opacity-100 transition absolute left-1/2 -translate-x-1/2 top-full pt-4 w-56 z-40">
                                <div class="bg-charcoal-900 text-gray-200 shadow-2xl border border-white/10 py-2 normal-case tracking-normal font-medium">
                                    @foreach ($navCategories as $navCategory)
                                        <a href="{{ route('category.show', $navCategory) }}" class="block px-4 py-2 text-sm hover:bg-white/5 hover:text-gold-400 transition">
                                            {{ $navCategory->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('pages.about') }}" class="transition {{ request()->routeIs('pages.about') ? 'text-gold-400' : 'text-white hover:text-gold-400' }}">Our Story</a>
                        <a href="{{ route('pages.contact') }}" class="transition {{ request()->routeIs('pages.contact') ? 'text-gold-400' : 'text-white hover:text-gold-400' }}">Contact Us</a>
                    </nav>

                    <div class="flex items-center gap-5 text-sm">
                        <button type="button" data-theme-toggle class="theme-toggle text-gray-300 transition hover:text-white" aria-label="Switch to the light theme" title="Switch theme">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="icon-moon h-5 w-5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" /></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="icon-sun h-5 w-5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" /></svg>
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
                                    <span class="absolute -top-2 -right-2 flex h-4 w-4 items-center justify-center rounded-full bg-gold-500 text-[10px] font-bold text-ink-900">{{ $cartCount }}</span>
                                @endif
                            </a>
                            <a href="{{ route('account.index') }}" class="hidden lg:inline text-[0.95rem] text-gray-200 hover:text-white transition font-medium">Account</a>
                            @if (auth()->user()->is_admin)
                                <a href="{{ route('admin.dashboard') }}" class="hidden lg:inline text-[0.95rem] text-gray-200 hover:text-white transition font-medium">Admin</a>
                            @endif
                            <form action="{{ route('logout') }}" method="POST" class="hidden lg:block">
                                @csrf
                                <button type="submit" class="text-[0.95rem] text-gray-200 hover:text-white transition font-medium">Log Out</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="hidden lg:inline text-[0.95rem] text-gray-200 hover:text-white transition font-medium">Login</a>
                            <a href="{{ route('register') }}" class="hidden lg:inline bg-gold-500 px-6 py-3 text-[0.8rem] font-bold uppercase tracking-[0.2em] text-ink-900 hover:bg-gold-400 transition">Register</a>
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

            {{-- The wrapper clips the off-screen drawer so it can never widen the page on phones. --}}
            <div class="lg:hidden fixed inset-0 z-50 overflow-hidden pointer-events-none">
            <div
                :class="mobileOpen ? 'translate-x-0' : 'translate-x-full'"
                class="pointer-events-auto absolute inset-y-0 right-0 w-80 max-w-[85vw] bg-ink-900 shadow-2xl flex flex-col transition-transform duration-300 ease-out"
            >
                <div class="flex items-center justify-between px-6 h-20 border-b border-white/10 shrink-0">
                    <span class="inline-flex items-center justify-center">
                        <img src="{{ asset('images/jdm-logo-gold.png') }}" alt="JDM Custom Creations" class="object-contain" style="height: 3.75rem; width: auto;">
                    </span>
                    <button type="button" @click="mobileOpen = false" class="text-gray-400 hover:text-white transition" aria-label="Close menu">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <nav class="flex-1 overflow-y-auto px-6 py-6 text-sm font-bold uppercase tracking-wide">
                    <a href="{{ route('home') }}" class="flex items-center py-3.5 border-l-2 pl-4 -ml-6 transition {{ request()->routeIs('home') ? 'border-gold-500 text-gold-400' : 'border-transparent text-white hover:border-white/30' }}">Home</a>
                    @if ($automotiveCategory)
                        <a href="{{ route('category.show', $automotiveCategory) }}" class="flex items-center py-3.5 border-l-2 pl-4 -ml-6 transition border-transparent text-white hover:border-white/30">Automotive Art</a>
                    @endif
                    <a href="{{ route('shop.index') }}" class="flex items-center py-3.5 border-l-2 pl-4 -ml-6 transition {{ request()->routeIs('shop.*') ? 'border-gold-500 text-gold-400' : 'border-transparent text-white hover:border-white/30' }}">Shop</a>

                    <div x-data="{ open: false }">
                        <button type="button" @click="open = !open" class="flex items-center justify-between w-full py-3.5 border-l-2 pl-4 -ml-6 transition {{ request()->routeIs('category.*') ? 'border-gold-500 text-gold-400' : 'border-transparent text-white hover:border-white/30' }}">
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

                    <a href="{{ route('pages.about') }}" class="flex items-center py-3.5 border-l-2 pl-4 -ml-6 transition {{ request()->routeIs('pages.about') ? 'border-gold-500 text-gold-400' : 'border-transparent text-white hover:border-white/30' }}">Our Story</a>
                    <a href="{{ route('pages.contact') }}" class="flex items-center py-3.5 border-l-2 pl-4 -ml-6 transition {{ request()->routeIs('pages.contact') ? 'border-gold-500 text-gold-400' : 'border-transparent text-white hover:border-white/30' }}">Contact Us</a>

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
                            <a href="{{ route('register') }}" class="bg-gold-500 px-4 py-3 text-center text-xs font-bold uppercase tracking-[0.2em] text-ink-900 hover:bg-gold-400 transition">Register</a>
                        </div>
                    @endauth
                </div>
            </div>
            </div>
        </header>

        <main class="themed">
            {{ $slot }}
        </main>

        <footer class="site-footer">
            <div class="mx-auto max-w-[88rem] px-5 sm:px-8 lg:px-12">
                {{-- Brand and newsletter --}}
                <div class="grid gap-14 border-b border-white/10 py-16 sm:py-20 lg:grid-cols-12 lg:gap-10">
                    <div class="lg:col-span-5">
                        <a href="{{ route('home') }}" class="inline-block" aria-label="JDM Custom Creations home">
                            <img src="{{ asset('images/jdm-logo-gold.png') }}" alt="JDM Custom Creations" class="object-contain" style="height: 5rem; width: auto;">
                        </a>
                        <p class="mt-7 max-w-sm font-label text-[0.98rem] font-light leading-relaxed text-[#9a9ea6]">Hand finished crests in hardwood and epoxy, made to order one at a time for the collector's garage.</p>
                    </div>

                    <div class="lg:col-span-6 lg:col-start-7">
                        <h2 class="font-lux text-[clamp(1.9rem,3vw,2.6rem)] font-normal leading-[1.05] tracking-[-0.01em] text-white">Stay in the loop</h2>
                        <p class="mt-3 font-lux text-[clamp(1.15rem,1.6vw,1.45rem)] italic leading-snug text-gold-300">New pieces and private releases, straight to your inbox.</p>

                        @if (session('newsletter_status'))
                            <p class="mt-5 font-label text-sm text-green-400">{{ session('newsletter_status') }}</p>
                        @endif
                        @error('email', 'newsletter')
                            <p class="mt-5 font-label text-sm text-red-400">{{ $message }}</p>
                        @enderror

                        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="footer-subscribe mt-8">
                            @csrf
                            <label for="footer-email" class="sr-only">Email address</label>
                            <input id="footer-email" type="email" name="email" value="{{ old('email') }}" placeholder="Your email address" required autocomplete="email" class="footer-input">
                            <button type="submit" class="footer-join">
                                <span>Join</span>
                                <svg width="18" height="10" viewBox="0 0 18 10" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true"><path d="M0 5h16.5M12.5 1l4 4-4 4" /></svg>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Links --}}
                <div class="grid grid-cols-2 gap-x-8 gap-y-12 py-14 sm:py-16 lg:grid-cols-12 lg:gap-10">
                    <nav class="lg:col-span-3" aria-label="Shop">
                        <h3 class="footer-heading">Shop</h3>
                        <ul class="mt-6 space-y-3.5">
                            <li><a href="{{ route('shop.index') }}" class="footer-link">All Products</a></li>
                            @foreach ($navCategories->take(5) as $navCategory)
                                <li><a href="{{ route('category.show', $navCategory) }}" class="footer-link">{{ $navCategory->name }}</a></li>
                            @endforeach
                        </ul>
                    </nav>

                    <nav class="lg:col-span-3" aria-label="Company">
                        <h3 class="footer-heading">Company</h3>
                        <ul class="mt-6 space-y-3.5">
                            <li><a href="{{ route('pages.about') }}" class="footer-link">Our Story</a></li>
                            <li><a href="{{ route('pages.contact') }}" class="footer-link">Contact Us</a></li>
                            <li><a href="{{ route('pages.privacy') }}" class="footer-link">Privacy Policy</a></li>
                            <li><a href="{{ route('pages.terms') }}" class="footer-link">Terms and Conditions</a></li>
                        </ul>
                    </nav>

                    <nav class="lg:col-span-3" aria-label="Account">
                        <h3 class="footer-heading">Account</h3>
                        <ul class="mt-6 space-y-3.5">
                            <li><a href="{{ auth()->check() ? route('account.index') : route('login') }}" class="footer-link">My Account</a></li>
                            <li><a href="{{ auth()->check() ? route('orders.index') : route('login') }}" class="footer-link">Order History</a></li>
                            <li><a href="{{ auth()->check() ? route('wishlist.index') : route('login') }}" class="footer-link">Wishlist</a></li>
                            <li><a href="{{ route('cart.index') }}" class="footer-link">Cart</a></li>
                        </ul>
                    </nav>

                    <div class="col-span-2 lg:col-span-3">
                        <h3 class="footer-heading">Commissions</h3>
                        <p class="mt-6 max-w-[16rem] font-label text-[0.95rem] font-light leading-relaxed text-[#9a9ea6]">Tell us the car. We design, carve and finish the piece.</p>
                        <a href="{{ route('pages.contact') }}?inquiry_type=custom-order" class="link-line mt-7">Commission a piece</a>
                    </div>
                </div>

                {{-- Base --}}
                <div class="flex flex-col items-center gap-7 border-t border-white/10 py-8 xl:flex-row xl:justify-between">
                    <p class="font-label text-[0.8rem] font-light text-[#7d818a]">&copy; {{ date('Y') }} JDM Custom Creations. All rights reserved.</p>

                    <div class="flex flex-col items-center gap-4 sm:flex-row sm:gap-6">
                        <p class="footer-secure"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="3" y="11" width="18" height="10" rx="2" /><path d="M7 11V7a5 5 0 0 1 10 0v4" /></svg> Secure payments</p>
                        <div class="flex flex-wrap items-center justify-center gap-2 sm:flex-nowrap" aria-label="Accepted payment methods">
                            <span class="footer-pay">PayPal</span>
                            <span class="footer-pay">Venmo</span>
                            <span class="footer-pay">US Bank</span>
                            <span class="footer-pay">Stripe</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2" aria-label="Follow us on social media">
                        <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer" class="footer-social" aria-label="Visit us on Facebook" title="Facebook">
                            <svg viewBox="0 0 24 24" class="h-[1.05rem] w-[1.05rem]" fill="currentColor" aria-hidden="true"><path d="M13.5 21v-8h2.75l.41-3.12H13.5V7.89c0-.9.25-1.52 1.55-1.52h1.66V3.58A22.3 22.3 0 0 0 14.29 3c-2.4 0-4.05 1.46-4.05 4.15v2.73H7.5V13h2.74v8h3.26Z" /></svg>
                        </a>
                        <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" class="footer-social" aria-label="Visit us on Instagram" title="Instagram">
                            <svg viewBox="0 0 24 24" class="h-[1.05rem] w-[1.05rem]" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5" /><circle cx="12" cy="12" r="4" /><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" /></svg>
                        </a>
                        <a href="#top" class="footer-social ml-2" aria-label="Back to the top" title="Back to the top">
                            <svg width="12" height="14" viewBox="0 0 12 14" fill="none" stroke="currentColor" stroke-width="1.3" aria-hidden="true"><path d="M6 14V1.5M1.5 6 6 1.5 10.5 6" /></svg>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
