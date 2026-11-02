<x-guest-layout>
    <div class="auth-panel-aligned mx-auto w-full max-w-md">
        <div class="mb-8">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-gold-400">Account recovery</p>
            <h2 class="mt-2 font-display text-3xl font-bold tracking-tight text-white">Reset your password</h2>
            <p class="mt-2 text-sm leading-6 text-silver-400">Enter the email linked to your account and we&rsquo;ll send you a secure reset link.</p>
        </div>

        <x-auth-session-status class="mb-5" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="auth-form-spacing">
            @csrf
            <div>
                <x-input-label for="email" :value="__('Email address')" class="text-white" />
                <x-text-input id="email" class="auth-premium-input mt-2 block w-full px-4 py-3" type="email" name="email" :value="old('email')" required autofocus autocomplete="email" placeholder="you@example.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <x-primary-button class="w-full justify-center rounded-lg py-3.5 text-sm shadow-sm">{{ __('Send reset link') }}</x-primary-button>

            <p class="pt-1 text-center text-sm text-silver-300">Remember your password? <a href="{{ route('login') }}" class="auth-account-link font-semibold text-gold-400 hover:text-gold-200">Sign in instead.</a></p>
        </form>
    </div>
</x-guest-layout>
