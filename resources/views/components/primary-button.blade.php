<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 bg-ink-900 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-gold-600 focus:bg-gold-600 active:bg-gold-600 focus:outline-none focus:ring-2 focus:ring-gold-600 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
