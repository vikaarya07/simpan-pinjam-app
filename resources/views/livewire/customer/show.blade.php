<div class="space-y-5">

    {{-- Header --}}
    <div>
        <flux:heading size="xl">
            Detail Customer
        </flux:heading>

        <flux:text class="mt-1">
            Informasi customer dan riwayat pinjaman.
        </flux:text>
    </div>

    {{-- Informasi Customer --}}
    <flux:card>

        <div class="space-y-4">

            <div>
                <flux:heading size="sm">
                    Informasi Customer
                </flux:heading>

                <flux:text size="sm" class="mt-1">
                    Data utama customer.
                </flux:text>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

                {{-- NPK --}}
                <div class="rounded-lg bg-zinc-100 p-4 dark:bg-zinc-800/50">
                    <flux:text size="sm">NPK</flux:text>
                    <div class="mt-1 font-semibold">
                        {{ $customer->npk }}
                    </div>
                </div>

                {{-- Nama --}}
                <div class="rounded-lg bg-zinc-100 p-4 dark:bg-zinc-800/50">
                    <flux:text size="sm">Nama</flux:text>
                    <div class="mt-1 font-semibold">
                        {{ $customer->name }}
                    </div>
                </div>

                {{-- Telepon --}}
                <div class="rounded-lg bg-zinc-100 p-4 dark:bg-zinc-800/50">
                    <flux:text size="sm">Telepon</flux:text>
                    <div class="mt-1 font-semibold">
                        {{ $customer->phone ?? '-' }}
                    </div>
                </div>

            </div>

        </div>

    </flux:card>

    {{-- Riwayat Pinjaman --}}
    <div class="space-y-4">

        <div>
            <flux:heading size="lg">
                Riwayat Pinjaman
            </flux:heading>

            <flux:text class="mt-1">
                Daftar pinjaman dan riwayat pembayaran customer.
            </flux:text>
        </div>

        @forelse ($customer->loans as $loan)
            @php
                $payments = $loan->payments->keyBy('payment_count');
                $paidCount = $loan->payments->count();
            @endphp

            <details
                class="group overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900"
                wire:key="loan-{{ $loan->id }}">

                {{-- Loan Header --}}
                <summary
                    class="flex cursor-pointer list-none items-center justify-between gap-4 px-4 py-4 transition bg-slate-100 hover:bg-slate-200 dark:hover:bg-slate-800/50">

                    <div class="flex min-w-0 items-center gap-3">

                        {{-- Arrow --}}
                        <div class="shrink-0">
                            <flux:icon name="chevron-right"
                                class="size-5 text-zinc-500 transition-transform duration-200 group-open:rotate-90" />
                        </div>

                        {{-- Loan Icon --}}
                        <div
                            class="hidden size-10 shrink-0 items-center justify-center rounded-lg bg-slate-300 sm:flex dark:bg-zinc-800">
                            <flux:icon name="banknotes" class="size-5 text-slate-600" />
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
                            <div class="text-xs text-zinc-500">Pembayaran</div>
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
                                Ringkasan Pinjaman
                            </flux:heading>

                            <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">

                                {{-- Principal --}}
                                <div class="rounded-lg bg-zinc-100 p-4 dark:bg-zinc-800/50">
                                    <flux:text size="sm">Pokok Pinjaman</flux:text>
                                    <div class="mt-1 font-semibold tabular-nums">
                                        {{ idr($loan->principal) }}
                                    </div>
                                </div>

                                {{-- Interest --}}
                                <div class="rounded-lg bg-zinc-100 p-4 dark:bg-zinc-800/50">

                                    <flux:text size="sm">
                                        Jasa
                                    </flux:text>

                                    <div class="mt-1 flex flex-wrap items-baseline gap-1">
                                        <span class="font-semibold tabular-nums">
                                            {{ idr($loan->interest_amount) }}
                                        </span>
                                        <span class="text-xs text-zinc-600">
                                            ({{ $loan->interest_percent }}%)
                                        </span>
                                    </div>

                                </div>

                                {{-- Total --}}
                                <div class="rounded-lg bg-zinc-100 p-4 dark:bg-zinc-800/50">

                                    <flux:text size="sm">
                                        Total Pinjaman
                                    </flux:text>

                                    <div class="mt-1 font-semibold tabular-nums">
                                        {{ idr($loan->amount) }}
                                    </div>

                                </div>

                                {{-- Remaining --}}
                                <div @class([
                                    'rounded-lg p-4',
                                    'bg-red-100 dark:bg-red-950/20' => $loan->has_outstanding_overdue,
                                    'bg-zinc-100 dark:bg-zinc-800/50' => !$loan->has_outstanding_overdue,
                                ])>

                                    <flux:text size="sm">
                                        Sisa Hutang
                                    </flux:text>

                                    <div @class([
                                        'mt-1 font-semibold tabular-nums',
                                        'text-red-600 dark:text-red-400' => $loan->has_outstanding_overdue,
                                    ])>
                                        {{ idr($loan->remaining) }}
                                    </div>

                                </div>

                            </div>

                        </div>

                        {{-- Payment History --}}
                        <div>

                            <div class="mb-3 flex items-center justify-between gap-3">

                                <div>
                                    <flux:heading size="sm">
                                        Riwayat Pembayaran
                                    </flux:heading>

                                    <flux:text size="sm" class="mt-1">
                                        Maksimal 6 kali pembayaran.
                                    </flux:text>
                                </div>

                                <flux:badge color="slate" size="sm">
                                    {{ $paidCount }}/6
                                </flux:badge>

                            </div>

                            <flux:table>

                                <flux:table.columns>

                                    <flux:table.column>Ke</flux:table.column>

                                    <flux:table.column>Tanggal</flux:table.column>

                                    <flux:table.column>Angsuran</flux:table.column>

                                    <flux:table.column>Metode</flux:table.column>

                                    <flux:table.column>Status</flux:table.column>

                                    <flux:table.column>Catatan</flux:table.column>

                                </flux:table.columns>

                                <flux:table.rows>

                                    @for ($i = 1; $i <= 6; $i++)
                                        @php
                                            $payment = $payments->get($i);
                                        @endphp

                                        <flux:table.row
                                            wire:key="loan-{{ $loan->id }}-payment-{{ $i }}">

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

                                                <flux:badge :color="$payment?->method?->color() ?? 'zinc'"
                                                    size="sm">
                                                    {{ $payment?->method?->label() ?? '-' }}
                                                </flux:badge>

                                            </flux:table.cell>

                                            {{-- Status --}}
                                            <flux:table.cell>

                                                <flux:badge :color="$payment?->status?->color() ?? 'zinc'"
                                                    size="sm">
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

                                                    <flux:modal
                                                        name="payment-note-{{ $loan->id }}-{{ $i }}"
                                                        class="md:w-lg">

                                                        <div class="space-y-4">

                                                            <div>
                                                                <flux:heading size="lg">
                                                                    Catatan Pembayaran
                                                                </flux:heading>

                                                                <flux:text class="mt-1">
                                                                    Pembayaran ke-{{ $i }}
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
                                                                        Tutup
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
                        Belum ada riwayat pinjaman
                    </flux:heading>

                    <flux:text class="mt-1">
                        Customer ini belum memiliki riwayat pinjaman.
                    </flux:text>

                </div>

            </flux:card>
        @endforelse

    </div>

</div>
