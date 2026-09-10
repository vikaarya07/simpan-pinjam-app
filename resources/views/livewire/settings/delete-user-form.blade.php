<section class="my-6">

    <div
        class="overflow-hidden rounded-2xl border border-red-200 bg-white shadow-sm dark:border-red-500/20 dark:bg-zinc-900">
        {{-- Header --}}
        <div class="border-b border-red-100 bg-red-50/50 px-6 py-5 dark:border-red-500/10 dark:bg-red-500/5">
            <div class="flex items-center gap-4">
                <div
                    class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600 dark:bg-red-500/10 dark:text-red-400">
                    <flux:icon.trash class="size-5" />
                </div>

                <div class="min-w-0">
                    <flux:heading size="lg">
                        {{ __('app.delete_account.title') }}
                    </flux:heading>

                    <flux:text class="mt-1 text-sm text-red-700/80 dark:text-red-400/80">
                        {{ __('app.delete_account.description') }}
                    </flux:text>
                </div>
            </div>
        </div>

        {{-- Content --}}
        <div class="px-6 py-6">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                <div class="max-w-2xl">
                    <flux:text class="font-medium">
                        {{ __('app.delete_account.permanently_delete') }}
                    </flux:text>

                    <flux:text class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                        {{ __('app.delete_account.permanently_delete_description') }}
                    </flux:text>
                </div>

                {{-- Trigger --}}
                <flux:modal.trigger name="confirm-user-deletion">
                    <flux:button variant="danger" x-data
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="shrink-0">
                        <flux:icon.trash class="size-4" />
                        {{ __('app.delete_account.delete') }}
                    </flux:button>
                </flux:modal.trigger>
            </div>
        </div>
    </div>

    {{-- CONFIRM DELETE MODAL --}}
    <flux:modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable class="max-w-lg">
        <form method="POST" wire:submit="deleteUser" class="space-y-6">

            {{-- Modal Header --}}
            <div class="flex items-start gap-4">
                <div
                    class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600 dark:bg-red-500/10 dark:text-red-400">
                    <flux:icon.trash class="size-5" />
                </div>

                <div class="min-w-0">
                    <flux:heading size="lg">
                        {{ __('app.delete_account.confirm_title') }}
                    </flux:heading>

                    <flux:subheading class="mt-2">
                        {{ __('app.delete_account.confirm_description') }}
                    </flux:subheading>
                </div>
            </div>

            {{-- Warning --}}
            <div
                class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 dark:border-red-500/20 dark:bg-red-500/10">
                <flux:icon.exclamation-triangle class="mt-0.5 size-5 shrink-0 text-red-600 dark:text-red-400" />

                <flux:text class="text-sm text-red-700 dark:text-red-400">
                    {{ __('app.delete_account.warning') }}
                </flux:text>
            </div>

            {{-- Password --}}
            <flux:input wire:model="password" :label="__('app.delete_account.password')" type="password" viewable
                autocomplete="current-password" autofocus />

            {{-- Actions --}}
            <div
                class="flex flex-col-reverse gap-3 border-t border-zinc-200 pt-5 sm:flex-row sm:justify-end dark:border-zinc-700">
                <flux:modal.close>
                    <flux:button variant="filled" type="button" class="w-full sm:w-auto">
                        {{ __('app.delete_account.cancel') }}
                    </flux:button>
                </flux:modal.close>

                <flux:button variant="danger" type="submit" wire:loading.attr="disabled" wire:target="deleteUser"
                    class="w-full sm:w-auto">
                    <span wire:loading.remove wire:target="deleteUser">
                        {{ __('app.delete_account.delete') }}
                    </span>

                    <span wire:loading wire:target="deleteUser">
                        {{ __('app.delete_account.deleting') }}
                    </span>
                </flux:button>
            </div>

        </form>
    </flux:modal>

</section>