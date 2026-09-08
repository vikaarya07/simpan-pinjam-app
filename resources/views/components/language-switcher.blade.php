@php
    $locale = app()->getLocale();
@endphp

<flux:dropdown position="bottom" align="end">
    <flux:button variant="ghost" size="sm" icon="language" :aria-label="__('app.language')">
        {{ strtoupper($locale) }}
    </flux:button>

    <flux:menu>
        <flux:menu.item wire:click="changeLocale('id')" icon="check" :disabled="$locale === 'id'">
            Indonesia
        </flux:menu.item>

        <flux:menu.item wire:click="changeLocale('en')" icon="check" :disabled="$locale === 'en'">
            English
        </flux:menu.item>
    </flux:menu>
</flux:dropdown>