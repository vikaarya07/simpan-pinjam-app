<section class="w-full">

    @include('partials.settings-heading')

    <flux:heading class="sr-only">
        {{ __('app.appearance.settings') }}
    </flux:heading>

    <x-settings.layout :heading="__('app.appearance.title')" :subheading="__('app.appearance.subtitle')">
        <div
            class="mt-6 overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            {{-- Header --}}
            <div class="border-b border-zinc-200 px-6 py-5 dark:border-zinc-700">
                <div class="flex items-center gap-4">
                    <div
                        class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                        <flux:icon.paint-brush class="size-5" />
                    </div>

                    <div>
                        <flux:heading size="lg">
                            {{ __('app.appearance.information') }}
                        </flux:heading>

                        <flux:text class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ __('app.appearance.information_description') }}
                        </flux:text>
                    </div>
                </div>
            </div>

            {{-- Appearance Options --}}
            <div class="px-6 py-6">
                <div class="space-y-4">
                    <div>
                        <flux:text class="text-sm font-medium text-zinc-800 dark:text-zinc-200">
                            {{ __('app.appearance.mode') }}
                        </flux:text>

                        <flux:text class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                            {{ __('app.appearance.mode_description') }}
                        </flux:text>
                    </div>

                    <flux:radio.group x-data variant="segmented" x-model="$flux.appearance" class="w-full sm:w-fit">
                        <flux:radio value="light" icon="sun">
                            {{ __('app.appearance.light') }}
                        </flux:radio>

                        <flux:radio value="dark" icon="moon">
                            {{ __('app.appearance.dark') }}
                        </flux:radio>

                        <flux:radio value="system" icon="computer-desktop">
                            {{ __('app.appearance.system') }}
                        </flux:radio>
                    </flux:radio.group>
                </div>
            </div>
        </div>
    </x-settings.layout>

</section>
