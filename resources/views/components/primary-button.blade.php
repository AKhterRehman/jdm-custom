<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center whitespace-nowrap border border-transparent bg-[#ece7da] px-6 py-3 font-label text-[0.72rem] font-medium uppercase tracking-[0.26em] text-ink-900 transition duration-300 hover:bg-gold-500 focus:bg-gold-500 focus:outline-none disabled:cursor-not-allowed disabled:opacity-40']) }}>
    {{ $slot }}
</button>
