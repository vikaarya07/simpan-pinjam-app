<x-layouts::auth :title="__('app.auth.login.title')">

    <div class="flex flex-col gap-4">

        {{-- Header --}}
        <x-auth-header :title="__('app.auth.login.heading')" :description="__('app.auth.login.description')" />

        {{-- Session Status --}}
        <x-auth-session-status class="text-center" :status="session('status')" />

        {{-- Passkey --}}
        <x-passkey-verify />

        {{-- Login --}}
        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-4">
            @csrf

            {{-- Email --}}
            <flux:input name="email" :label="__('app.auth.login.email')" :value="old('email')" type="email" required
                autofocus autocomplete="email" placeholder="email@katasama.or.id" icon="envelope" />

            {{-- Password --}}
            <div class="relative">
                <flux:input name="password" :label="__('app.auth.login.password')" type="password" required
                    icon="lock-closed" autocomplete="current-password"
                    :placeholder="__('app.auth.login.password_placeholder')" viewable />

                @if (Route::has('password.request'))
                    <flux:link
                        class="absolute inset-e-0 top-0 text-sm
                               text-emerald-600 hover:text-emerald-700
                               dark:text-emerald-400 dark:hover:text-emerald-300"
                        :href="route('password.request')" wire:navigate>
                        {{ __('app.auth.login.forgot_password') }}
                    </flux:link>
                @endif
            </div>

            {{-- Remember --}}
            <flux:checkbox name="remember" :label="__('app.auth.login.remember_me')" :checked="old('remember')" />

            {{-- Submit --}}
            <x-loading-button target="login" :loading-text="__('app.auth.login.logging_in')" variant="primary" color="emerald"
                class="w-full justify-center" data-test="login-button">
                {{ __('app.auth.login.login') }}
            </x-loading-button>
        </form>

        {{-- Register --}}
        {{--
        <div class="text-center text-sm text-slate-600 dark:text-slate-400">
            <span>
                {{ __('app.auth.login.dont_have_account') }}
            </span>

            <flux:link
                :href="route('register')"
                wire:navigate
                class="font-medium text-emerald-600
                       hover:text-emerald-700
                       dark:text-emerald-400
                       dark:hover:text-emerald-300"
            >
                {{ __('app.auth.login.sign_up') }}
            </flux:link>
        </div>
        --}}

    </div>

</x-layouts::auth>