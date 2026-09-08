<div class="space-y-5">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <flux:heading size="xl">
                {{ __('app.loan.title') }}
            </flux:heading>

            <flux:text class="mt-1">
                {{ __('app.loan.subtitle') }}
            </flux:text>
        </div>

        <flux:button variant="primary" icon="plus" wire:click="create">
            {{ __('app.actions.create') . ' ' . __('app.loan.singular') }}
        </flux:button>

    </div>

    {{-- Search --}}
    <flux:card class="p-4 border-none!">

        <div class="max-w-xl">

            <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass"
                placeholder="{{ __('app.loan.search') }}" />

        </div>

    </flux:card>

    {{-- Table --}}
    <flux:card class="overflow-hidden border-none!">

        <flux:table>

            <flux:table.columns>

                <flux:table.column class="w-12">#</flux:table.column>

                {{-- Nomor Pinjaman --}}
                <flux:table.column class="cursor-pointer" wire:click="sortBy('loan_number')">
                    <div class="flex items-center gap-1">
                        {{ __('app.loan.loan_number') }}
                        @include('components.sort-icon', ['field' => 'loan_number'])
                    </div>
                </flux:table.column>

                <flux:table.column>{{ __('app.loan.name') }}</flux:table.column>

                {{-- Waktu --}}
                <flux:table.column class="cursor-pointer" wire:click="sortBy('loan_date')">
                    <div class="flex items-center gap-1">
                        {{ __('app.loan.date') }}
                        @include('components.sort-icon', ['field' => 'loan_date'])
                    </div>
                </flux:table.column>

                {{-- Jenis --}}
                <flux:table.column class="cursor-pointer" wire:click="sortBy('type')">
                    <div class="flex items-center gap-1">
                        {{ __('app.loan.type') }}
                        @include('components.sort-icon', ['field' => 'type'])
                    </div>
                </flux:table.column>

                {{-- Pokok --}}
                <flux:table.column class="cursor-pointer text-right" wire:click="sortBy('principal')">
                    <div class="flex items-center justify-end gap-1">
                        {{ __('app.loan.principal') }}
                        @include('components.sort-icon', ['field' => 'principal'])
                    </div>
                </flux:table.column>

                <flux:table.column class="text-right">{{ __('app.loan.interest') }}</flux:table.column>

                <flux:table.column class="text-right">{{ __('app.loan.interest_amount') }}</flux:table.column>

                <flux:table.column class="text-right">{{ __('app.loan.amount') }}</flux:table.column>

                {{-- Remaining --}}
                <flux:table.column class="cursor-pointer text-right" wire:click="sortBy('remaining')">
                    <div class="flex items-center justify-end gap-1">
                        {{ __('app.loan.remaining') }}
                        @include('components.sort-icon', ['field' => 'remaining'])
                    </div>
                </flux:table.column>

                {{-- Status --}}
                <flux:table.column class="cursor-pointer" wire:click="sortBy('status')">
                    <div class="flex items-center gap-1">
                        {{ __('app.loan.status') }}
                        @include('components.sort-icon', ['field' => 'status'])
                    </div>
                </flux:table.column>

                <flux:table.column class="text-right">{{ __('app.action') }}</flux:table.column>

            </flux:table.columns>

            <flux:table.rows>

                @forelse($loans as $loan)
                    <flux:table.row wire:key="loan-{{ $loan->id }}"
                        class="transition hover:bg-zinc-50 dark:hover:bg-zinc-800/50">

                        {{-- No --}}
                        <flux:table.cell class="text-zinc-500">
                            {{ $loans->firstItem() + $loop->index }}
                        </flux:table.cell>

                        {{-- Nomor Pinjaman --}}
                        <flux:table.cell>
                            <div class="whitespace-nowrap font-medium">
                                {{ $loan->loan_number }}
                            </div>
                        </flux:table.cell>

                        {{-- Nasabah --}}
                        <flux:table.cell>
                            <div class="font-medium whitespace-nowrap">
                                {{ $loan->member->name }}
                            </div>
                        </flux:table.cell>

                        {{-- Waktu --}}
                        <flux:table.cell>
                            <div class="flex items-center gap-2 whitespace-nowrap">
                                <flux:icon name="calendar-days" class="size-4 text-zinc-400" />
                                <span>
                                    {{ $loan->waktu }}
                                </span>
                            </div>
                        </flux:table.cell>

                        {{-- Jenis --}}
                        <flux:table.cell>
                            <flux:badge :color="$loan->type->color()" size="sm">
                                {{ $loan->type->label() }}
                            </flux:badge>
                        </flux:table.cell>

                        {{-- Pinjaman --}}
                        <flux:table.cell class="text-right">
                            <span class="font-medium tabular-nums whitespace-nowrap">
                                {{ idr($loan->principal) }}
                            </span>
                        </flux:table.cell>

                        {{-- Jasa --}}
                        <flux:table.cell class="text-right">
                            <span class="font-medium tabular-nums whitespace-nowrap">
                                {{ $loan->interest_percent }}%
                            </span>
                        </flux:table.cell>

                        {{-- Nominal Jasa --}}
                        <flux:table.cell class="text-right">
                            <span class="tabular-nums whitespace-nowrap">
                                {{ idr($loan->interest_amount) }}
                            </span>
                        </flux:table.cell>

                        {{-- Total --}}
                        <flux:table.cell class="text-right">
                            <span class="font-semibold tabular-nums whitespace-nowrap">
                                {{ idr($loan->amount) }}
                            </span>
                        </flux:table.cell>

                        {{-- Remaining --}}
                        <flux:table.cell class="text-right">
                            <span
                                class="font-semibold tabular-nums whitespace-nowrap {{ $loan->remaining > 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                {{ idr($loan->remaining) }}
                            </span>
                        </flux:table.cell>

                        {{-- Status --}}
                        <flux:table.cell>
                            <flux:badge :color="$loan->status->color()" size="sm">
                                {{ $loan->status->label() }}
                            </flux:badge>
                        </flux:table.cell>

                        {{-- Aksi --}}
                        <flux:table.cell>
                            <div class="flex justify-end gap-1">
                                <flux:button size="sm" variant="ghost" icon="pencil-square"
                                    wire:click="edit('{{ $loan->id }}')" tooltip="{{ __('app.actions.edit') . ' ' . __('app.loan.singular') }}" />
                                <flux:button size="sm" variant="ghost" icon="trash"
                                    class="text-red-500 hover:text-red-600"
                                    wire:click="confirmDelete('{{ $loan->id }}')" tooltip="{{ __('app.actions.delete') . ' ' . __('app.loan.singular') }}" />
                            </div>
                        </flux:table.cell>

                    </flux:table.row>

                @empty

                    <flux:table.row>

                        <flux:table.cell colspan="12">

                            <div class="flex flex-col items-center justify-center py-12 text-center">

                                <flux:icon name="banknotes" class="size-10 text-zinc-400" />

                                <flux:heading size="sm" class="mt-3">
                                    {{ __('app.loan.empty') }}
                                </flux:heading>

                                <flux:text class="mt-1">
                                    {{ __('app.loan.empty_description') }}
                                </flux:text>

                                <flux:button class="mt-4" variant="primary" icon="plus" wire:click="create">
                                    {{ __('app.loan.create') }}
                                </flux:button>

                            </div>

                        </flux:table.cell>

                    </flux:table.row>
                @endforelse

            </flux:table.rows>

        </flux:table>

    </flux:card>

    {{-- Pagination --}}
    <div>
        {{ $loans->links() }}
    </div>

    {{-- Form --}}
    <livewire:loan.form />

</div>
