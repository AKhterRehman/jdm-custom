@props(['image' => 'luxury-garage-hero.jpg'])

{{-- Photo background for page headers. The values match the home page hero, so every header
     shows the car with the same clarity and keeps the left side dark enough for the headline. --}}
<img src="{{ asset('images/'.$image) }}" alt="" class="absolute inset-0 -z-20 h-full w-full object-cover opacity-95 brightness-110 contrast-105" aria-hidden="true">
<div class="absolute inset-0 -z-10 bg-[linear-gradient(95deg,rgba(11,11,13,0.9)_0%,rgba(11,11,13,0.55)_38%,rgba(11,11,13,0.12)_100%)]"></div>
<div class="absolute inset-x-0 bottom-0 -z-10 h-40 bg-gradient-to-t from-ink-900 to-transparent"></div>
