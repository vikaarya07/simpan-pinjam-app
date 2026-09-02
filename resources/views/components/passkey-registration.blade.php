@assets
    @vite('resources/js/passkeys.js')
@endassets

<div x-data="{
    supported: false,
    showForm: false,
    name: '',
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

    async register() {
        if (!this.name.trim() || this.loading) return;

        this.loading = true;
        this.error = null;

        try {
            await window.Passkeys.register({
                name: this.name.trim(),
            });

            this.name = '';
            this.showForm = false;

            await $wire.loadPasskeys();
        } catch (e) {
            if (e.constructor?.name !== 'UserCancelledError') {
                this.error = e.message || '{{ __('Unable to register passkey.') }}';
            }
        } finally {
            this.loading = false;
        }
    },

    cancel() {
        this.showForm = false;
        this.name = '';
        this.error = null;
    },
}">
    {{-- Unsupported --}}
    <template x-if="!supported">
        <div
            class="flex items-start gap-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3
                   dark:border-amber-500/20 dark:bg-amber-500/10">
            <flux:icon.information-circle class="mt-0.5 size-5 shrink-0 text-amber-600 dark:text-amber-400" />

            <div>
                <flux:text class="text-sm font-medium text-amber-800 dark:text-amber-300">
                    {{ __('Passkeys are not available') }}
                </flux:text>

                <flux:text class="mt-0.5 text-xs leading-5 text-amber-700 dark:text-amber-400">
                    {{ __('Passkeys are not supported in this browser or on this device.') }}
                </flux:text>
            </div>
        </div>
    </template>

    {{-- Supported --}}
    <template x-if="supported">
        <div class="space-y-4">

            {{-- Add button --}}
            <template x-if="!showForm">
                <div
                    class="flex flex-col gap-4 rounded-xl border border-zinc-200 bg-zinc-50 p-4
                           sm:flex-row sm:items-center sm:justify-between
                           dark:border-zinc-700 dark:bg-zinc-800/50">
                    <div class="flex items-start gap-3">
                        <div
                            class="flex size-10 shrink-0 items-center justify-center rounded-xl
                                   bg-emerald-50 text-emerald-600
                                   dark:bg-emerald-500/10 dark:text-emerald-400">
                            <flux:icon.finger-print class="size-5" />
                        </div>

                        <div>
                            <flux:text class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                {{ __('Sign in with a passkey') }}
                            </flux:text>

                            <flux:text class="mt-0.5 text-xs leading-5">
                                {{ __('Use your device, fingerprint, Face ID, or security key to sign in securely.') }}
                            </flux:text>
                        </div>
                    </div>

                    <flux:button variant="primary" icon="plus" x-on:click="showForm = true">
                        {{ __('Add passkey') }}
                    </flux:button>
                </div>
            </template>

            {{-- Register form --}}
            <template x-if="showForm">
                <div
                    class="overflow-hidden rounded-xl border border-emerald-200 bg-emerald-50/50
                           dark:border-emerald-500/20 dark:bg-emerald-500/5">
                    <div class="border-b border-emerald-200 px-4 py-4 dark:border-emerald-500/20">
                        <div class="flex items-start gap-3">
                            <div
                                class="flex size-9 shrink-0 items-center justify-center rounded-lg
                                       bg-emerald-100 text-emerald-600
                                       dark:bg-emerald-500/10 dark:text-emerald-400">
                                <flux:icon.key class="size-4.5" />
                            </div>

                            <div>
                                <flux:text class="font-medium text-zinc-900 dark:text-zinc-100">
                                    {{ __('Add a new passkey') }}
                                </flux:text>

                                <flux:text class="mt-0.5 text-xs leading-5">
                                    {{ __('Choose a name so you can recognize this passkey later.') }}
                                </flux:text>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4 p-4">

                        <div>
                            <flux:input label="{{ __('Passkey name') }}" x-model="name"
                                placeholder="{{ __('e.g., MacBook Pro, iPhone') }}"
                                x-on:keydown.enter.prevent="register()" x-ref="passkeyNameInput" x-init="$nextTick(() => $refs.passkeyNameInput?.focus())"
                                x-bind:disabled="loading" />

                            <flux:text class="mt-1! text-xs">
                                {{ __('For example, MacBook Pro, iPhone, or Windows PC.') }}
                            </flux:text>
                        </div>

                        {{-- Error --}}
                        <div x-show="error" x-cloak x-transition
                            class="flex items-start gap-2 rounded-lg border border-red-200 bg-red-50 px-3 py-2.5
                                   dark:border-red-500/20 dark:bg-red-500/10">
                            <flux:icon.x-circle class="mt-0.5 size-4 shrink-0 text-red-500 dark:text-red-400" />

                            <p x-text="error" class="text-sm text-red-700 dark:text-red-400"></p>
                        </div>

                        {{-- Actions --}}
                        <div class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">

                            <flux:button variant="ghost" x-on:click="cancel()" x-bind:disabled="loading">
                                {{ __('Cancel') }}
                            </flux:button>

                            <flux:button variant="primary" icon="plus" x-on:click="register()"
                                x-bind:disabled="loading || !name.trim()">
                                <span x-show="!loading">
                                    {{ __('Register passkey') }}
                                </span>

                                <span x-show="loading" x-cloak class="flex items-center gap-2">
                                    <flux:icon.arrow-path class="size-4 animate-spin" />
                                    {{ __('Registering...') }}
                                </span>
                            </flux:button>

                        </div>
                    </div>
                </div>
            </template>
        </div>
    </template>
</div>
