<x-layouts::auth.secure :title="__('Confirm password')">

    <div class="mx-auto w-full max-w-md">

        {{-- Header --}}
        <div class="mb-8 text-center">

            {{-- Security Icon --}}
            <div
                class="mx-auto mb-6 flex size-14 items-center justify-center rounded-2xl
                   border border-zinc-200 bg-zinc-50 shadow-sm
                   dark:border-white/10 dark:bg-white/5">
                <flux:icon.shield-exclamation />
            </div>

            <flux:heading size="xl" class="font-semibold tracking-tight">
                {{ __('Confirm your identity') }}
            </flux:heading>

            <flux:text class="mx-auto mt-2 max-w-sm text-pretty">
                {{ __('This is a secure area of the application. Please confirm your identity before continuing.') }}
            </flux:text>

        </div>

        {{-- Session Status --}}
        <x-auth-session-status class="mb-6" :status="session('status')" />

        {{-- Passkey --}}
        <div class="space-y-5">

            <x-passkey-verify options-route="passkey.confirm-options" submit-route="passkey.confirm" :label="__('Confirm with passkey')"
                :loading-label="__('Confirming...')" :separator="__('Or confirm with password')" />

            {{-- Password Confirmation --}}
            <form method="POST" action="{{ route('password.confirm.store') }}" class="space-y-5">
                @csrf

                <flux:field>
                    <flux:label>
                        {{ __('Password') }}
                    </flux:label>

                    <flux:input name="password" type="password" required autofocus autocomplete="current-password"
                        :placeholder="__('Enter your password')" viewable />

                    <flux:error name="password" />
                </flux:field>

                <flux:button variant="primary" type="submit" class="w-full" data-test="confirm-password-button">
                    {{ __('Confirm password') }}
                </flux:button>
            </form>

        </div>

    </div>

</x-layouts::auth.secure>
