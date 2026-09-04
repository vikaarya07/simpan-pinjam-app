<x-layouts::auth.card :title="__('Register')">
    <div class="mx-auto w-full max-w-md">

        {{-- Header --}}
        <div class="mb-8">
            <flux:heading size="xl" class="font-semibold tracking-tight">
                {{ __('Create an account') }}
            </flux:heading>

            <flux:text class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                {{ __('Enter your details below to create your account') }}
            </flux:text>
        </div>

        {{-- Session Status --}}
        <x-auth-session-status class="mb-5" :status="session('status')" />

        {{-- Form --}}
        <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
            @csrf

            {{-- Name --}}
            <flux:input name="name" :label="__('Name')" :value="old('name')" type="text" required autofocus
                autocomplete="name" :placeholder="__('Full name')" class="w-full" icon="user" />

            {{-- Email --}}
            <flux:input name="email" :label="__('Email address')" :value="old('email')" type="email" required
                autocomplete="email" placeholder="email@katasama.or.id" class="w-full" icon="envelope" />

            {{-- Password --}}
            <flux:input name="password" :label="__('Password')" type="password" required autocomplete="new-password"
                :placeholder="__('Enter your password')"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable class="w-full" icon="lock-closed" />

            {{-- Confirm Password --}}
            <flux:input name="password_confirmation" :label="__('Confirm password')" type="password" required
                autocomplete="new-password" :placeholder="__('Repeat your password')"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable class="w-full" icon="lock-closed" />

            {{-- Submit --}}
            <div class="pt-2">
                <x-loading-button target="register" loading-text="{{ __('Creating account...') }}" variant="primary"
                    color="emerald" class="w-full justify-center" data-test="register-user-button">
                    {{ __('Create account') }}
                </x-loading-button>
            </div>
        </form>

        {{-- Login --}}
        {{-- <div class="mt-7 text-center text-sm">
            <span class="text-zinc-500 dark:text-zinc-400">
                {{ __('Already have an account?') }}
            </span>

            <flux:link :href="route('login')" wire:navigate
                class="font-medium text-emerald-600 hover:text-emerald-700
                               dark:text-emerald-400 dark:hover:text-emerald-300">
                {{ __('Log in') }}
            </flux:link>
        </div> --}}

    </div>
</x-layouts::auth.card>
