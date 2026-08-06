<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/update logo.png') }}">

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
            <div class="hidden lg:flex flex-col justify-between bg-ink-900 text-white p-12 relative overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,_rgba(220,38,38,0.2),_transparent_60%)]"></div>
                <a href="/" class="relative" aria-label="JDM Custom home">
                    <img src="{{ asset('images/update logo.png') }}" alt="JDM Custom" class="jdm-logo object-contain" style="height: 6rem; width: auto;">
                </a>
                <div class="relative">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-500 mb-4">Handcrafted &middot; Custom &middot; Made Your Way</p>
                    <h1 class="font-heading text-4xl font-bold leading-tight">Wood Art, Handcrafted for You</h1>
                    <p class="mt-4 text-gray-300 max-w-sm">Custom engravings, CNC art, shadow boxes, and jewelry boxes — shaped with precision and finished by hand.</p>
                </div>
                <p class="relative text-xs text-gray-500">&copy; {{ date('Y') }} JDM Custom Creations</p>
            </div>

            <div class="flex flex-col justify-start items-center px-6 py-10 lg:items-start lg:overflow-y-auto lg:pl-12 lg:pr-12 lg:py-10 bg-slate-50">
                <div class="w-full sm:max-w-lg">
                    <a href="/" class="mb-6 flex h-24 items-center justify-center lg:hidden" aria-label="JDM Custom home">
                        <img src="{{ asset('images/update logo.png') }}" alt="JDM Custom" class="jdm-logo object-contain" style="height: 5rem; width: auto;">
                    </a>

                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
