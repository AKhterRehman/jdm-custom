<x-guest-layout>
    <div class="auth-panel-aligned mx-auto w-full max-w-md">
        <div class="mb-8">
            <h2 class="font-lux text-3xl font-normal tracking-tight text-[#ece7da]">Reset your password</h2>
            <p class="mt-2 text-sm leading-6 text-[#8f949c]">Enter the email linked to your account and we&rsquo;ll send you a secure reset link.</p>
        </div>

        <x-auth-session-status class="mb-5" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="auth-form-spacing">
            @csrf
            <div>
                <x-input-label for="email" :value="__('Email address')" class="text-[#ece7da]" />
                <x-text-input id="email" class="auth-premium-input mt-2 block w-full px-4 py-3" type="email" name="email" :value="old('email')" required autofocus autocomplete="email" placeholder="you@example.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <x-primary-button class="w-full justify-center rounded-none py-3.5 text-sm shadow-sm">{{ __('Send reset link') }}</x-primary-button>

            <p class="pt-1 text-center text-sm text-[#b9b5ab]">Remember your password? <a href="{{ route('login') }}" class="auth-account-link font-semibold text-gold-400 hover:text-gold-300">Sign in instead.</a></p>
        </form>
    </div>
</x-guest-layout>
