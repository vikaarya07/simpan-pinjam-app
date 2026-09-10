@php
    $currentLocale = app()->getLocale();
@endphp

<flux:dropdown position="bottom" align="end">
    <flux:button variant="ghost" size="sm" icon="language" class="uppercase" :aria-label="__('app.language')">
        {{ $currentLocale }}
    </flux:button>

    <flux:menu>
        <flux:menu.item wire:click="changeLocale('id')" icon="{{ $currentLocale === 'id' ? 'check' : 'language' }}">
            Indonesia
        </flux:menu.item>

        <flux:menu.item wire:click="changeLocale('en')" icon="{{ $currentLocale === 'en' ? 'check' : 'language' }}">
            English
        </flux:menu.item>
    </flux:menu>
</flux:dropdown>
