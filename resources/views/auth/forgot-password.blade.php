<x-guest-layout>
    <div class="auth-panel-aligned mx-auto w-full max-w-md">
        <div class="mb-8">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-red-600">Account recovery</p>
            <h2 class="mt-2 font-heading text-3xl font-bold tracking-tight text-ink-900">Reset your password</h2>
            <p class="mt-2 text-sm leading-6 text-gray-500">Enter the email linked to your account and we&rsquo;ll send you a secure reset link.</p>
        </div>

        <x-auth-session-status class="mb-5" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="auth-form-spacing">
            @csrf
            <div>
                <x-input-label for="email" :value="__('Email address')" class="text-ink-900" />
                <x-text-input id="email" class="auth-premium-input mt-2 block w-full px-4 py-3" type="email" name="email" :value="old('email')" required autofocus autocomplete="email" placeholder="you@example.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <x-primary-button class="w-full justify-center rounded-lg py-3.5 text-sm shadow-sm">{{ __('Send reset link') }}</x-primary-button>

            <p class="pt-1 text-center text-sm text-gray-600">Remember your password? <a href="{{ route('login') }}" class="auth-account-link font-semibold text-red-600 hover:text-red-700">Sign in instead.</a></p>
        </form>
    </div>
</x-guest-layout>
