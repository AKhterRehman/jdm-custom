<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 bg-red-600 border border-transparent font-bold text-xs text-white uppercase tracking-[0.18em] hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-ink-900 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
