<div class="flex items-center justify-center gap-1 rounded-lg px-2 py-1">

    {{-- Indonesia --}}
    <button type="button" wire:click="changeLocale('id')" @disabled($locale === 'id')
        class="flex items-center gap-2 rounded-md px-2 py-1 text-sm font-medium transition
            {{ $locale === 'id'
                ? 'bg-emerald-400! text-emerald-50!'
                : 'text-slate-600! hover:bg-slate-100! dark:text-slate-300! dark:hover:bg-slate-800!' }}">
        ID
        <flux:flag country="ID" class="w-5" />
    </button>

    <span class="text-slate-300 dark:text-slate-600">|</span>

    {{-- English --}}
    <button type="button" wire:click="changeLocale('en')" @disabled($locale === 'en')
        class="flex items-center gap-2 rounded-md px-2 py-1 text-sm font-medium transition
            {{ $locale === 'en'
                ? 'bg-emerald-400! text-emerald-50!'
                : 'text-slate-600! hover:bg-slate-100! dark:text-slate-300! dark:hover:bg-slate-800!' }}">
        EN
        <flux:flag country="US" class="w-5" />
    </button>
</div>
