<x-guest-layout>
    <div class="auth-panel-aligned mx-auto w-full max-w-md">
        <div class="mb-8">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-gold-400">One last step</p>
            <h2 class="mt-2 font-display text-3xl font-bold tracking-tight text-white">Verify your email</h2>
            <p class="mt-2 text-sm leading-6 text-silver-400">We sent a verification link to your email address. Open it to activate your account.</p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-5 rounded-lg border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm text-green-300">A new verification link has been sent to your email address.</div>
        @endif

        <div class="auth-form-spacing">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button class="w-full justify-center rounded-lg py-3.5 text-sm shadow-sm">{{ __('Resend verification email') }}</x-primary-button>
            </form>
            <form method="POST" action="{{ route('logout') }}" class="text-center">
                @csrf
                <button type="submit" class="text-sm font-semibold text-silver-300 transition hover:text-gold-300 focus:outline-none focus:ring-2 focus:ring-gold-500 focus:ring-offset-2 rounded">Log out</button>
            </form>
        </div>
    </div>
</x-guest-layout>
