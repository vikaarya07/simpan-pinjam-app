<x-layouts::auth.secure :title="__('Two-factor authentication')">

    <div class="mx-auto w-full max-w-md">

        <div x-cloak x-data="{
            showRecoveryInput: @js($errors->has('recovery_code')),
            code: '',
            recovery_code: '',
        
            focusOtp() {
                this.$nextTick(() => {
                    this.$refs.otp?.querySelector('input')?.focus();
                });
            },
        
            init() {
                if (!this.showRecoveryInput) {
                    this.focusOtp();
                }
            },
        
            toggleInput() {
                this.showRecoveryInput = !this.showRecoveryInput;
        
                this.code = '';
                this.recovery_code = '';
        
                this.$nextTick(() => {
                    this.showRecoveryInput ?
                        this.$refs.recovery_code?.focus() :
                        this.focusOtp();
                });
            },
        }">

            {{-- Security Icon --}}
            <div class="mb-6 flex justify-center">

                <div
                    class="flex size-14 items-center justify-center rounded-2xl
                       border border-zinc-200 bg-zinc-50 shadow-sm
                       dark:border-white/10 dark:bg-white/5">
                    {{-- OTP Icon --}}
                    <svg x-show="!showRecoveryInput" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.7" class="size-7 text-zinc-700 dark:text-zinc-200">
                        <rect width="14" height="14" x="5" y="5" rx="2" />
                        <path stroke-linecap="round" d="M9 9h.01M12 9h.01M15 9h.01
                           M9 12h.01M12 12h.01M15 12h.01
                           M9 15h.01M12 15h.01M15 15h.01" />
                    </svg>

                    {{-- Recovery Icon --}}
                    <svg x-show="showRecoveryInput" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.7"
                        class="size-7 text-zinc-700 dark:text-zinc-200">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75 5.25 6.75v5.25
                           c0 4.087 2.775 7.85 6.75 8.95
                           3.975-1.1 6.75-4.863 6.75-8.95V6.75L12 3.75Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 12 11.25 13.5 14.5 10.25" />
                    </svg>
                </div>

            </div>

            {{-- Authentication Code Header --}}
            <div x-show="!showRecoveryInput" x-transition.opacity.duration.200ms class="mb-8 text-center">
                <flux:heading size="xl" class="font-semibold tracking-tight">
                    {{ __('Authentication code') }}
                </flux:heading>

                <flux:text class="mx-auto mt-2 max-w-sm text-pretty">
                    {{ __('Enter the 6-digit code from your authenticator app to continue.') }}
                </flux:text>
            </div>

            {{-- Recovery Code Header --}}
            <div x-show="showRecoveryInput" x-transition.opacity.duration.200ms class="mb-8 text-center">
                <flux:heading size="xl" class="font-semibold tracking-tight">
                    {{ __('Recovery code') }}
                </flux:heading>

                <flux:text class="mx-auto mt-2 max-w-sm text-pretty">
                    {{ __('Enter one of your emergency recovery codes to access your account.') }}
                </flux:text>
            </div>

            {{-- Form --}}
            <form method="POST" action="{{ route('two-factor.login.store') }}">
                @csrf

                {{-- OTP --}}
                <div x-show="!showRecoveryInput" x-transition.opacity.duration.200ms>
                    <div x-ref="otp" class="flex justify-center">
                        <flux:otp x-model="code" length="6" name="code" label="OTP Code" label:sr-only
                            class="mx-auto" />
                    </div>

                    @error('code')
                        <div class="mt-3 text-center">
                            <flux:text color="red">
                                {{ $message }}
                            </flux:text>
                        </div>
                    @enderror
                </div>

                {{-- Recovery Code --}}
                <div x-show="showRecoveryInput" x-transition.opacity.duration.200ms>
                    <flux:field>

                        <flux:label class="sr-only">
                            {{ __('Recovery code') }}
                        </flux:label>

                        <flux:input type="text" name="recovery_code" x-ref="recovery_code"
                            x-bind:required="showRecoveryInput" autocomplete="one-time-code" x-model="recovery_code"
                            :placeholder="__('Enter your recovery code')" autofocus />

                        <flux:error name="recovery_code" />

                    </flux:field>
                </div>

                {{-- Continue --}}
                <flux:button variant="primary" type="submit" class="mt-6 w-full">
                    {{ __('Continue') }}
                </flux:button>

            </form>

            {{-- Alternative Method --}}
            <div class="mt-8">

                <div class="relative flex items-center">
                    <div class="grow border-t border-zinc-200 dark:border-white/10"></div>

                    <span
                        class="mx-4 shrink-0 text-xs font-medium uppercase tracking-wider
                           text-zinc-400 dark:text-zinc-500">
                        {{ __('or') }}
                    </span>

                    <div class="grow border-t border-zinc-200 dark:border-white/10"></div>
                </div>

                <button type="button" @click="toggleInput()"
                    class="mt-5 w-full text-center text-sm font-medium
                       text-zinc-600 transition hover:text-zinc-900
                       dark:text-zinc-400 dark:hover:text-white">
                    <span x-show="!showRecoveryInput">
                        {{ __('Use a recovery code instead') }}
                    </span>

                    <span x-show="showRecoveryInput">
                        {{ __('Use an authentication code instead') }}
                    </span>
                </button>

            </div>

            {{-- Security Hint --}}
            <div
                class="mt-6 rounded-xl border border-zinc-200/80 bg-zinc-50/70
                   px-4 py-3 text-center text-xs leading-relaxed text-zinc-500
                   dark:border-white/10 dark:bg-white/5 dark:text-zinc-400">
                <span x-show="!showRecoveryInput">
                    {{ __('Use the code generated by your authenticator application.') }}
                </span>

                <span x-show="showRecoveryInput">
                    {{ __('Each recovery code can only be used once.') }}
                </span>
            </div>

        </div>

    </div>

</x-layouts::auth.secure>
