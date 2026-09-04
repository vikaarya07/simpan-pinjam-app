<x-layouts::auth :title="__('Log in')">

    <div class="flex flex-col gap-4">

        {{-- Header --}}
        <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

        {{-- Session Status --}}
        <x-auth-session-status class="text-center" :status="session('status')" />

        {{-- Passkey --}}
        <x-passkey-verify />

        {{-- Login --}}
        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-4">
            @csrf

            {{-- Email --}}
            <flux:input name="email" :label="__('Email address')" :value="old('email')" type="email" required
                autofocus autocomplete="email" placeholder="email@katasama.or.id" icon="envelope" />

            {{-- Password --}}
            <div class="relative">
                <flux:input name="password" :label="__('Password')" type="password" required icon="lock-closed"
                    autocomplete="current-password" :placeholder="__('Password')" viewable />

                @if (Route::has('password.request'))
                    <flux:link
                        class="absolute inset-e-0 top-0 text-sm
                               text-emerald-600 hover:text-emerald-700
                               dark:text-emerald-400 dark:hover:text-emerald-300"
                        :href="route('password.request')" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </flux:link>
                @endif
            </div>

            {{-- Remember --}}
            <flux:checkbox name="remember" :label="__('Remember me')" :checked="old('remember')" />

            {{-- Submit --}}
            <x-loading-button target="login" loading-text="{{ __('Logging in...') }}" variant="primary" color="emerald"
                class="w-full justify-center" data-test="login-button">
                {{ __('Log in') }}
            </x-loading-button>
        </form>

        {{-- Register --}}
        {{-- <div class="text-center text-sm text-slate-600
                   dark:text-slate-400">
            <span>{{ __('Don\'t have an account?') }}</span>

            <flux:link :href="route('register')" wire:navigate
                class="font-medium text-emerald-600
                       hover:text-emerald-700
                       dark:text-emerald-400
                       dark:hover:text-emerald-300">
                {{ __('Sign up') }}
            </flux:link>
        </div> --}}

    </div>

</x-layouts::auth>
