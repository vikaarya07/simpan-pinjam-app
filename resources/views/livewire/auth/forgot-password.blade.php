<x-layouts::auth.card :title="__('app.auth.forgot_password.title')">

    <div class="mx-auto w-full max-w-md">

        {{-- Header --}}
        <div class="mb-8 text-center">

            {{-- Icon --}}
            <div
                class="mx-auto mb-6 flex size-14 items-center justify-center rounded-2xl
                    border border-zinc-200 bg-zinc-50 shadow-sm
                    dark:border-white/10 dark:bg-white/5">
                <flux:icon.shield-exclamation />
            </div>

            <flux:heading size="xl" class="font-semibold tracking-tight">
                {{ __('app.auth.forgot_password.heading') }}
            </flux:heading>

            <flux:text class="mx-auto mt-2 max-w-sm text-pretty">
                {{ __('app.auth.forgot_password.description') }}
            </flux:text>
        </div>

        {{-- Session Status --}}
        <x-auth-session-status class="mb-6" :status="session('status')" />

        {{-- Form --}}
        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <flux:field>
                <flux:label>
                    {{ __('app.auth.forgot_password.email') }}
                </flux:label>

                <flux:input name="email" type="email" required autofocus autocomplete="email"
                    placeholder="email@katasama.or.id" icon="envelope" />

                <flux:error name="email" />
            </flux:field>

            <flux:button variant="primary" type="submit" class="w-full" data-test="email-password-reset-link-button">
                {{ __('app.auth.forgot_password.send_reset_link') }}
            </flux:button>
        </form>

        {{-- Back to Login --}}
        <div class="mt-8 flex items-center justify-center gap-1.5 text-sm">
            <flux:text>
                {{ __('app.auth.forgot_password.remember_password') }}
            </flux:text>

            <flux:link :href="route('login')" wire:navigate class="font-medium">
                {{ __('app.auth.forgot_password.login') }}
            </flux:link>
        </div>

    </div>

</x-layouts::auth.card>