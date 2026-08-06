<x-guest-layout>
    <div class="auth-panel-aligned mx-auto w-full max-w-md">
        <div class="mb-8">
            <p class="text-xs font-bold uppercase tracking-[0.22em] text-red-600">Create your account</p>
            <h2 class="mt-2 font-heading text-3xl font-bold tracking-tight text-ink-900">Create your account</h2>
            <p class="mt-2 text-sm leading-6 text-gray-500">Set up your account to manage your custom orders with ease.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="auth-form-spacing space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Full name')" class="text-ink-900" />
                <x-text-input id="name" class="auth-premium-input mt-2 block w-full px-4 py-3" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email address')" class="text-ink-900" />
                <x-text-input id="email" class="auth-premium-input mt-2 block w-full px-4 py-3" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div x-data="{ showPassword: false }">
                <x-input-label for="password" :value="__('Password')" class="text-ink-900" />
                <div class="auth-password-field">
                    <x-text-input id="password" class="auth-password-input auth-premium-input block w-full px-4 py-3 pr-12"
                              x-ref="password"
                              x-bind:type="showPassword ? 'text' : 'password'"
                              name="password"
                              required autocomplete="new-password" />
                    <button type="button" @click="showPassword = ! showPassword" :aria-label="showPassword ? 'Hide password' : 'Show password'" :aria-pressed="showPassword.toString()" class="auth-eye-toggle">
                        <svg x-show="!showPassword" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12S5.25 5.25 12 5.25 21.75 12 21.75 12 18.75 18.75 12 18.75 2.25 12 2.25 12Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M14.25 12a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" /></svg>
                        <svg x-show="showPassword" style="display: none;" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 3 18 18" /><path stroke-linecap="round" stroke-linejoin="round" d="M10.6 5.4A9.7 9.7 0 0 1 12 5.25c6.75 0 9.75 6.75 9.75 6.75a18.7 18.7 0 0 1-3.17 4.16M6.12 6.12A18.9 18.9 0 0 0 2.25 12s3 6.75 9.75 6.75a9.8 9.8 0 0 0 4.1-.88M9.88 9.88a3 3 0 0 0 4.24 4.24" /></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div x-data="{ showConfirmation: false }">
                <x-input-label for="password_confirmation" :value="__('Confirm password')" class="text-ink-900" />
                <div class="auth-password-field">
                    <x-text-input id="password_confirmation" class="auth-password-input auth-premium-input block w-full px-4 py-3 pr-12"
                              x-ref="passwordConfirmation"
                              x-bind:type="showConfirmation ? 'text' : 'password'"
                              name="password_confirmation" required autocomplete="new-password" />
                    <button type="button" @click="showConfirmation = ! showConfirmation" :aria-label="showConfirmation ? 'Hide confirmation password' : 'Show confirmation password'" :aria-pressed="showConfirmation.toString()" class="auth-eye-toggle">
                        <svg x-show="!showConfirmation" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12S5.25 5.25 12 5.25 21.75 12 21.75 12 18.75 18.75 12 18.75 2.25 12 2.25 12Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M14.25 12a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" /></svg>
                        <svg x-show="showConfirmation" style="display: none;" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 3 18 18" /><path stroke-linecap="round" stroke-linejoin="round" d="M10.6 5.4A9.7 9.7 0 0 1 12 5.25c6.75 0 9.75 6.75 9.75 6.75a18.7 18.7 0 0 1-3.17 4.16M6.12 6.12A18.9 18.9 0 0 0 2.25 12s3 6.75 9.75 6.75a9.8 9.8 0 0 0 4.1-.88M9.88 9.88a3 3 0 0 0 4.24 4.24" /></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <x-primary-button class="w-full justify-center rounded-lg py-3.5 text-sm shadow-sm">
                {{ __('Create account') }}
            </x-primary-button>

            <p class="pt-1 text-center text-sm text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}" class="auth-account-link font-semibold text-red-600 transition hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2 rounded">Click here to sign in.</a>
            </p>
        </form>
    </div>
</x-guest-layout>
