<x-layouts::auth.secure :title="__('auth.confirm_password.title')">

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
                {{ __('auth.confirm_password.heading') }}
            </flux:heading>

            <flux:text class="mx-auto mt-2 max-w-sm text-pretty">
                {{ __('auth.confirm_password.description') }}
            </flux:text>
        </div>

        {{-- Session Status --}}
        <x-auth-session-status class="mb-6" :status="session('status')" />

        {{-- Passkey & Password --}}
        <div class="space-y-5">

            {{-- Passkey --}}
            <x-passkey-verify options-route="passkey.confirm-options" submit-route="passkey.confirm" :label="__('auth.confirm_password.confirm_with_passkey')"
                :loading-label="__('auth.confirm_password.confirming')" :separator="__('auth.confirm_password.or_confirm_with_password')" />

            {{-- Password Confirmation --}}
            <form method="POST" action="{{ route('password.confirm.store') }}" class="space-y-5">
                @csrf

                <flux:field>
                    <flux:label>
                        {{ __('auth.confirm_password.password') }}
                    </flux:label>

                    <flux:input name="password" type="password" required autofocus autocomplete="current-password"
                        :placeholder="__('auth.confirm_password.password_placeholder')" viewable />

                    <flux:error name="password" />
                </flux:field>

                <flux:button variant="primary" type="submit" class="w-full" data-test="confirm-password-button">
                    {{ __('auth.confirm_password.confirm') }}
                </flux:button>
            </form>

        </div>

    </div>

</x-layouts::auth.secure>