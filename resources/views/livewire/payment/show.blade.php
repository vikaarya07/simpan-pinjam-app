<div class="space-y-5">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <flux:heading size="xl">
                {{ __('app.payment.show.title') }}
            </flux:heading>

            <flux:text class="mt-1">
                {{ __('app.payment.show.subtitle') }}
            </flux:text>
        </div>

        {{-- Meeting Info --}}
        <flux:card class="flex items-center gap-3 border-none! px-4 py-3">
            <div
                class="flex size-9 shrink-0 items-center justify-center rounded-lg bg-zinc-100 text-zinc-500 dark:bg-zinc-800">
                <flux:icon name="calendar-days" class="size-5" />
            </div>

            <div class="min-w-0 leading-tight">
                <flux:text size="xs">
                    {{ __('app.payment.show.meet') }}
                </flux:text>

                <div class="mt-0.5 flex flex-wrap items-center gap-2 text-sm font-semibold">
                    <span>{{ $meeting->place }}</span>
                    <span class="text-zinc-300 dark:text-zinc-600">•</span>
                    <span>{{ $meeting->waktu }}</span>
                </div>
            </div>
        </flux:card>

    </div>

    {{-- Payment Table --}}
    <flux:card class="overflow-hidden border-none!">

        {{-- Table Header --}}
        <div
            class="mb-4 flex flex-col gap-3 border-b border-zinc-200 pb-2 sm:flex-row sm:items-center sm:justify-between dark:border-zinc-700">
            <div>
                <flux:heading size="sm">
                    {{ __('app.payment.show.information') }}
                </flux:heading>

                <flux:text size="sm" class="mt-1">
                    {{ __('app.payment.show.information_description') }}
                </flux:text>
            </div>

            <flux:badge color="zinc" size="sm">
                {{ $loans->total() }} {{ __('app.payment.show.loan') }}
            </flux:badge>
        </div>

        <flux:table>

            <flux:table.columns>

                {{-- # --}}
                <flux:table.column class="w-12">
                    #
                </flux:table.column>

                {{-- Loan Number --}}
                <flux:table.column class="cursor-pointer" wire:click="sortBy('loan_number')">
                    <div class="flex items-center gap-1">
                        {{ __('app.payment.show.loan_number') }}

                        @include('components.sort-icon', [
                            'field' => 'loan_number',
                        ])
                    </div>
                </flux:table.column>

                {{-- Customer --}}
                <flux:table.column>
                    {{ __('app.payment.show.name') }}
                </flux:table.column>

                {{-- Payment --}}
                <flux:table.column>
                    {{ __('app.payment.show.payment_number') }}
                </flux:table.column>

                {{-- Amount --}}
                <flux:table.column>
                    {{ __('app.payment.show.amount') }}
                </flux:table.column>

                {{-- Date --}}
                <flux:table.column class="cursor-pointer" wire:click="sortBy('loan_date')">
                    <div class="flex items-center gap-1">
                        {{ __('app.payment.show.date') }}

                        @include('components.sort-icon', [
                            'field' => 'loan_date',
                        ])
                    </div>
                </flux:table.column>

                {{-- Method --}}
                <flux:table.column>
                    {{ __('app.payment.show.method') }}
                </flux:table.column>

                {{-- Remaining --}}
                <flux:table.column>
                    {{ __('app.payment.show.remaining') }}
                </flux:table.column>

                {{-- Status --}}
                <flux:table.column>
                    {{ __('app.payment.show.status') }}
                </flux:table.column>

                {{-- Action --}}
                <flux:table.column class="text-right">
                    {{ __('app.actions.action') }}
                </flux:table.column>

            </flux:table.columns>

            <flux:table.rows>

                @forelse ($loans as $loan)
                    <flux:table.row wire:key="loan-{{ $loan->id }}"
                        class="transition hover:bg-zinc-50 dark:hover:bg-zinc-800/50">

                        {{-- No --}}
                        <flux:table.cell class="text-zinc-500">
                            {{ $loans->firstItem() + $loop->index }}
                        </flux:table.cell>

                        {{-- Loan Number --}}
                        <flux:table.cell>
                            <div class="space-y-1">

                                <div class="font-medium whitespace-nowrap">
                                    {{ $loan->loan_number }}
                                </div>

                                <flux:badge size="sm" :color="$loan->type->color()">
                                    {{ $loan->type->label() }}
                                </flux:badge>

                            </div>
                        </flux:table.cell>

                        {{-- Customer --}}
                        <flux:table.cell>
                            <div class="flex items-center gap-3">

                                <flux:avatar size="sm" :name="$loan->member->name"
                                    :initials="$loan->member->initials()" circle color="auto" />

                                <div class="min-w-0">

                                    <div class="truncate font-medium">
                                        {{ $loan->member->name }}
                                    </div>

                                    @if ($loan->member->npk)
                                        <flux:text size="xs">
                                            {{ $loan->member->npk }}
                                        </flux:text>
                                    @endif

                                </div>

                            </div>
                        </flux:table.cell>

                        {{-- Payment Progress --}}
                        <flux:table.cell>
                            <flux:badge color="zinc" size="sm">
                                {{ $loan->payment_progress }}
                            </flux:badge>
                        </flux:table.cell>

                        {{-- Amount --}}
                        <flux:table.cell>
                            <span class="font-medium tabular-nums whitespace-nowrap">
                                {{ idr($loan->amount) }}
                            </span>
                        </flux:table.cell>

                        {{-- Date --}}
                        <flux:table.cell>
                            <flux:text class="whitespace-nowrap">
                                {{ $loan->tanggal }}
                            </flux:text>
                        </flux:table.cell>

                        {{-- Payment Method --}}
                        <flux:table.cell>
                            <flux:badge size="sm" :color="$loan->current_payment?->method?->color() ?? 'zinc'">
                                {{ $loan->current_payment?->method?->label() ?? '-' }}
                            </flux:badge>
                        </flux:table.cell>

                        {{-- Remaining --}}
                        <flux:table.cell>
                            <span @class([
                                'font-semibold tabular-nums whitespace-nowrap',
                                'text-red-600 dark:text-red-400' => $loan->remaining > 0,
                                'text-green-600 dark:text-green-400' => $loan->remaining <= 0,
                            ])>
                                {{ idr($loan->remaining) }}
                            </span>
                        </flux:table.cell>

                        {{-- Status --}}
                        <flux:table.cell>
                            <flux:badge size="sm" :color="$loan->payment_status?->color() ?? 'red'">
                                {{ $loan->payment_status?->label() ?? __('app.payment.show.unpaid') }}
                            </flux:badge>
                        </flux:table.cell>

                        {{-- Actions --}}
                        <flux:table.cell>
                            <div class="flex gap-1">

                                @if ($loan->current_payment)
                                    {{-- Detail --}}
                                    <flux:button size="sm" variant="ghost" icon="eye"
                                        :href="route('payment.detail', $loan->current_payment)"
                                        :tooltip="__('app.payment.show.tooltip_view', [
                                            'name' => __('app.payment.show.singular'),
                                        ])" />

                                    {{-- Edit --}}
                                    <flux:button size="sm" variant="ghost" icon="pencil-square"
                                        wire:click="edit({{ $loan->current_payment->id }})"
                                        :tooltip="__('app.payment.show.tooltip_edit', [
                                            'name' => __('app.payment.show.singular'),
                                        ])" />

                                    {{-- Reset --}}
                                    <flux:button size="sm" variant="ghost" icon="arrow-uturn-left"
                                        class="text-red-500 hover:text-red-600"
                                        wire:click="confirmResetPayment({{ $loan->current_payment->id }})"
                                        :tooltip="__('app.payment.show.tooltip_reset', [
                                            'name' => __('app.payment.show.singular'),
                                        ])" />
                                @else
                                    <flux:button size="sm" variant="primary" icon="banknotes"
                                        wire:click="create({{ $loan->id }})">
                                        {{ __('app.actions.pay') }}
                                    </flux:button>
                                @endif

                            </div>
                        </flux:table.cell>

                    </flux:table.row>

                @empty

                    <flux:table.row>

                        <flux:table.cell colspan="10">

                            <div class="flex flex-col items-center justify-center py-12 text-center">

                                <div
                                    class="flex size-14 items-center justify-center rounded-2xl bg-zinc-100 dark:bg-zinc-800">
                                    <flux:icon name="clipboard-document-list" class="size-7 text-zinc-400" />
                                </div>

                                <flux:heading size="sm" class="mt-3">
                                    {{ __('app.payment.show.empty') }}
                                </flux:heading>

                                <flux:text class="mt-1">
                                    {{ __('app.payment.show.empty_description') }}
                                </flux:text>

                            </div>

                        </flux:table.cell>

                    </flux:table.row>
                @endforelse

            </flux:table.rows>

        </flux:table>

    </flux:card>

    {{-- Pagination --}}
    @if ($loans->hasPages())
        <div class="pt-2">
            {{ $loans->links() }}
        </div>
    @endif

    {{-- Payment Form --}}
    <livewire:payment.form />

</div>