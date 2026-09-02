<div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900"
    wire:cloak x-data="{ showRecoveryCodes: false }">
    {{-- Header --}}
    <div class="border-b border-zinc-200 px-6 py-5 dark:border-zinc-700">
        <div class="flex items-start gap-4">

            <div
                class="flex size-10 shrink-0 items-center justify-center rounded-xl
                   bg-zinc-100 text-zinc-600
                   dark:bg-zinc-800 dark:text-zinc-300">
                <flux:icon.lock-closed variant="outline" class="size-5" />
            </div>

            <div class="min-w-0">
                <flux:heading size="lg" level="3">
                    {{ __('2FA recovery codes') }}
                </flux:heading>

                <flux:text variant="subtle" class="mt-1 text-sm leading-5">
                    {{ __('Recovery codes let you regain access if you lose your 2FA device. Store them in a secure password manager.') }}
                </flux:text>
            </div>

        </div>
    </div>

    {{-- Content --}}
    <div class="px-6 py-5">

        {{-- Actions --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

            <flux:text x-show="!showRecoveryCodes" variant="subtle" class="text-sm">
                {{ __('Keep your recovery codes somewhere safe.') }}
            </flux:text>

            <div class="flex flex-col gap-2 sm:flex-row">

                {{-- View --}}
                <flux:button x-show="!showRecoveryCodes" icon="eye" icon:variant="outline" variant="primary"
                    @click="showRecoveryCodes = true" aria-expanded="false" aria-controls="recovery-codes-section">
                    {{ __('View recovery codes') }}
                </flux:button>

                {{-- Hide --}}
                <flux:button x-show="showRecoveryCodes" icon="eye-slash" icon:variant="outline" variant="primary"
                    @click="showRecoveryCodes = false" aria-expanded="true" aria-controls="recovery-codes-section">
                    {{ __('Hide recovery codes') }}
                </flux:button>

                {{-- Regenerate --}}
                @if (filled($recoveryCodes))
                    <flux:button x-show="showRecoveryCodes" icon="arrow-path" variant="filled"
                        wire:click="regenerateRecoveryCodes" wire:loading.attr="disabled"
                        wire:target="regenerateRecoveryCodes">
                        <span wire:loading.remove wire:target="regenerateRecoveryCodes">
                            {{ __('Regenerate codes') }}
                        </span>

                        <span wire:loading wire:target="regenerateRecoveryCodes">
                            {{ __('Regenerating...') }}
                        </span>
                    </flux:button>
                @endif

            </div>

        </div>

        {{-- Recovery Codes --}}
        <div x-show="showRecoveryCodes" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2" id="recovery-codes-section"
            class="relative overflow-hidden" x-bind:aria-hidden="!showRecoveryCodes">

            <div class="mt-5 space-y-4">

                {{-- Error --}}
                @error('recoveryCodes')
                    <flux:callout variant="danger" icon="x-circle" heading="{{ $message }}" />
                @enderror

                @if (filled($recoveryCodes))

                    {{-- Codes --}}
                    <div
                        class="rounded-xl border border-zinc-200 bg-zinc-50 p-4
                           dark:border-zinc-700 dark:bg-zinc-800/50">
                        <div class="grid grid-cols-2 gap-2 sm:grid-cols-4" role="list"
                            aria-label="{{ __('Recovery codes') }}">
                            @foreach ($recoveryCodes as $code)
                                <div role="listitem" wire:loading.class="opacity-50 animate-pulse"
                                    class="flex min-h-10 items-center justify-center
                                       rounded-lg border border-zinc-200 bg-white
                                       px-3 py-2 font-mono text-sm font-medium
                                       tracking-wide text-zinc-800 select-text
                                       dark:border-zinc-700 dark:bg-zinc-900
                                       dark:text-zinc-200">
                                    {{ $code }}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Information --}}
                    <div
                        class="flex items-start gap-3 rounded-xl border border-amber-200
                           bg-amber-50 px-4 py-3
                           dark:border-amber-500/20 dark:bg-amber-500/10">
                        <flux:icon.information-circle
                            class="mt-0.5 size-5 shrink-0 text-amber-600
                               dark:text-amber-400" />

                        <flux:text variant="subtle"
                            class="text-xs leading-5 text-amber-700
                               dark:text-amber-400">
                            {{ __('Each recovery code can be used once to access your account and will be removed after use. If you need more, click Regenerate codes above.') }}
                        </flux:text>
                    </div>

                @endif

            </div>

        </div>

    </div>

</div>
