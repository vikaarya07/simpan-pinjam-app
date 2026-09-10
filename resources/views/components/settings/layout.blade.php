<div class="flex items-start max-md:flex-col">

    {{-- Settings Navigation --}}
    <div
        class="me-10 w-full rounded-2xl border border-zinc-200 bg-white p-2
               shadow-sm dark:border-zinc-700 dark:bg-zinc-900
               md:sticky md:top-6 md:w-55">

        <div class="px-3 pb-2 pt-2">
            <flux:text
                class="text-xs font-semibold uppercase tracking-wider
                       text-zinc-400 dark:text-zinc-500">
                {{ __('app.profile.settings') }}
            </flux:text>
        </div>

        <flux:navlist :aria-label="__('app.profile.settings')" class="space-y-1">

            <flux:navlist.item :href="route('profile.edit')" wire:navigate icon="user"
                :current="request()->routeIs('profile.*')">
                {{ __('app.profile.title') }}
            </flux:navlist.item>

            <flux:navlist.item :href="route('security.edit')" wire:navigate icon="shield-check"
                :current="request()->routeIs('security.*')">
                {{ __('app.security.title') }}
            </flux:navlist.item>

            <flux:navlist.item :href="route('appearance.edit')" wire:navigate icon="swatch"
                :current="request()->routeIs('appearance.*')">
                {{ __('app.appearance.title') }}
            </flux:navlist.item>

        </flux:navlist>
    </div>

    <flux:separator class="md:hidden" />

    {{-- Content --}}
    <div class="max-w-xl flex-1 max-md:pt-6">

        <flux:heading>
            {{ $heading ?? '' }}
        </flux:heading>

        <flux:subheading>
            {{ $subheading ?? '' }}
        </flux:subheading>

        <div class="mt-5 w-full">
            {{ $slot }}
        </div>

    </div>

</div>