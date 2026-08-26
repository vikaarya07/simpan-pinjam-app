<div class="space-y-6">

    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-bold">
                Detail Customer
            </h1>

            <p class="text-gray-500">
                Informasi customer dan riwayat pinjaman.
            </p>
        </div>

    </div>

    {{-- Informasi Customer --}}
    <div class="grid grid-cols-1 gap-4 md:grid-cols-3 bg-gray-300 rounded-lg p-3">
        <div>
            <div class="text-sm font-medium text-slate-600">NPK</div>
            <div class="font-semibold">{{ $customer->npk }}</div>
        </div>

        <div>
            <div class="text-sm font-medium text-gray-500">Nama</div>
            <div class="font-semibold">{{ $customer->name }}</div>
        </div>

        <div>
            <div class="text-sm font-medium text-gray-500">Telepon</div>
            <div class="font-semibold">{{ $customer->phone ?? '-' }}</div>
        </div>
    </div>

    {{-- Loan List --}}
    <div class="space-y-3">

        @forelse ($customer->loans as $loan)

            @php
                $payments = $loan->payments->keyBy('payment_count');

                $paidCount = $loan->payments->where('amount', '>', 0)->count();
            @endphp

            <details class="group rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900"
                wire:key="loan-{{ $loan->id }}">

                {{-- Header --}}
                <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-3 py-3 bg-gray-100">
                    <div class="flex min-w-0 items-center gap-4">

                        {{-- Icon --}}
                        <div class="shrink-0">
                            <svg class="size-5 text-gray-400 transition-transform duration-200 group-open:rotate-90"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9 5 7 7-7 7" />
                            </svg>
                        </div>

                        {{-- Loan --}}
                        <div class="min-w-0">
                            <div class="font-semibold truncate">
                                {{ $loan->loan_number }}
                            </div>

                            <div class="text-xs font-medium text-gray-500">
                                {{ $loan->waktu }}
                            </div>
                        </div>
                        |
                        <div class="hidden md:block">
                            <flux:badge :color="$loan->typeColor">
                                {{ $loan->typeLabel }}
                            </flux:badge>
                        </div>
                        |
                        <div class="hidden md:block text-base font-semibold text-slate-500">
                            Rp {{ idr($loan->amount) }}
                        </div>

                    </div>

                    <div class="flex shrink-0 items-center gap-3">

                        <span class="hidden sm:inline text-sm font-medium text-slate-500">
                            {{ $paidCount }}/6 pembayaran
                        </span>

                        <flux:badge :color="$loan->status_color">
                            {{ $loan->status_label }}
                        </flux:badge>

                    </div>
                </summary>

                {{-- Content --}}
                <div class="border-t border-gray-200 px-4 py-5 dark:border-gray-700">

                    {{-- Informasi Loan --}}
                    <div class="grid grid-cols-2 gap-4 md:grid-cols-4 mb-6">

                        <div>
                            <div class="text-sm font-medium text-gray-500">
                                Pokok Pinjaman
                            </div>
                            <div class="font-semibold">
                                Rp {{ idr($loan->principal) }}
                            </div>
                        </div>

                        <div>
                            <div class="text-sm font-medium text-gray-500">
                                Jasa
                            </div>
                            <div class="flex items-center gap-1">
                                <div class="font-semibold">
                                    Rp {{ idr($loan->interest_amount) }}
                                </div>
                                <div class="font-normal">
                                    {{ '(' . $loan->interest_percent . '%)' }}
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="text-sm font-medium text-gray-500">
                                Total Pinjaman
                            </div>

                            <div class="font-semibold">
                                Rp {{ idr($loan->amount) }}
                            </div>
                        </div>

                        <div>
                            <div class="text-sm font-medium text-gray-500">
                                Sisa Hutang
                            </div>

                            <div @class([
                                'font-semibold',
                                'text-red-600' => $loan->has_outstanding_overdue,
                            ])>
                                Rp {{ idr($loan->remaining) }}
                            </div>
                        </div>

                    </div>

                    {{-- Riwayat Pembayaran --}}
                    <div>

                        <flux:heading size="sm" class="mb-3">
                            Riwayat Pembayaran
                        </flux:heading>

                        <flux:table>

                            <flux:table.columns>

                                <flux:table.column>Ke</flux:table.column>

                                <flux:table.column>Tanggal</flux:table.column>

                                <flux:table.column>Nominal</flux:table.column>

                                <flux:table.column>Metode</flux:table.column>

                                <flux:table.column>Status</flux:table.column>

                                <flux:table.column>Catatan</flux:table.column>

                            </flux:table.columns>

                            <flux:table.rows>

                                @for ($i = 1; $i <= 6; $i++)
                                    @php
                                        $payment = $payments->get($i);
                                    @endphp

                                    <flux:table.row wire:key="loan-{{ $loan->id }}-payment-{{ $i }}">

                                        <flux:table.cell>
                                            <span class="font-medium">
                                                {{ $i }}
                                            </span>
                                        </flux:table.cell>

                                        <flux:table.cell>
                                            {{ $payment?->waktu ?? '-' }}
                                        </flux:table.cell>

                                        <flux:table.cell>
                                            {{ idr($payment?->amount) ?? '-' }}
                                        </flux:table.cell>

                                        <flux:table.cell>
                                            <flux:badge :color="$payment?->method_color ?? 'zinc'">
                                                {{ $payment?->method_label ?? '-' }}
                                            </flux:badge>
                                        </flux:table.cell>

                                        <flux:table.cell>
                                            <flux:badge :color="$payment?->status_color ?? 'zinc'">
                                                {{ $payment?->status_label ?? '-' }}
                                            </flux:badge>
                                        </flux:table.cell>

                                        <flux:table.cell class="max-w-50">
                                            @if ($payment?->note)
                                                <div x-data="{ open: false }" class="flex justify-start">

                                                    {{-- Catatan --}}
                                                    <flux:button variant="ghost" size="sm"
                                                        class="w-full justify-start text-left" x-on:click="open = true">
                                                        <span class="line-clamp-2">
                                                            {{ $payment?->note }}
                                                        </span>
                                                    </flux:button>

                                                    {{-- Popup --}}
                                                    <div x-show="open" x-cloak x-transition.opacity
                                                        class="fixed inset-0 flex items-center justify-center p-4"
                                                        x-on:click.self="open = false">
                                                        <div x-show="open" x-transition.scale
                                                            class="w-full max-w-lg rounded-lg bg-slate-600 p-5"
                                                            x-on:click.stop>
                                                            {{-- Header --}}
                                                            <div class="flex items-center justify-between">
                                                                <h2 class="text-lg font-semibold text-white">
                                                                    Catatan
                                                                </h2>

                                                                <button type="button" x-on:click="open = false"
                                                                    class="text-white transition hover:scale-125">
                                                                    ✕
                                                                </button>
                                                            </div>

                                                            {{-- Isi --}}
                                                            <div class="mt-4 rounded-lg bg-gray-50 p-4">
                                                                <p
                                                                    class="whitespace-normal text-sm leading-relaxed text-justify text-gray-700">
                                                                    {{ $payment?->note }}
                                                                </p>
                                                            </div>

                                                            {{-- Footer --}}
                                                            <div class="mt-5 flex justify-end">
                                                                <flux:button variant="outline"
                                                                    x-on:click="open = false">
                                                                    Tutup
                                                                </flux:button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            @else
                                                -
                                            @endif
                                        </flux:table.cell>

                                    </flux:table.row>
                                @endfor

                            </flux:table.rows>

                        </flux:table>

                    </div>

                </div>

            </details>

        @empty

            <div class="py-12 text-center text-gray-500">
                Belum ada riwayat pinjaman.
            </div>
        @endforelse

    </div>
</div>
