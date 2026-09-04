@props([
    'target' => null,
    'loadingText' => 'Processing...',
])

<flux:button {{ $attributes }} type="submit" wire:loading.attr="disabled" wire:target="{{ $target }}">
    <flux:icon.loading wire:loading wire:target="{{ $target }}" class="size-4" />

    <span wire:loading.remove wire:target="{{ $target }}">
        {{ $slot }}
    </span>

    <span wire:loading wire:target="{{ $target }}">
        {{ $loadingText }}
    </span>
</flux:button>
