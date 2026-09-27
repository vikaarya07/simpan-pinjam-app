<section class="w-full">

    @include('partials.settings-heading')

    <flux:heading class="sr-only">
        {{ __('app.profile.settings') }}
    </flux:heading>

    <x-settings.layout :heading="__('app.profile.title')" :subheading="__('app.profile.subtitle')">
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
                            {{ __('app.profile.information') }}
                        </flux:heading>

                        <flux:text class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ __('app.profile.information_description') }}
                        </flux:text>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <form wire:submit="updateProfileInformation" class="space-y-6 px-6 py-6">
                <div class="grid gap-6 sm:grid-cols-2">

                    {{-- Name --}}
                    <flux:input wire:model="name" :label="__('app.profile.name')" type="text" required autofocus
                        autocomplete="name" :placeholder="__('app.profile.name_placeholder')" />

                    {{-- Email --}}
                    <div>
                        <flux:input wire:model="email" :label="__('app.profile.email')" type="email"
                            autocomplete="email" :placeholder="__('app.profile.email_placeholder')" disabled />

                        @if ($this->hasUnverifiedEmail)
                            <div
                                class="mt-3 flex items-start gap-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 dark:border-amber-500/20 dark:bg-amber-500/10">
                                <flux:icon.exclamation-triangle
                                    class="mt-0.5 size-5 shrink-0 text-amber-600 dark:text-amber-400" />

                                <div class="min-w-0">
                                    <flux:text class="text-sm font-medium text-amber-800 dark:text-amber-300">
                                        {{ __('app.profile.email_unverified') }}
                                    </flux:text>

                                    <flux:text class="mt-1 text-xs text-amber-700 dark:text-amber-400">
                                        {{ __('app.profile.email_unverified_description') }}
                                    </flux:text>

                                    <flux:link
                                        class="mt-2 inline-block text-xs font-semibold text-amber-700 hover:text-amber-800 dark:text-amber-400 dark:hover:text-amber-300"
                                        wire:click.prevent="resendVerificationNotification">
                                        {{ __('app.profile.resend_verification') }}
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
                            {{ __('app.profile.save_changes') }}
                        </span>

                        <span wire:loading wire:target="updateProfileInformation">
                            {{ __('app.profile.saving') }}
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
