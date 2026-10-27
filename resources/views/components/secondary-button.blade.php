<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-[#111113] border border-white/15 rounded-none font-semibold text-xs text-[#d3cec1] uppercase tracking-widest shadow-sm hover:bg-white/5 focus:outline-none focus:ring-2 focus:ring-gold-600 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
