<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/jdm-custom-logo-gold.png') }}">

        <script>try{var t=localStorage.getItem('jdm-theme');if(t==='light'||t==='dark'){document.documentElement.dataset.theme=t;}}catch(e){}</script>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|lexend:600,700,800|cormorant-garamond:400,500,600,700|bodoni-moda:400,500,600,400i,500i|jost:300,400,500&display=swap" rel="stylesheet" />

        <style>
            .auth-form-spacing {
                display: flex;
                flex-direction: column;
                gap: 1.25rem;
            }

            .auth-form-spacing > * {
                margin-top: 0 !important;
            }

            .auth-panel-aligned {
                padding-bottom: 3rem;
            }

            .auth-premium-input {
                min-height: 3.25rem;
                background-color: #0b0b0d;
                color: #ece7da;
                border-color: rgba(255, 255, 255, 0.16);
                border-radius: 0;
                box-shadow: none;
                transition: border-color 150ms ease, box-shadow 150ms ease;
            }

            .auth-premium-input:focus {
                border-color: #b89b5e;
                box-shadow: 0 0 0 1px #b89b5e;
            }

            .auth-password-field {
                position: relative;
                margin-top: 0.5rem;
            }

            .auth-password-input {
                padding-right: 3.75rem !important;
            }

            .auth-eye-toggle {
                position: absolute;
                top: 50%;
                right: 0.5rem;
                display: flex;
                height: 2.25rem;
                width: 2.25rem;
                transform: translateY(-50%);
                align-items: center;
                justify-content: center;
                border-radius: 0;
                color: #8f949c;
                transition: color 150ms ease, background-color 150ms ease;
            }

            .auth-eye-toggle:hover {
                background: rgba(255, 255, 255, 0.06);
                color: #d1b370;
            }

            .auth-eye-toggle:focus-visible {
                outline: 1px solid #b89b5e;
                outline-offset: 2px;
            }

            /* Hero column background */
            .auth-hero-panel {
                background-image:
                    linear-gradient(180deg, rgba(11, 11, 13, 0.35) 0%, rgba(11, 11, 13, 0.2) 45%, rgba(11, 11, 13, 0.88) 100%),
                    url('{{ asset('images/luxury-garage-hero.jpg') }}');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }

            .auth-hero-card {
                backdrop-filter: blur(6px);
                background: rgba(15, 15, 15, 0.35);
                border: 1px solid rgba(255, 255, 255, 0.08);
            }

            .auth-form-card {
                border: 1px solid rgba(255, 255, 255, 0.1);
                box-shadow: 0 50px 90px -50px rgba(0, 0, 0, 0.9);
            }

            @media (max-width: 640px) {
                .auth-account-link {
                    display: inline-block;
                    margin-top: 0.25rem;
                }
            }

            @media (min-width: 1024px) {
                .auth-panel-aligned {
                    padding-top: 3.5rem;
                }
            }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="is-dark bg-ink-900 font-label font-light text-[#ece7da] antialiased">
        <div class="grid min-h-screen lg:grid-cols-2">
            {{-- Hero / brand column --}}
            <div class="hidden lg:flex flex-col justify-between text-white p-12 relative overflow-hidden auth-hero-panel">
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,_rgba(192,160,98,0.16),_transparent_60%)]"></div>

                <a href="/" class="relative inline-flex items-center justify-center" aria-label="JDM Custom Creations home">
                    <img src="{{ asset('images/jdm-logo-gold.png') }}" alt="JDM Custom Creations" class="object-contain drop-shadow-lg" style="height: 7rem; width: auto;">
                </a>

                <div class="relative auth-hero-card p-8">
                    <h1 class="font-lux text-5xl font-normal leading-[1.05] tracking-[-0.01em]">JDM Custom Creations</h1>
                    <p class="mt-4 font-lux text-[clamp(1.5rem,2.6vw,2.4rem)] italic leading-snug text-gold-300">Automotive art, handcrafted.</p>
                    <p class="mt-4 text-gray-200 max-w-sm">Hand-finished hardwood and epoxy crests, made to order for the collector's garage.</p>
                </div>

                <p class="relative text-xs text-gray-300">&copy; {{ date('Y') }} JDM Custom Creations</p>
            </div>

            {{-- Form column --}}
            <div class="themed flex min-h-screen flex-col items-center justify-center bg-ink-900 px-4 py-8 sm:px-6 sm:py-10 lg:items-center lg:overflow-y-auto lg:px-12 lg:py-10">
                <div class="w-full sm:max-w-lg">
                    <a href="/" class="mb-6 flex h-24 items-center justify-center lg:hidden" aria-label="JDM Custom Creations home">
                        <img src="{{ asset('images/jdm-custom-logo-gold.png') }}" alt="JDM Custom Creations" class="object-contain" style="height: 5rem; width: auto;">
                    </a>

                    <div class="auth-form-card bg-[#111113] p-6 sm:p-10">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
