<x-layouts::auth.card :title="__('auth.register.title')">

    <div class="mx-auto w-full max-w-md">

        {{-- Header --}}
        <div class="mb-8">
            <flux:heading size="xl" class="font-semibold tracking-tight">
                {{ __('auth.register.heading') }}
            </flux:heading>

            <flux:text class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                {{ __('auth.register.description') }}
            </flux:text>
        </div>

        {{-- Session Status --}}
        <x-auth-session-status class="mb-5" :status="session('status')" />

        {{-- Form --}}
        <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
            @csrf

            {{-- Name --}}
            <flux:input name="name" :label="__('auth.register.name')" :value="old('name')" type="text"
                required autofocus autocomplete="name" :placeholder="__('auth.register.name_placeholder')"
                class="w-full" icon="user" />

            {{-- Email --}}
            <flux:input name="email" :label="__('auth.register.email')" :value="old('email')" type="email"
                required autocomplete="email" placeholder="email@katasama.or.id" class="w-full" icon="envelope" />

            {{-- Password --}}
            <flux:input name="password" :label="__('auth.register.password')" type="password" required
                autocomplete="new-password" :placeholder="__('auth.register.password_placeholder')"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable class="w-full" icon="lock-closed" />

            {{-- Confirm Password --}}
            <flux:input name="password_confirmation" :label="__('auth.register.confirm_password')" type="password"
                required autocomplete="new-password" :placeholder="__('auth.register.confirm_password_placeholder')"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable class="w-full" icon="lock-closed" />

            {{-- Submit --}}
            <div class="pt-2">
                <x-loading-button target="register" :loading-text="__('auth.register.creating_account')" variant="primary" color="emerald"
                    class="w-full justify-center" data-test="register-user-button">
                    {{ __('auth.register.create_account') }}
                </x-loading-button>
            </div>
        </form>

        {{-- Login --}}
        {{-- 
        <div class="mt-7 text-center text-sm">
            <span class="text-zinc-500 dark:text-zinc-400">
                {{ __('auth.register.already_have_account') }}
            </span>

            <flux:link
                :href="route('login')"
                wire:navigate
                class="font-medium text-emerald-600 hover:text-emerald-700
                       dark:text-emerald-400 dark:hover:text-emerald-300"
            >
                {{ __('auth.register.login') }}
            </flux:link>
        </div>
        --}}

    </div>

</x-layouts::auth.card>