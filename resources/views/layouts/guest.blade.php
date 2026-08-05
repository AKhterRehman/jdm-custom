<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|lexend:600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-ink-900 antialiased">
        <div class="min-h-screen grid lg:grid-cols-2">
            <div class="hidden lg:flex flex-col justify-between bg-ink-900 text-white p-12 relative overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,_rgba(220,38,38,0.2),_transparent_60%)]"></div>
                <a href="/" class="relative font-heading text-xl font-bold">
                    JDM <span class="text-red-600">Custom Creations</span>
                </a>
                <div class="relative">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-500 mb-4">Handcrafted &middot; Custom &middot; Made Your Way</p>
                    <h1 class="font-heading text-4xl font-bold leading-tight">Wood Art, Handcrafted for You</h1>
                    <p class="mt-4 text-gray-300 max-w-sm">Custom engravings, CNC art, shadow boxes, and jewelry boxes — shaped with precision and finished by hand.</p>
                </div>
                <p class="relative text-xs text-gray-500">&copy; {{ date('Y') }} JDM Custom Creations</p>
            </div>

            <div class="flex flex-col justify-center items-center px-6 py-12 bg-white">
                <div class="w-full sm:max-w-md">
                    <a href="/" class="lg:hidden block text-center mb-8 font-heading text-xl font-bold text-ink-900">
                        JDM <span class="text-red-600">Custom Creations</span>
                    </a>

                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
