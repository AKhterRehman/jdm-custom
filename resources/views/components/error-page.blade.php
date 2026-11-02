@props(['code', 'title', 'message'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $code }} {{ $title }} - {{ config('app.name') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/jdm-custom-logo-gold.png') }}">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|cormorant-garamond:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css'])
    </head>
    <body class="font-sans antialiased bg-ink-900 text-gray-300">
        <main class="relative isolate flex min-h-screen flex-col items-center justify-center overflow-hidden px-6 py-16 text-center">
            <img src="{{ asset('images/luxury-garage-commission.jpg') }}" alt="" class="absolute inset-0 -z-20 h-full w-full object-cover opacity-30" aria-hidden="true">
            <div class="absolute inset-0 -z-10 bg-gradient-to-b from-ink-900/80 via-ink-900/70 to-ink-900"></div>

            <a href="{{ url('/') }}" aria-label="JDM Custom Creations home">
                <img src="{{ asset('images/jdm-logo-gold.png') }}" alt="JDM Custom Creations" class="object-contain" style="height: 6rem; width: auto;">
            </a>

            <p class="lux-eyebrow mt-14">Error {{ $code }}</p>
            <h1 class="mt-5 font-display text-5xl font-medium tracking-tight text-white sm:text-6xl">{{ $title }}</h1>
            <div class="lux-rule mx-auto mt-8"></div>
            <p class="mx-auto mt-6 max-w-md text-silver-300">{{ $message }}</p>

            <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                <a href="{{ url('/') }}" class="btn-gold">Back to home</a>
                <a href="{{ url('/shop') }}" class="btn-ghost">Browse the shop</a>
            </div>
        </main>
    </body>
</html>
