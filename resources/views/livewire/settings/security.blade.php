<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">
        {{ __('Security settings') }}
    </flux:heading>

    <x-settings.layout :heading="__('Security')" :subheading="__('Kelola password dan keamanan akun Anda.')">

        {{-- PASSWORD --}}
        <div
            class="mt-6 overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

            {{-- Header --}}
            <div class="border-b border-zinc-200 px-6 py-5 dark:border-zinc-700">
                <div class="flex items-center gap-4">
                    <div
                        class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                        <flux:icon.lock-closed class="size-5" />
                    </div>

                    <div>
                        <flux:heading size="lg">
                            {{ __('Password') }}
                        </flux:heading>

                        <flux:text class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ __('Gunakan password yang kuat dan unik untuk menjaga keamanan akun.') }}
                        </flux:text>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <form method="POST" wire:submit="updatePassword" class="space-y-6 px-6 py-6">
                <div class="grid gap-6 sm:grid-cols-2">

                    <flux:input wire:model="current_password" :label="__('Current password')" type="password" required
                        autocomplete="current-password" viewable />

                    <flux:input wire:model="password" :label="__('New password')" type="password" required
                        autocomplete="new-password"
                        passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                        viewable />

                    <div class="sm:col-span-2">
                        <div class="max-w-xl">
                            <flux:input wire:model="password_confirmation" :label="__('Confirm password')"
                                type="password" required autocomplete="new-password"
                                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                                viewable />
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end border-t border-zinc-200 pt-5 dark:border-zinc-700">
                    <flux:button variant="primary" type="submit" data-test="update-password-button"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="updatePassword">
                            {{ __('Save changes') }}
                        </span>

                        <span wire:loading wire:target="updatePassword">
                            {{ __('Saving...') }}
                        </span>
                    </flux:button>
                </div>
            </form>
        </div>

        {{-- TWO FACTOR AUTHENTICATION --}}
        @if ($canManageTwoFactor)
            <div
                class="mt-6 overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

                {{-- Header --}}
                <div class="border-b border-zinc-200 px-6 py-5 dark:border-zinc-700">
                    <div class="flex items-center gap-4">
                        <div
                            class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                            <flux:icon.shield-check class="size-5" />
                        </div>

                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <flux:heading size="lg">
                                    {{ __('Two-factor authentication') }}
                                </flux:heading>

                                @if ($twoFactorEnabled)
                                    <flux:badge color="green" size="sm">
                                        {{ __('Enabled') }}
                                    </flux:badge>
                                @else
                                    <flux:badge size="sm">
                                        {{ __('Disabled') }}
                                    </flux:badge>
                                @endif
                            </div>

                            <flux:text class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                {{ __('Tambahkan lapisan keamanan ekstra saat login.') }}
                            </flux:text>
                        </div>
                    </div>
                </div>

                {{-- Content --}}
                <div class="px-6 py-6" wire:cloak>
                    @if ($twoFactorEnabled)
                        <div class="space-y-5">

                            <div
                                class="flex items-start gap-4 rounded-xl border border-emerald-200 bg-emerald-50 p-4 dark:border-emerald-500/20 dark:bg-emerald-500/10">
                                <div
                                    class="mt-0.5 flex size-9 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400">
                                    <flux:icon.shield-check class="size-5" />
                                </div>

                                <div>
                                    <flux:text class="font-medium text-emerald-800 dark:text-emerald-300">
                                        {{ __('Two-factor authentication is active') }}
                                    </flux:text>

                                    <flux:text class="mt-1 text-sm text-emerald-700 dark:text-emerald-400">
                                        {{ __('A secure verification code will be required when you sign in. You can retrieve the code from your TOTP-supported application.') }}
                                    </flux:text>
                                </div>
                            </div>

                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <flux:text class="font-medium">
                                        {{ __('Authenticator app') }}
                                    </flux:text>

                                    <flux:text class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ __('Your account is protected with an authenticator application.') }}
                                    </flux:text>
                                </div>

                                <flux:button variant="danger" wire:click="disable">
                                    {{ __('Disable 2FA') }}
                                </flux:button>
                            </div>

                            <div class="border-t border-zinc-200 pt-5 dark:border-zinc-700">
                                <livewire:settings.two-factor.recovery-codes :$requiresConfirmation />
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                            <div class="flex items-start gap-4">
                                <div
                                    class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-zinc-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                                    <flux:icon.shield-exclamation class="size-5" />
                                </div>

                                <div>
                                    <flux:text class="font-medium">
                                        {{ __('Protect your account') }}
                                    </flux:text>

                                    <flux:text class="mt-1 max-w-2xl text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ __('When enabled, you will be prompted for a secure verification code during login. The code can be retrieved from a TOTP-supported application.') }}
                                    </flux:text>
                                </div>
                            </div>

                            <flux:button variant="primary" wire:click="enable">
                                {{ __('Enable 2FA') }}
                            </flux:button>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- TWO FACTOR SETUP MODAL --}}
        @if ($canManageTwoFactor)

            <flux:modal name="two-factor-setup-modal" class="max-w-md md:min-w-md" @close="closeModal"
                wire:model="showModal">

                <div class="space-y-6">

                    {{-- Modal Header --}}
                    <div class="flex flex-col items-center text-center">

                        <div
                            class="mb-4 flex size-14 items-center justify-center rounded-2xl border border-zinc-200 bg-zinc-50 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
                            <flux:icon.qr-code class="size-7 text-zinc-600 dark:text-zinc-300" />
                        </div>

                        <flux:heading size="lg">
                            {{ $this->modalConfig['title'] }}
                        </flux:heading>

                        <flux:text class="mt-2 max-w-sm">
                            {{ $this->modalConfig['description'] }}
                        </flux:text>

                    </div>

                    @if ($showVerificationStep)
                        {{-- OTP --}}
                        <div class="space-y-6">

                            <div x-data x-init="$nextTick(() => $el.querySelector('input')?.focus())"
                                class="flex flex-col items-center justify-center space-y-3">
                                <flux:otp name="code" wire:model="code" length="6" label="OTP Code" label:sr-only
                                    class="mx-auto" />
                            </div>

                            <div class="flex items-center gap-3">

                                <flux:button variant="outline" class="flex-1" wire:click="resetVerification">
                                    {{ __('Back') }}
                                </flux:button>

                                <flux:button variant="primary" class="flex-1" wire:click="confirmTwoFactor"
                                    x-bind:disabled="($wire.code ?? '').length < 6">
                                    {{ __('Confirm') }}
                                </flux:button>

                            </div>

                        </div>
                    @else
                        @error('setupData')
                            <flux:callout variant="danger" icon="x-circle" heading="{{ $message }}" />
                        @enderror

                        {{-- QR Code --}}
                        <div class="flex justify-center">
                            <div
                                class="relative aspect-square w-64 overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700">
                                @if (empty($qrCodeSvg))
                                    <div
                                        class="absolute inset-0 flex items-center justify-center bg-white dark:bg-zinc-800">
                                        <flux:icon.loading />
                                    </div>
                                @else
                                    <div x-data class="flex h-full items-center justify-center p-5">
                                        <div class="rounded-xl bg-white p-3"
                                            :style="($flux.appearance === 'dark' || ($flux.appearance === 'system' &&
                                                $flux.dark)) ?
                                            'filter: invert(1) brightness(1.5)' : ''">
                                            {!! $qrCodeSvg !!}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Continue --}}
                        <flux:button :disabled="$errors->has('setupData')" variant="primary" class="w-full"
                            wire:click="showVerificationIfNecessary">
                            {{ $this->modalConfig['buttonText'] }}
                        </flux:button>

                        {{-- Manual Code --}}
                        <div class="space-y-4">

                            <div class="flex items-center gap-3">

                                <div class="h-px flex-1 bg-zinc-200 dark:bg-zinc-700"></div>

                                <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">
                                    {{ __('or, enter the code manually') }}
                                </span>

                                <div class="h-px flex-1 bg-zinc-200 dark:bg-zinc-700"></div>

                            </div>

                            <div x-data="{
                                copied: false,
                            
                                async copy() {
                                    try {
                                        await navigator.clipboard.writeText('{{ $manualSetupKey }}');
                            
                                        this.copied = true;
                            
                                        setTimeout(() => {
                                            this.copied = false;
                                        }, 1500);
                                    } catch (e) {
                                        console.warn('Could not copy to clipboard');
                                    }
                                }
                            }"
                                class="flex items-center overflow-hidden rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800">

                                @if (empty($manualSetupKey))
                                    <div class="flex w-full items-center justify-center p-3">
                                        <flux:icon.loading variant="mini" />
                                    </div>
                                @else
                                    <input type="text" readonly value="{{ $manualSetupKey }}"
                                        class="min-w-0 flex-1 bg-transparent p-3 font-mono text-sm text-zinc-900 outline-none dark:text-zinc-100" />

                                    <button type="button" @click="copy()"
                                        class="flex size-11 shrink-0 cursor-pointer items-center justify-center border-l border-zinc-200 transition hover:bg-zinc-100 dark:border-zinc-700 dark:hover:bg-zinc-700">
                                        <flux:icon.document-duplicate x-show="!copied" variant="outline"
                                            class="size-5" />

                                        <flux:icon.check x-show="copied" variant="solid"
                                            class="size-5 text-emerald-500" />
                                    </button>
                                @endif

                            </div>

                        </div>
                    @endif

                </div>

            </flux:modal>

        @endif

        {{-- PASSKEYS --}}
        @if ($canManagePasskeys)
            <div
                class="mt-6 overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

                {{-- Header --}}
                <div class="border-b border-zinc-200 px-6 py-5 dark:border-zinc-700">
                    <div class="flex items-center gap-4">
                        <div
                            class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                            <flux:icon.key class="size-5" />
                        </div>

                        <div>
                            <flux:heading size="lg">
                                {{ __('Passkeys') }}
                            </flux:heading>

                            <flux:text class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                {{ __('Gunakan passkey untuk login tanpa password.') }}
                            </flux:text>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-6" wire:cloak>

                    {{-- Passkey List --}}
                    <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-700">

                        @forelse ($passkeys as $passkey)
                            <div
                                class="flex items-center justify-between gap-4 p-4 {{ !$loop->last ? 'border-b border-zinc-200 dark:border-zinc-700' : '' }}">

                                <div class="flex min-w-0 items-center gap-4">

                                    <div
                                        class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-zinc-100 dark:bg-zinc-800">
                                        <flux:icon.key class="size-5 text-zinc-500 dark:text-zinc-400" />
                                    </div>

                                    <div class="min-w-0 space-y-1">
                                        <div class="flex flex-wrap items-center gap-2">

                                            <p class="truncate font-medium tracking-tight">
                                                {{ $passkey['name'] }}
                                            </p>

                                            @if ($passkey['authenticator'])
                                                <flux:badge size="sm">
                                                    {{ $passkey['authenticator'] }}
                                                </flux:badge>
                                            @endif

                                        </div>

                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                            {{ __('Added :time', ['time' => $passkey['created_at_diff']]) }}

                                            @if ($passkey['last_used_at_diff'])
                                                <span class="mx-1 opacity-50">•</span>
                                                {{ __('Last used :time', ['time' => $passkey['last_used_at_diff']]) }}
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <flux:button variant="ghost" size="sm" icon="trash" icon:variant="outline"
                                    wire:click="confirmDelete({{ $passkey['id'] }})"
                                    class="shrink-0 text-red-500 hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-950/50" />
                            </div>

                        @empty

                            <div class="px-6 py-10 text-center">

                                <div
                                    class="mx-auto mb-4 flex size-14 items-center justify-center rounded-2xl bg-zinc-100 dark:bg-zinc-800">
                                    <flux:icon.key class="size-7 text-zinc-400 dark:text-zinc-500" />
                                </div>

                                <flux:text class="font-medium text-zinc-800 dark:text-zinc-200">
                                    {{ __('No passkeys yet') }}
                                </flux:text>

                                <flux:text class="mt-1 text-sm">
                                    {{ __('Add a passkey to sign in without a password') }}
                                </flux:text>

                            </div>
                        @endforelse

                    </div>

                    {{-- Register Passkey --}}
                    <div class="mt-5">
                        <x-passkey-registration />
                    </div>

                </div>
            </div>
        @endif

    </x-settings.layout>

    {{-- DELETE PASSKEY MODAL --}}
    <flux:modal name="delete-passkey-modal" class="max-w-md md:min-w-md" @close="closeDeleteModal"
        wire:model="showDeleteModal">
        <div class="space-y-6">

            <div class="flex items-start gap-4">
                <div
                    class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-600 dark:bg-red-500/10 dark:text-red-400">
                    <flux:icon.trash class="size-5" />
                </div>

                <div class="space-y-2">
                    <flux:heading size="lg">
                        {{ __('Remove passkey') }}
                    </flux:heading>

                    <flux:text>
                        {{ __('Are you sure you want to remove the passkey ":name"? You will no longer be able to use it to sign in.', ['name' => $deletingPasskeyName]) }}
                    </flux:text>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <flux:button variant="outline" wire:click="closeDeleteModal">
                    {{ __('Cancel') }}
                </flux:button>

                <flux:button variant="danger" wire:click="deletePasskey">
                    {{ __('Remove passkey') }}
                </flux:button>
            </div>

        </div>
    </flux:modal>

</section>
