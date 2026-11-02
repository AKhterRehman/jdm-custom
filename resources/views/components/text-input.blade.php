@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-white/15 bg-white/5 text-white placeholder:text-silver-500 focus:border-gold-500 focus:ring-gold-500 rounded-md shadow-sm']) }}>
