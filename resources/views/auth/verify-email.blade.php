<x-guest-layout>
    <div class="auth-panel-aligned mx-auto w-full max-w-md">
        <div class="mb-8">
            <h2 class="font-lux text-3xl font-normal tracking-tight text-[#ece7da]">One last step</h2>
            <p class="mt-3 font-lux text-xl italic leading-snug text-gold-300">Verify your email</p>
            <p class="mt-2 text-sm leading-6 text-[#8f949c]">We sent a verification link to your email address. Open it to activate your account.</p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-5 rounded-none border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm text-green-400">A new verification link has been sent to your email address.</div>
        @endif

        <div class="auth-form-spacing">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button class="w-full justify-center rounded-none py-3.5 text-sm shadow-sm">{{ __('Resend verification email') }}</x-primary-button>
            </form>
            <form method="POST" action="{{ route('logout') }}" class="text-center">
                @csrf
                <button type="submit" class="text-sm font-semibold text-[#b9b5ab] transition hover:text-gold-300 focus:outline-none focus:ring-2 focus:ring-gold-500  rounded">Log out</button>
            </form>
        </div>
    </div>
</x-guest-layout>
