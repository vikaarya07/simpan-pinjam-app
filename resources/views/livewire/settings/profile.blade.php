<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">
        {{ __('Profile settings') }}
    </flux:heading>

    <x-settings.layout :heading="__('Profile')" :subheading="__('Kelola informasi profil dan alamat email Anda.')">
        <div
            class="mt-6 overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

            {{-- Header --}}
            <div class="border-b border-zinc-200 px-6 py-5 dark:border-zinc-700">
                <div class="flex items-center gap-4">
                    <div
                        class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                        <flux:icon.user class="size-5" />
                    </div>

                    <div>
                        <flux:heading size="lg">
                            {{ __('Informasi Profil') }}
                        </flux:heading>

                        <flux:text class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ __('Perbarui nama dan alamat email akun Anda.') }}
                        </flux:text>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <form wire:submit="updateProfileInformation" class="space-y-6 px-6 py-6">
                <div class="grid gap-6 sm:grid-cols-2">

                    {{-- Name --}}
                    <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus
                        autocomplete="name" placeholder="Masukkan nama Anda" />

                    {{-- Email --}}
                    <div>
                        <flux:input wire:model="email" :label="__('Email')" type="email" required
                            autocomplete="email" placeholder="nama@email.com" />

                        @if ($this->hasUnverifiedEmail)
                            <div
                                class="mt-3 flex items-start gap-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 dark:border-amber-500/20 dark:bg-amber-500/10">
                                <flux:icon.exclamation-triangle
                                    class="mt-0.5 size-5 shrink-0 text-amber-600 dark:text-amber-400" />

                                <div class="min-w-0">
                                    <flux:text class="text-sm font-medium text-amber-800 dark:text-amber-300">
                                        {{ __('Alamat email belum diverifikasi.') }}
                                    </flux:text>

                                    <flux:text class="mt-1 text-xs text-amber-700 dark:text-amber-400">
                                        {{ __('Silakan periksa inbox Anda atau kirim ulang email verifikasi.') }}
                                    </flux:text>

                                    <flux:link
                                        class="mt-2 inline-block text-xs font-semibold text-amber-700 hover:text-amber-800 dark:text-amber-400 dark:hover:text-amber-300"
                                        wire:click.prevent="resendVerificationNotification">
                                        {{ __('Kirim ulang email verifikasi') }}
                                    </flux:link>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Footer --}}
                <div
                    class="flex flex-col-reverse gap-3 border-t border-zinc-200 pt-5 sm:flex-row sm:items-center sm:justify-end dark:border-zinc-700">
                    <flux:button variant="primary" type="submit" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="updateProfileInformation">
                            {{ __('Save changes') }}
                        </span>

                        <span wire:loading wire:target="updateProfileInformation">
                            {{ __('Saving...') }}
                        </span>
                    </flux:button>
                </div>
            </form>
        </div>

        {{-- Delete Account --}}
        @if ($this->showDeleteUser)
            <div class="mt-6">
                <livewire:settings.delete-user-form />
            </div>
        @endif
    </x-settings.layout>

</section>
