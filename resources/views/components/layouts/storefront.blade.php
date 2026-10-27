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
                            <span class="footer-pay" title="PayPal">
                                <svg viewBox="0 0 24 24" class="h-[1.05rem] w-[1.05rem]" fill="#179bd7" aria-hidden="true"><path d="M7.016 19.198h-4.2a.562.562 0 0 1-.555-.65L5.093.584A.692.692 0 0 1 5.776 0h7.222c3.417 0 5.904 2.488 5.846 5.5-.006.25-.027.5-.066.747A6.794 6.794 0 0 1 12.071 12H8.743a.69.69 0 0 0-.682.583l-.325 2.056-.013.083-.692 4.39-.015.087zM19.79 6.142c-.01.087-.01.175-.023.261a7.76 7.76 0 0 1-7.695 6.598H9.007l-.283 1.795-.013.083-.692 4.39-.134.843-.014.088H6.86l-.497 3.15a.562.562 0 0 0 .555.65h3.612c.34 0 .63-.249.683-.585l.952-6.031a.692.692 0 0 1 .683-.584h2.126a6.793 6.793 0 0 0 6.707-5.752c.306-1.95-.466-3.744-1.89-4.906z"/></svg>
                                <span class="footer-pay__word italic"><span style="color:#f1f1f1">Pay</span><span style="color:#2fa8e6">Pal</span></span>
                            </span>
                            <span class="footer-pay" title="Venmo">
                                <img src="{{ asset('images/venmo-logo.svg') }}" alt="Venmo" class="h-[1.05rem] w-auto">
                            </span>
                            <span class="footer-pay" title="U.S. Bank">
                                <span class="footer-pay__word" style="letter-spacing:-0.03em"><span style="color:#f1f1f1">us</span><span style="color:#ff5a60">bank</span></span>
                            </span>
                            <span class="footer-pay" title="Stripe">
                                <svg viewBox="0 0 24 24" class="h-[1.05rem] w-[1.05rem]" fill="#7f78ff" aria-hidden="true"><path d="M13.976 9.15c-2.172-.806-3.356-1.426-3.356-2.409 0-.831.683-1.305 1.901-1.305 2.227 0 4.515.858 6.09 1.631l.89-5.494C18.252.975 15.697 0 12.165 0 9.667 0 7.589.654 6.104 1.872 4.56 3.147 3.757 4.992 3.757 7.218c0 4.039 2.467 5.76 6.476 7.219 2.585.92 3.445 1.574 3.445 2.583 0 .98-.84 1.545-2.354 1.545-1.875 0-4.965-.921-6.99-2.109l-.9 5.555C5.175 22.99 8.385 24 11.714 24c2.641 0 4.843-.624 6.328-1.813 1.664-1.305 2.525-3.236 2.525-5.732 0-4.128-2.524-5.851-6.594-7.305h.003z"/></svg>
                                <span class="footer-pay__word" style="color:#f1f1f1;letter-spacing:-0.02em">stripe</span>
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2" aria-label="Follow us on social media">
                        <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer" class="footer-social" aria-label="Visit us on Facebook" title="Facebook">
                            <svg viewBox="0 0 24 24" class="h-[1.15rem] w-[1.15rem]" fill="#3b8bff" aria-hidden="true"><path d="M9.101 23.691v-7.98H6.627v-3.667h2.474v-1.58c0-4.085 1.848-5.978 5.858-5.978.401 0 .955.042 1.468.103a8.68 8.68 0 0 1 1.141.195v3.325a8.623 8.623 0 0 0-.653-.036 26.805 26.805 0 0 0-.733-.009c-.707 0-1.259.096-1.675.309a1.686 1.686 0 0 0-.679.622c-.258.42-.374.995-.374 1.752v1.297h3.919l-.386 2.103-.287 1.564h-3.246v8.245C19.396 23.238 24 18.179 24 12.044c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.628 3.874 10.35 9.101 11.647Z"/></svg>
                        </a>
                        <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" class="footer-social" aria-label="Visit us on Instagram" title="Instagram">
                            <svg viewBox="0 0 24 24" class="h-[1.15rem] w-[1.15rem]" aria-hidden="true"><defs><linearGradient id="footer-ig" x1="0" y1="1" x2="1" y2="0"><stop offset="0" stop-color="#fdc468"/><stop offset="0.5" stop-color="#df4996"/><stop offset="1" stop-color="#6a5bd8"/></linearGradient></defs><path fill="url(#footer-ig)" d="M7.0301.084c-1.2768.0602-2.1487.264-2.911.5634-.7888.3075-1.4575.72-2.1228 1.3877-.6652.6677-1.075 1.3368-1.3802 2.127-.2954.7638-.4956 1.6365-.552 2.914-.0564 1.2775-.0689 1.6882-.0626 4.947.0062 3.2586.0206 3.6671.0825 4.9473.061 1.2765.264 2.1482.5635 2.9107.308.7889.72 1.4573 1.388 2.1228.6679.6655 1.3365 1.0743 2.1285 1.38.7632.295 1.6361.4961 2.9134.552 1.2773.056 1.6884.069 4.9462.0627 3.2578-.0062 3.668-.0207 4.9478-.0814 1.28-.0607 2.147-.2652 2.9098-.5633.7889-.3086 1.4578-.72 2.1228-1.3881.665-.6682 1.0745-1.3378 1.3795-2.1284.2957-.7632.4966-1.636.552-2.9124.056-1.2809.0692-1.6898.063-4.948-.0063-3.2583-.021-3.6668-.0817-4.9465-.0607-1.2797-.264-2.1487-.5633-2.9117-.3084-.7889-.72-1.4568-1.3876-2.1228C21.2982 1.33 20.628.9208 19.8378.6165 19.074.321 18.2017.1197 16.9244.0645 15.6471.0093 15.236-.005 11.977.0014 8.718.0076 8.31.0215 7.0301.0839m.1402 21.6932c-1.17-.0509-1.8053-.2453-2.2287-.408-.5606-.216-.96-.4771-1.3819-.895-.422-.4178-.6811-.8186-.9-1.378-.1644-.4234-.3624-1.058-.4171-2.228-.0595-1.2645-.072-1.6442-.079-4.848-.007-3.2037.0053-3.583.0607-4.848.05-1.169.2456-1.805.408-2.2282.216-.5613.4762-.96.895-1.3816.4188-.4217.8184-.6814 1.3783-.9003.423-.1651 1.0575-.3614 2.227-.4171 1.2655-.06 1.6447-.072 4.848-.079 3.2033-.007 3.5835.005 4.8495.0608 1.169.0508 1.8053.2445 2.228.408.5608.216.96.4754 1.3816.895.4217.4194.6816.8176.9005 1.3787.1653.4217.3617 1.056.4169 2.2263.0602 1.2655.0739 1.645.0796 4.848.0058 3.203-.0055 3.5834-.061 4.848-.051 1.17-.245 1.8055-.408 2.2294-.216.5604-.4763.96-.8954 1.3814-.419.4215-.8181.6811-1.3783.9-.4224.1649-1.0577.3617-2.2262.4174-1.2656.0595-1.6448.072-4.8493.079-3.2045.007-3.5825-.006-4.848-.0608M16.953 5.5864A1.44 1.44 0 1 0 18.39 4.144a1.44 1.44 0 0 0-1.437 1.4424M5.8385 12.012c.0067 3.4032 2.7706 6.1557 6.173 6.1493 3.4026-.0065 6.157-2.7701 6.1506-6.1733-.0065-3.4032-2.771-6.1565-6.174-6.1498-3.403.0067-6.156 2.771-6.1496 6.1738M8 12.0077a4 4 0 1 1 4.008 3.9921A3.9996 3.9996 0 0 1 8 12.0077"/></svg>
                        </a>
                        <a href="#top" class="footer-social footer-social--arrow ml-2" aria-label="Back to the top" title="Back to the top">
                            <svg width="12" height="14" viewBox="0 0 12 14" fill="none" stroke="currentColor" stroke-width="1.3" aria-hidden="true"><path d="M6 14V1.5M1.5 6 6 1.5 10.5 6" /></svg>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
