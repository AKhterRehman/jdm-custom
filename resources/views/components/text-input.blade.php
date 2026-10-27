@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-white/15 focus:border-gold-600 focus:ring-gold-600 rounded-none shadow-sm']) }}>
