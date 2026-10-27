<x-guest-layout>
    <div class="auth-panel-aligned mx-auto w-full max-w-md">
        <div class="mb-8">
            <h2 class="font-lux text-3xl font-normal tracking-tight text-[#ece7da]">Sign in to your account</h2>
            <p class="mt-2 text-sm leading-6 text-[#8f949c]">Enter your details below to continue to JDM Custom.</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-5" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="auth-form-spacing space-y-5">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email address')" class="text-[#ece7da]" />
                <x-text-input id="email" class="auth-premium-input mt-2 block w-full px-4 py-3" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div x-data="{ showPassword: false }">
                <x-input-label for="password" :value="__('Password')" class="text-[#ece7da]" />
                <div class="auth-password-field">
                    <x-text-input id="password" class="auth-password-input auth-premium-input block w-full px-4 py-3 pr-12"
                                x-ref="password"
                                x-bind:type="showPassword ? 'text' : 'password'"
                                name="password"
                                required autocomplete="current-password" />
                    <button type="button" @click="showPassword = ! showPassword" :aria-label="showPassword ? 'Hide password' : 'Show password'" :aria-pressed="showPassword.toString()" class="auth-eye-toggle">
                        <svg x-show="!showPassword" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12S5.25 5.25 12 5.25 21.75 12 21.75 12 18.75 18.75 12 18.75 2.25 12 2.25 12Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M14.25 12a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" /></svg>
                        <svg x-show="showPassword" style="display: none;" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 3 18 18" /><path stroke-linecap="round" stroke-linejoin="round" d="M10.6 5.4A9.7 9.7 0 0 1 12 5.25c6.75 0 9.75 6.75 9.75 6.75a18.7 18.7 0 0 1-3.17 4.16M6.12 6.12A18.9 18.9 0 0 0 2.25 12s3 6.75 9.75 6.75a9.8 9.8 0 0 0 4.1-.88M9.88 9.88a3 3 0 0 0 4.24 4.24" /></svg>
                    </button>
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between gap-4 pt-0.5">
                <label for="remember_me" class="inline-flex cursor-pointer items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-white/15 text-gold-400 shadow-sm focus:ring-gold-500" name="remember">
                    <span class="ms-2 text-sm text-[#b9b5ab]">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-[#b9b5ab] transition hover:text-gold-300 focus:outline-none focus:ring-2 focus:ring-gold-500  rounded" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <x-primary-button class="w-full justify-center rounded-none py-3.5 text-sm shadow-sm">
                {{ __('Sign in') }}
            </x-primary-button>

            @if (Route::has('register'))
                <div class="pt-1 text-center">
                    <p class="mb-3 text-sm text-[#b9b5ab]">Don&rsquo;t have an account?</p>
                    <a href="{{ route('register') }}" class="auth-account-link flex w-full items-center justify-center rounded-none border border-white/15 bg-[#111113] px-4 py-3.5 text-sm font-semibold text-[#ece7da] shadow-sm transition hover:border-gold-500 hover:text-gold-300 focus:outline-none focus:ring-2 focus:ring-gold-500 ">
                        {{ __('Create account') }}
                    </a>
                </div>
            @endif
        </form>
    </div>
</x-guest-layout>
