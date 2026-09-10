<x-layouts::auth.secure :title="__('app.auth.reset_password.title')">

    <div class="mx-auto w-full max-w-md">

        {{-- Header --}}
        <div class="mb-5 text-center">

            {{-- Security Icon --}}
            <div
                class="mx-auto mb-4 flex size-14 items-center justify-center rounded-2xl
                       border border-zinc-200 bg-zinc-50 shadow-sm
                       dark:border-white/10 dark:bg-white/5">
                <flux:icon.lock-closed />
            </div>

            <flux:heading size="xl" class="font-semibold tracking-tight">
                {{ __('app.auth.reset_password.heading') }}
            </flux:heading>

            <flux:text class="mx-auto mt-2 max-w-sm text-pretty">
                {{ __('app.auth.reset_password.description') }}
            </flux:text>
        </div>

        {{-- Session Status --}}
        <x-auth-session-status class="mb-3" :status="session('status')" />

        {{-- Form --}}
        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf

            {{-- Token --}}
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            {{-- Email --}}
            <flux:field>
                <flux:label>
                    {{ __('app.auth.reset_password.email') }}
                </flux:label>

                <flux:input name="email" value="{{ request('email') }}" type="email" required autocomplete="email"
                    placeholder="email@katasama.or.id" icon="envelope" />

                <flux:error name="email" />
            </flux:field>

            {{-- Password --}}
            <flux:field>
                <flux:label>
                    {{ __('app.auth.reset_password.new_password') }}
                </flux:label>

                <flux:input name="password" type="password" required autocomplete="new-password"
                    :placeholder="__('app.auth.reset_password.new_password_placeholder')" icon="lock-closed"
                    passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                    viewable />

                <flux:error name="password" />
            </flux:field>

            {{-- Confirm Password --}}
            <flux:field>
                <flux:label>
                    {{ __('app.auth.reset_password.confirm_password') }}
                </flux:label>

                <flux:input name="password_confirmation" type="password" required autocomplete="new-password"
                    :placeholder="__('app.auth.reset_password.confirm_password_placeholder')" icon="lock-closed"
                    passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                    viewable />

                <flux:error name="password_confirmation" />
            </flux:field>

            {{-- Submit --}}
            <flux:button type="submit" variant="primary" class="mt-2 w-full" data-test="reset-password-button">
                {{ __('app.auth.reset_password.reset_password') }}
            </flux:button>
        </form>

        {{-- Security Hint --}}
        <div
            class="mt-3 rounded-xl border border-zinc-200/80 bg-zinc-50/70
                   px-4 py-3 text-center text-xs text-zinc-500
                   dark:border-white/10 dark:bg-white/5 dark:text-zinc-400">
            {{ __('app.auth.reset_password.security_hint') }}
        </div>

    </div>

</x-layouts::auth.secure>