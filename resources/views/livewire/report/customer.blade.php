<div class="space-y-5">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

        <div>
            <flux:heading size="xl">
                Report Nasabah
            </flux:heading>

            <flux:text class="mt-1">
                Ringkasan pinjaman dan riwayat pembayaran nasabah
            </flux:text>
        </div>

        @if ($report)
            <div class="flex gap-2">
                <flux:button variant="outline" icon="document-arrow-down" wire:click="downloadPdf">
                    PDF
                </flux:button>

                <flux:button variant="outline" icon="paper-airplane" wire:click="sendWhatsApp">
                    Kirim
                </flux:button>
            </div>
        @endif

    </div>

    {{-- CUSTOMER SELECTOR --}}
    <flux:card class="p-4">
        <flux:select label="Customer" wire:model.live="customerId" placeholder="Pilih Customer">
            @foreach ($customers as $customer)
                <flux:select.option value="{{ $customer->id }}">
                    {{ $customer->npk }} - {{ $customer->name }}
                </flux:select.option>
            @endforeach
        </flux:select>
    </flux:card>

    @if ($report)

        {{-- CUSTOMER INFO --}}
        <flux:card class="p-4">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div class="flex min-w-0 items-center gap-3">

                    <div
                        class="flex size-11 shrink-0 items-center justify-center rounded-full bg-zinc-100 text-lg font-bold text-zinc-600">
                        {{ strtoupper(substr($report['customer']->name, 0, 1)) }}
                    </div>

                    <div class="min-w-0">

                        <div class="flex flex-wrap items-center gap-2">
                            <flux:heading size="lg">
                                {{ $report['customer']->name }}
                            </flux:heading>

                            <flux:badge :color="$report['customer']->status?->color() ?? 'zinc'">
                                {{ $report['customer']->status?->label() ?? '-' }}
                            </flux:badge>
                        </div>

                        <div class="mt-1 flex flex-wrap gap-x-4 gap-y-1">
                            <flux:text class="text-sm">
                                NPK: {{ $report['customer']->npk }}
                            </flux:text>

                            <flux:text class="text-sm">
                                HP: {{ $report['customer']->phone ?? '-' }}
                            </flux:text>
                        </div>

                    </div>

                </div>

                <div class="text-sm text-zinc-500">
                    {{ $report['summary']['loan_count'] }} Pinjaman
                </div>

            </div>

        </flux:card>

        {{-- SUMMARY --}}
        <div class="grid grid-cols-2 gap-3 xl:grid-cols-4">

            {{-- Total Pinjaman --}}
            <flux:card class="p-4">

                <div class="flex items-start justify-between gap-3">

                    <div>
                        <flux:text class="text-sm">
                            Total Pinjaman
                        </flux:text>

                        <flux:heading size="lg" class="mt-2">
                            Rp {{ idr($report['summary']['loan_amount']) }}
                        </flux:heading>

                        <flux:text class="mt-1 text-xs">
                            {{ $report['summary']['loan_count'] }} Transaksi
                        </flux:text>
                    </div>

                    <flux:icon.banknotes class="size-5 text-zinc-400" />

                </div>

            </flux:card>

            {{-- Total Dibayar --}}
            <flux:card class="p-4">

                <div class="flex items-start justify-between gap-3">

                    <div>
                        <flux:text class="text-sm">
                            Total Dibayar
                        </flux:text>

                        <flux:heading size="lg" class="mt-2">
                            Rp {{ idr($report['summary']['payment_amount']) }}
                        </flux:heading>

                        <flux:text class="mt-1 text-xs">
                            Total pembayaran
                        </flux:text>
                    </div>

                    <flux:icon.arrow-trending-up class="size-5 text-zinc-400" />

                </div>

            </flux:card>

            {{-- Sisa Pinjaman --}}
            <flux:card class="p-4">

                <div class="flex items-start justify-between gap-3">

                    <div>
                        <flux:text class="text-sm">
                            Sisa Pinjaman
                        </flux:text>

                        <flux:heading size="lg"
                            class="mt-2 {{ $report['summary']['remaining'] > 0 ? 'text-amber-600' : 'text-emerald-600' }}">
                            Rp {{ idr($report['summary']['remaining']) }}
                        </flux:heading>

                        <flux:text class="mt-1 text-xs">
                            Outstanding
                        </flux:text>
                    </div>

                    <flux:icon.clock class="size-5 text-zinc-400" />

                </div>

            </flux:card>


            {{-- Status --}}
            <flux:card class="p-4">

                @php
                    $hasRunningLoan = $report['loans']->contains(
                        fn($loan) => $loan->status?->value === \App\Enums\LoanStatus::Running->value,
                    );
                @endphp

                <div class="flex items-start justify-between gap-3">

                    <div>
                        <flux:text class="text-sm">
                            Status
                        </flux:text>

                        <div class="mt-2">

                            @if ($hasRunningLoan)
                                <flux:badge color="blue">
                                    Masih Berjalan
                                </flux:badge>
                            @else
                                <flux:badge color="green">
                                    Tidak Ada Pinjaman Aktif
                                </flux:badge>
                            @endif

                        </div>

                        <flux:text class="mt-2 text-xs">
                            {{ $report['summary']['loan_count'] }} pinjaman
                        </flux:text>
                    </div>

                    <flux:icon.chart-bar class="size-5 text-zinc-400" />

                </div>

            </flux:card>

        </div>

        {{-- LOAN HISTORY --}}
        <div class="space-y-3">

            <div class="flex items-center justify-between">

                <div>
                    <flux:heading size="lg">
                        Riwayat Pinjaman
                    </flux:heading>

                    <flux:text class="mt-1">
                        Detail pinjaman dan pembayaran
                    </flux:text>
                </div>

                <flux:badge color="zinc">
                    {{ $report['summary']['loan_count'] }} Pinjaman
                </flux:badge>

            </div>

            {{-- Loan Accordion --}}
            <div class="space-y-3">

                @forelse ($report['loans'] as $loan)
                    @php
                        $payments = $loan->payments->keyBy('payment_count');
                        $paidCount = $loan->payments->count();
                    @endphp

                    <details
                        class="group overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900"
                        wire:key="loan-{{ $loan->id }}">

                        {{-- ACCORDION HEADER --}}
                        <summary
                            class="flex cursor-pointer list-none items-center justify-between gap-4 bg-zinc-50 px-4 py-3 transition hover:bg-zinc-100 dark:bg-zinc-800 dark:hover:bg-zinc-750">

                            {{-- Left --}}
                            <div class="flex min-w-0 items-center gap-3">

                                {{-- Chevron --}}
                                <div class="flex size-8 shrink-0 items-center justify-center">

                                    <flux:icon name="chevron-right"
                                        class="size-4 text-zinc-400 transition-transform duration-200 group-open:rotate-90" />

                                </div>

                                {{-- Loan Icon --}}
                                <div
                                    class="hidden size-9 shrink-0 items-center justify-center rounded-lg bg-white ring-1 ring-zinc-200 sm:flex dark:bg-zinc-900 dark:ring-zinc-700">
                                    <flux:icon name="banknotes" class="size-4 text-zinc-500" />
                                </div>

                                {{-- Loan Information --}}
                                <div class="min-w-0">

                                    <div class="flex flex-wrap items-center gap-2">

                                        <flux:text class="truncate font-semibold text-zinc-900 dark:text-white">
                                            {{ $loan->loan_number }}
                                        </flux:text>

                                        <flux:badge :color="$loan->type?->color() ?? 'zinc'" size="sm">
                                            {{ $loan->type?->label() ?? '-' }}
                                        </flux:badge>

                                    </div>

                                    <flux:text class="text-xs">
                                        {{ $loan->waktu }}
                                    </flux:text>

                                </div>

                            </div>

                            {{-- Right --}}
                            <div class="flex shrink-0 items-center gap-3">

                                <flux:text class="hidden text-sm sm:block">
                                    Pembayaran {{ $paidCount }}/6
                                </flux:text>

                                <flux:badge :color="$loan->status?->color() ?? 'zinc'" size="sm">
                                    {{ $loan->status?->label() ?? '-' }}
                                </flux:badge>

                            </div>

                        </summary>

                        {{-- ACCORDION CONTENT --}}
                        <div class="border-t border-zinc-200 dark:border-zinc-700">

                            <div class="space-y-5 p-4">

                                {{-- LOAN INFORMATION --}}
                                <div class="grid grid-cols-2 gap-4 md:grid-cols-4">

                                    {{-- Principal --}}
                                    <div>
                                        <flux:text class="text-xs">
                                            Pokok Pinjaman
                                        </flux:text>

                                        <flux:text class="mt-1 font-semibold">
                                            Rp {{ idr($loan->principal) }}
                                        </flux:text>
                                    </div>

                                    {{-- Interest --}}
                                    <div>
                                        <flux:text class="text-xs">
                                            Jasa
                                        </flux:text>

                                        <flux:text class="mt-1 font-semibold">
                                            Rp {{ idr($loan->interest_amount) }}

                                            <span class="font-normal text-zinc-500">
                                                ({{ $loan->interest_percent }}%)
                                            </span>
                                        </flux:text>
                                    </div>

                                    {{-- Total --}}
                                    <div>
                                        <flux:text class="text-xs">
                                            Total Pinjaman
                                        </flux:text>

                                        <flux:text class="mt-1 font-semibold">
                                            Rp {{ idr($loan->amount) }}
                                        </flux:text>
                                    </div>

                                    {{-- Remaining --}}
                                    <div>
                                        <flux:text class="text-xs">
                                            Sisa Hutang
                                        </flux:text>

                                        <flux:text
                                            class="mt-1 font-semibold {{ $loan->has_outstanding_overdue ? 'text-red-600' : '' }}">
                                            Rp {{ idr($loan->remaining) }}
                                        </flux:text>
                                    </div>

                                </div>

                                {{-- PAYMENT HISTORY --}}
                                <div>

                                    <div class="mb-3 flex items-center justify-between">

                                        <div>
                                            <flux:heading size="sm">
                                                Riwayat Pembayaran
                                            </flux:heading>

                                            <flux:text class="mt-1 text-xs">
                                                Maksimal 6 kali pembayaran
                                            </flux:text>
                                        </div>

                                        <flux:badge color="zinc">
                                            {{ $paidCount }}/6
                                        </flux:badge>

                                    </div>

                                    <div class="overflow-x-auto">

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

                                                        {{-- Ke --}}
                                                        <flux:table.cell>
                                                            <span class="font-medium">
                                                                {{ $i }}
                                                            </span>
                                                        </flux:table.cell>

                                                        {{-- Tanggal --}}
                                                        <flux:table.cell>
                                                            {{ $payment?->waktu ?? '-' }}
                                                        </flux:table.cell>

                                                        {{-- Angsuran --}}
                                                        <flux:table.cell>

                                                            @if ($payment)
                                                                <span class="font-semibold">
                                                                    Rp {{ idr($payment->amount) }}
                                                                </span>
                                                            @else
                                                                -
                                                            @endif

                                                        </flux:table.cell>

                                                        {{-- Metode --}}
                                                        <flux:table.cell>

                                                            @if ($payment?->method)
                                                                <flux:badge :color="$payment->method->color()">
                                                                    {{ $payment->method->label() }}
                                                                </flux:badge>
                                                            @else
                                                                <flux:badge color="zinc">
                                                                    -
                                                                </flux:badge>
                                                            @endif

                                                        </flux:table.cell>

                                                        {{-- Status --}}
                                                        <flux:table.cell>

                                                            @if ($payment?->status)
                                                                <flux:badge :color="$payment->status->color()">
                                                                    {{ $payment->status->label() }}
                                                                </flux:badge>
                                                            @else
                                                                <flux:badge color="zinc">
                                                                    -
                                                                </flux:badge>
                                                            @endif

                                                        </flux:table.cell>

                                                        {{-- Catatan --}}
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

                                                                            <flux:text
                                                                                class="whitespace-pre-line leading-relaxed">
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

                        </div>

                    </details>

                @empty

                    <flux:card class="p-10">

                        <div class="flex flex-col items-center text-center">

                            <div class="flex size-12 items-center justify-center rounded-full bg-zinc-100">
                                <flux:icon name="banknotes" class="size-6 text-zinc-400" />
                            </div>

                            <flux:heading size="sm" class="mt-4">
                                Belum ada riwayat pinjaman
                            </flux:heading>

                            <flux:text class="mt-1">
                                Nasabah belum memiliki riwayat pinjaman.
                            </flux:text>

                        </div>

                    </flux:card>
                @endforelse

            </div>

        </div>

    @endif

</div>
