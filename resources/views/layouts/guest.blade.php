<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/jdm-custom-logo.png') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|lexend:600,700,800&display=swap" rel="stylesheet" />

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
                border-color: #d1d5db;
                border-radius: 0.625rem;
                box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
                transition: border-color 150ms ease, box-shadow 150ms ease;
            }

            .auth-premium-input:focus {
                border-color: #dc2626;
                box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12);
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
                border-radius: 0.5rem;
                color: #94a3b8;
                transition: color 150ms ease, background-color 150ms ease;
            }

            .auth-eye-toggle:hover {
                background: #fef2f2;
                color: #dc2626;
            }

            .auth-eye-toggle:focus-visible {
                outline: 2px solid #dc2626;
                outline-offset: 2px;
            }

            /* Hero column background */
            .auth-hero-panel {
                background-image:
                    linear-gradient(180deg, rgba(15, 15, 15, 0.55) 0%, rgba(15, 15, 15, 0.35) 45%, rgba(15, 15, 15, 0.8) 100%),
                    url('{{ asset('images/hero-wood-bg.jpg') }}');
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
                box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04), 0 12px 32px -12px rgba(15, 23, 42, 0.12);
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
    <body class="font-sans text-ink-900 antialiased">
        <div class="min-h-screen grid lg:h-screen lg:grid-cols-2">
            {{-- Hero / brand column --}}
            <div class="hidden lg:flex flex-col justify-between text-white p-12 relative overflow-hidden auth-hero-panel">
                {{-- subtle red radial accent, kept from original --}}
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,_rgba(220,38,38,0.25),_transparent_60%)]"></div>

                <a href="/" class="relative inline-flex items-center justify-center" aria-label="JDM Custom Creations home">
                    <img src="{{ asset('images/jdm-logo-onDark.png') }}" alt="JDM Custom Creations" class="object-contain drop-shadow-lg" style="height: 7rem; width: auto;">
                </a>

                <div class="relative auth-hero-card rounded-2xl p-8">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-400 mb-4">Handcrafted &middot; Custom &middot; Made Your Way</p>
                    <h1 class="font-heading text-4xl font-bold leading-tight">Wood Art, Handcrafted for You</h1>
                    <p class="mt-4 text-gray-200 max-w-sm">Custom engravings, CNC art, shadow boxes, and jewelry boxes — shaped with precision and finished by hand.</p>
                </div>

                <p class="relative text-xs text-gray-300">&copy; {{ date('Y') }} JDM Custom Creations</p>
            </div>

            {{-- Form column --}}
            <div class="flex flex-col justify-center items-center px-6 py-10 lg:items-center lg:overflow-y-auto lg:pl-12 lg:pr-12 lg:py-10 bg-slate-50">
                <div class="w-full sm:max-w-lg">
                    <a href="/" class="mb-6 flex h-24 items-center justify-center lg:hidden" aria-label="JDM Custom Creations home">
                        <img src="{{ asset('images/jdm-custom-logo.png') }}" alt="JDM Custom Creations" class="object-contain" style="height: 5rem; width: auto;">
                    </a>

                    <div class="auth-form-card bg-white rounded-2xl p-8 sm:p-10">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>