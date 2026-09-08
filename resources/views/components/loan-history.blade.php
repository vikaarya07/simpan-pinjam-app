@props([
    'items' => '',
])

@forelse ($items as $loan)
    @php
        $payments = $loan->payments->keyBy('payment_count');
        $paidCount = $loan->payments->count();
    @endphp

    <details class="group overflow-hidden rounded-xl border-none! bg-white shadow-sm dark:bg-zinc-900"
        wire:key="loan-{{ $loan->id }}">

        {{-- Loan Header --}}
        <summary
            class="flex cursor-pointer list-none items-center justify-between gap-4 bg-zinc-50 px-4 py-3 transition hover:bg-zinc-100 dark:bg-zinc-800 dark:hover:bg-zinc-700">

            <div class="flex min-w-0 items-center gap-3">

                {{-- Arrow --}}
                <div class="shrink-0">
                    <flux:icon name="chevron-right"
                        class="size-5 text-zinc-500 transition-transform duration-200 group-open:rotate-90" />
                </div>

                {{-- Loan Icon --}}
                <div
                    class="hidden size-10 shrink-0 items-center justify-center rounded-lg bg-slate-200 sm:flex dark:bg-zinc-800">
                    <flux:icon name="banknotes" class="size-5 text-slate-400" />
                </div>

                {{-- Loan Info --}}
                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="truncate font-semibold">
                            {{ $loan->loan_number }}
                        </span>
                        <flux:badge :color="$loan->type->color()" size="sm">
                            {{ $loan->type->label() }}
                        </flux:badge>
                    </div>
                    <div class="mt-1 text-xs text-zinc-500">
                        {{ $loan->waktu }}
                    </div>
                </div>

            </div>

            {{-- Right Summary --}}
            <div class="flex shrink-0 items-center gap-5">
                <div class="hidden text-right sm:block">
                    <div class="text-xs text-zinc-500">Total</div>
                    <div class="font-semibold tabular-nums">
                        {{ idr($loan->amount) }}
                    </div>
                </div>

                <div class="hidden text-right md:block">
                    <div class="text-xs text-zinc-500">{{ __('app.loan_history.payment_count') }}</div>
                    <div class="font-medium">
                        {{ $paidCount }}/6
                    </div>
                </div>

                <flux:badge :color="$loan->status->color()" size="sm">
                    {{ $loan->status->label() }}
                </flux:badge>
            </div>

        </summary>

        {{-- Loan Content --}}
        <div class="border-t border-zinc-200 px-4 py-5 dark:border-zinc-700">

            <div class="space-y-6">

                {{-- Loan Summary --}}
                <div>

                    <flux:heading size="sm" class="mb-3">
                        {{ __('app.loan_history.laon_summary') }}
                    </flux:heading>

                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">

                        {{-- Principal --}}
                        <flux:card>

                            <flux:text size="sm">{{ __('app.loan_history.principal') }}</flux:text>

                            <div class="mt-1 font-semibold tabular-nums">
                                {{ idr($loan->principal) }}
                            </div>

                        </flux:card>

                        {{-- Interest --}}
                        <flux:card>

                            <flux:text size="sm">{{ __('app.loan_history.interest') }}</flux:text>

                            <div class="mt-1 flex flex-wrap items-baseline gap-1">
                                <span class="font-semibold tabular-nums">
                                    {{ idr($loan->interest_amount) }}
                                </span>
                                <span class="text-xs text-zinc-600">
                                    ({{ $loan->interest_percent }}%)
                                </span>
                            </div>

                        </flux:card>

                        {{-- Total --}}
                        <flux:card>

                            <flux:text size="sm">{{ __('app.loan_history.amount') }}</flux:text>

                            <div class="mt-1 font-semibold tabular-nums">
                                {{ idr($loan->amount) }}
                            </div>

                        </flux:card>

                        {{-- Remaining --}}
                        <flux:card @class([
                            'bg-red-100 dark:bg-red-950/20' => $loan->has_outstanding_overdue,
                        ])>

                            <flux:text size="sm">{{ __('app.loan_history.remaining') }}</flux:text>

                            <div @class([
                                'mt-1 font-semibold tabular-nums',
                                'text-red-600 dark:text-red-400' => $loan->has_outstanding_overdue,
                            ])>
                                {{ idr($loan->remaining) }}
                            </div>

                        </flux:card>

                    </div>

                </div>

                {{-- Payment History --}}
                <div>

                    <div class="mb-3 flex items-center justify-between gap-3">

                        <div>
                            <flux:heading size="sm">
                                {{ __('app.loan_history.payment_history') }}
                            </flux:heading>

                            <flux:text size="sm" class="mt-1">
                                {{ __('app.loan_history.payment_history_description') }}
                            </flux:text>
                        </div>

                        <flux:badge color="slate" size="sm">
                            {{ $paidCount }}/6
                        </flux:badge>

                    </div>

                    <flux:table>

                        <flux:table.columns>

                            <flux:table.column>{{ __('app.loan_history.to') }}</flux:table.column>

                            <flux:table.column>{{ __('app.loan_history.date') }}</flux:table.column>

                            <flux:table.column>{{ __('app.loan_history.payment') }}</flux:table.column>

                            <flux:table.column>{{ __('app.loan_history.method') }}</flux:table.column>

                            <flux:table.column>{{ __('app.loan_history.status') }}</flux:table.column>

                            <flux:table.column>{{ __('app.loan_history.note') }}</flux:table.column>

                        </flux:table.columns>

                        <flux:table.rows>

                            @for ($i = 1; $i <= 6; $i++)
                                @php
                                    $payment = $payments->get($i);
                                @endphp

                                <flux:table.row wire:key="loan-{{ $loan->id }}-payment-{{ $i }}">

                                    {{-- Count --}}
                                    <flux:table.cell>
                                        <span class="font-semibold">
                                            {{ $i }}
                                        </span>
                                    </flux:table.cell>

                                    {{-- Date --}}
                                    <flux:table.cell>

                                        @if ($payment)
                                            <span class="whitespace-nowrap">
                                                {{ $payment->waktu }}
                                            </span>
                                        @else
                                            <span class="text-zinc-400">
                                                -
                                            </span>
                                        @endif

                                    </flux:table.cell>

                                    {{-- Amount --}}
                                    <flux:table.cell>

                                        @if ($payment)
                                            <span class="font-medium tabular-nums whitespace-nowrap">
                                                {{ idr($payment->amount) }}
                                            </span>
                                        @else
                                            <span class="text-zinc-400">
                                                -
                                            </span>
                                        @endif

                                    </flux:table.cell>

                                    {{-- Method --}}
                                    <flux:table.cell>

                                        <flux:badge :color="$payment?->method?->color() ?? 'zinc'" size="sm">
                                            {{ $payment?->method?->label() ?? '-' }}
                                        </flux:badge>

                                    </flux:table.cell>

                                    {{-- Status --}}
                                    <flux:table.cell>

                                        <flux:badge :color="$payment?->status?->color() ?? 'zinc'" size="sm">
                                            {{ $payment?->status?->label() ?? '-' }}
                                        </flux:badge>

                                    </flux:table.cell>

                                    {{-- Note --}}
                                    <flux:table.cell class="max-w-60">

                                        @if ($payment?->note)
                                            <flux:modal.trigger
                                                name="payment-note-{{ $loan->id }}-{{ $i }}">
                                                <flux:button variant="ghost" size="sm"
                                                    class="max-w-60 justify-start text-left">
                                                    <span class="line-clamp-2">
                                                        {{ $payment->note }}
                                                    </span>
                                                </flux:button>
                                            </flux:modal.trigger>

                                            <flux:modal name="payment-note-{{ $loan->id }}-{{ $i }}"
                                                class="md:w-lg">

                                                <div class="space-y-4">

                                                    <div>
                                                        <flux:heading size="lg">
                                                            {{ __('app.loan_history.payment_note') }}
                                                        </flux:heading>

                                                        <flux:text class="mt-1">
                                                            {{ __('app.loan_history.payment_note_count') }}
                                                            {{ $i }}
                                                        </flux:text>
                                                    </div>

                                                    <flux:card class="bg-zinc-50 dark:bg-zinc-800">

                                                        <flux:text class="whitespace-pre-line leading-relaxed">
                                                            {{ $payment->note }}
                                                        </flux:text>

                                                    </flux:card>

                                                    <div class="flex justify-end">

                                                        <flux:modal.close>
                                                            <flux:button variant="outline">
                                                                {{ __('app.actions.close') }}
                                                            </flux:button>
                                                        </flux:modal.close>

                                                    </div>

                                                </div>

                                            </flux:modal>
                                        @else
                                            <flux:text>
                                                -
                                            </flux:text>
                                        @endif

                                    </flux:table.cell>

                                </flux:table.row>
                            @endfor

                        </flux:table.rows>

                    </flux:table>

                </div>

            </div>

        </div>

    </details>

@empty

    <flux:card>

        <div class="flex flex-col items-center justify-center py-10 text-center">

            <flux:icon name="banknotes" class="size-10 text-zinc-400" />

            <flux:heading size="sm" class="mt-3">
                {{ __('app.loan_history.empty') }}
            </flux:heading>

            <flux:text class="mt-1">
                {{ __('app.loan_history.empty_description') }}
            </flux:text>

        </div>

    </flux:card>
@endforelse
