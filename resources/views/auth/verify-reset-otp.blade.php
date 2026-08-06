<x-guest-layout>
    <style>
        .otp-code-panel { margin-top: 0.6rem; padding: 1.1rem; border: 1px solid #fee2e2; border-radius: 1rem; background: linear-gradient(135deg, #fffafa 0%, #fff 72%); box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04); }
        .otp-inputs { display: grid; grid-template-columns: repeat(6, minmax(0, 1fr)); gap: 0.65rem; }
        .otp-digit { width: 100%; height: 3.75rem; border: 1px solid #cbd5e1; border-radius: 0.75rem; background: #fff; box-shadow: inset 0 1px 1px rgba(15, 23, 42, 0.03); color: #111827; font-size: 1.45rem; font-weight: 800; line-height: 1; text-align: center; transition: border-color 160ms ease, background-color 160ms ease, box-shadow 160ms ease, color 160ms ease, transform 160ms ease; }
        .otp-digit:hover { border-color: #fca5a5; transform: translateY(-1px); }
        .otp-digit:focus { border-color: #dc2626; background: #fffafa; box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.12); outline: none; transform: translateY(-2px); }
        .otp-digit--filled { border-color: #dc2626; background: #dc2626; box-shadow: 0 5px 12px rgba(220, 38, 38, 0.22); color: #fff; }
        .otp-digit--filled:focus { background: #b91c1c; color: #fff; }
        @media (max-width: 420px) { .otp-code-panel { padding: 0.8rem; } .otp-inputs { gap: 0.4rem; } .otp-digit { height: 3.25rem; font-size: 1.2rem; } }
    </style>
    <div class="auth-panel-aligned mx-auto w-full max-w-md">
        <div class="mb-8">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-red-600">Account recovery</p>
            <h2 class="mt-2 font-heading text-3xl font-bold tracking-tight text-ink-900">Verify your code</h2>
            <p class="mt-2 text-sm leading-6 text-gray-500">Enter the 6-digit code sent to <span class="font-medium text-ink-900">{{ $email }}</span>.</p>
        </div>

        <x-auth-session-status class="mb-5" :status="session('status')" />

        <form method="POST" action="{{ route('password.otp.verify') }}" class="auth-form-spacing" x-data="{
            digits: ['', '', '', '', '', ''],
            sync() { this.$refs.otp.value = this.digits.join(''); },
            input(index, event) {
                const value = event.target.value.replace(/\D/g, '');
                if (value.length > 1) {
                    value.slice(0, 6 - index).split('').forEach((digit, offset) => this.digits[index + offset] = digit);
                } else {
                    this.digits[index] = value;
                }
                this.sync();
                const next = Math.min(index + value.length, 5);
                if (value && index < 5) this.$refs['digit' + next].focus();
            },
            backspace(index) {
                if (this.digits[index]) { this.digits[index] = ''; }
                else if (index > 0) { this.digits[index - 1] = ''; this.$refs['digit' + (index - 1)].focus(); }
                this.sync();
            },
            paste(event) {
                const pasted = event.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6).split('');
                if (! pasted.length) return;
                event.preventDefault();
                this.digits = Array.from({ length: 6 }, (_, index) => pasted[index] || '');
                this.sync();
                this.$refs['digit' + Math.max(pasted.length - 1, 0)].focus();
            }
        }">
            @csrf
            <div>
                <x-input-label for="otp" :value="__('Verification code')" class="text-ink-900" />
                <input x-ref="otp" id="otp" name="otp" type="hidden" required>
                <div class="otp-code-panel">
                    <div class="otp-inputs" @paste="paste($event)">
                    @for ($index = 0; $index < 6; $index++)
                        <input
                            x-ref="digit{{ $index }}"
                            x-bind:value="digits[{{ $index }}]"
                            @input="input({{ $index }}, $event)"
                            @keydown.backspace.prevent="backspace({{ $index }})"
                            type="text"
                            inputmode="numeric"
                            pattern="[0-9]*"
                            maxlength="1"
                            autocomplete="{{ $index === 0 ? 'one-time-code' : 'off' }}"
                            aria-label="Digit {{ $index + 1 }} of verification code"
                            class="otp-digit"
                            x-bind:class="{ 'otp-digit--filled': digits[{{ $index }}] }"
                            {{ $index === 0 ? 'autofocus' : '' }}
                        >
                    @endfor
                    </div>
                </div>
                <x-input-error :messages="$errors->get('otp')" class="mt-2" />
            </div>
            <x-primary-button class="w-full justify-center rounded-lg py-3.5 text-sm shadow-sm">{{ __('Verify code') }}</x-primary-button>
            <p class="pt-1 text-center text-sm text-gray-600">Didn&rsquo;t receive it? <a href="{{ route('password.request') }}" class="auth-account-link font-semibold text-red-600 hover:text-red-700">Request a new code.</a></p>
        </form>
    </div>
</x-guest-layout>
