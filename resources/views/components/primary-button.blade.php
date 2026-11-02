<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-gold focus:outline-none focus:ring-2 focus:ring-gold-500 focus:ring-offset-2 focus:ring-offset-ink-900']) }}>
    {{ $slot }}
</button>
