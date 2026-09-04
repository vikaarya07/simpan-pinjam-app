@props([
    'optionsRoute' => 'passkey.login-options',
    'submitRoute' => 'passkey.login',
    'label' => __('Sign in with a passkey'),
    'loadingLabel' => __('Authenticating...'),
    'separator' => __('Or continue with email'),
])

@assets
    @vite('resources/js/passkeys.js')
@endassets

<div x-data="{
    supported: false,
    loading: false,
    error: null,

    updateSupport() {
        this.supported = Boolean(window.Passkeys?.isSupported());
    },

    init() {
        this.updateSupport();

        window.addEventListener(
            'passkeys:ready',
            () => this.updateSupport(), { once: true }
        );
    },

    async verify() {
        if (this.loading) return;

        this.loading = true;
        this.error = null;

        try {
            const response = await window.Passkeys.verify({
                routes: {
                    options: '{{ route($optionsRoute) }}',
                    submit: '{{ route($submitRoute) }}',
                },
            });

            Livewire.navigate(response.redirect || '/dashboard');
        } catch (e) {
            if (e.constructor?.name !== 'UserCancelledError') {
                this.error = e.message || '{{ __('Unable to authenticate with passkey.') }}';
            }
        } finally {
            this.loading = false;
        }
    },
}">
    <template x-if="supported">
        <div class="space-y-4">

            {{-- Passkey button --}}
            <div class="space-y-2">
                <flux:button variant="outline" icon="finger-print"
                    class="w-full border text-emerald-600! border-emerald-600! hover:text-emerald-700! hover:border-emerald-700!
                               dark:text-emerald-400! dark:hover:text-emerald-300! dark:border-emerald-400! dark:hover:border-emerald-300!"
                    x-on:click="verify()" x-bind:disabled="loading">
                    <span x-show="!loading" class="flex items-center justify-center gap-2">
                        {{ $label }}
                    </span>

                    <span x-show="loading" x-cloak class="flex items-center justify-center gap-2">
                        <flux:icon.arrow-path class="size-4 animate-spin" />
                        {{ $loadingLabel }}
                    </span>
                </flux:button>

                {{-- Error --}}
                <div x-show="error" x-cloak x-transition
                    class="flex items-start gap-2 rounded-lg border border-red-200 bg-red-50 px-3 py-2.5
                           dark:border-red-500/20 dark:bg-red-500/10">
                    <flux:icon.x-circle class="mt-0.5 size-4 shrink-0 text-red-500 dark:text-red-400" />

                    <p x-text="error" class="text-sm leading-5 text-red-700 dark:text-red-400"></p>
                </div>
            </div>

            {{-- Separator --}}
            <div class="relative py-2">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-200 dark:border-slate-700"></div>
                </div>

                <div class="relative flex justify-center">
                    <span
                        class="bg-white px-3 text-xs font-medium tracking-wide text-slate-400
                               dark:bg-slate-900 dark:text-slate-500">
                        {{ $separator }}
                    </span>
                </div>
            </div>

        </div>
    </template>
</div>
