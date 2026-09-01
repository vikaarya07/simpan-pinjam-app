<div class="space-y-5">

    {{-- Header --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

        <div class="space-y-3">
            <div>
                <flux:heading size="xl">
                    Laporan Bulanan
                </flux:heading>

                <flux:text class="mt-1">
                    Ringkasan aktivitas, pinjaman, pembayaran, dan posisi keuangan.
                </flux:text>
            </div>

            <flux:badge color="zinc">
                {{ $report['period']['label'] }}
            </flux:badge>
        </div>

        <div class="flex flex-col gap-2 sm:flex-row">
            <flux:button variant="primary" color="rose" icon="document-arrow-down" wire:click="confirmDownloadPdf"
                class="w-full sm:w-auto">
                Download PDF
            </flux:button>
        </div>

    </div>

    {{-- Filter --}}
    <flux:card class="overflow-visible p-4 border-none!">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

            <div>
                <flux:heading size="base">
                    Ringkasan Laporan Keuangan
                </flux:heading>

                <flux:text class="mt-1">
                    Ringkasan posisi dan pergerakan keuangan selama periode laporan.
                </flux:text>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:min-w-[320px]">

                <flux:select wire:model.live="month">
                    @foreach (range(1, 12) as $month)
                        <flux:select.option value="{{ $month }}">
                            {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}
                        </flux:select.option>
                    @endforeach
                </flux:select>

                <flux:select wire:model.live="year">
                    @foreach (range(now()->year - 4, now()->year + 4) as $year)
                        <flux:select.option value="{{ $year }}">
                            {{ $year }}
                        </flux:select.option>
                    @endforeach
                </flux:select>

            </div>

        </div>

    </flux:card>

    {{-- Financial Summary --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">

        {{-- Opening Balance --}}
        <flux:card class="border border-teal-200! bg-teal-50 p-4">

            <div class="flex items-start justify-between gap-3">

                <div>
                    <flux:text class="text-sm font-medium">
                        Saldo Bulan Lalu
                    </flux:text>

                    <flux:heading size="lg" class="mt-2 text-teal-600">
                        {{ idr($report['summary']['opening_balance']) }}
                    </flux:heading>
                </div>

                <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-teal-100">
                    <flux:icon.wallet class="size-5 text-teal-600" />
                </div>

            </div>

        </flux:card>

        {{-- Opening Receivable --}}
        <flux:card class="border border-amber-200! bg-amber-50 p-4">

            <div class="flex items-start justify-between gap-3">

                <div>
                    <flux:text class="text-sm font-medium">
                        Piutang Bulan Lalu
                    </flux:text>

                    <flux:heading size="lg" class="mt-2 text-amber-600">
                        {{ idr($report['summary']['opening_receivable']) }}
                    </flux:heading>
                </div>

                <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-amber-100">
                    <flux:icon.receipt-percent class="size-5 text-amber-600" />
                </div>

            </div>

        </flux:card>

        {{-- Opening Amount --}}
        <flux:card class="border border-indigo-300! bg-indigo-100 p-4">

            <div class="flex items-start justify-between gap-3">

                <div>
                    <flux:text class="text-sm font-medium">
                        Total Bulan Lalu
                    </flux:text>

                    <flux:heading size="lg" class="mt-2 text-indigo-700">
                        {{ idr($report['summary']['opening_amount']) }}
                    </flux:heading>
                </div>

                <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-indigo-200">
                    <flux:icon.calculator class="size-5 text-indigo-600" />
                </div>

            </div>

        </flux:card>

    </div>

    {{-- Cash Flow --}}
    <flux:card class="p-4 border-none!">

        <div>
            <flux:heading size="lg">
                Pergerakan Keuangan
            </flux:heading>

            <flux:text class="mt-1">
                Perbandingan debit dan credit selama periode laporan.
            </flux:text>
        </div>

        <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">

            {{-- Debit --}}
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50/60 p-5">

                <div class="flex items-center justify-between">

                    <div class="flex items-center gap-3">

                        <div class="flex size-10 items-center justify-center rounded-xl bg-white shadow-sm">
                            <flux:icon.arrow-up-right class="size-5 text-emerald-600" />
                        </div>

                        <div>
                            <flux:text class="font-semibold text-emerald-900">
                                Debit
                            </flux:text>

                            <flux:text class="text-xs text-emerald-700">
                                Total pemasukan
                            </flux:text>
                        </div>

                    </div>

                    <flux:badge color="emerald">
                        {{ $report['summary']['loan_count'] }} Transaksi
                    </flux:badge>

                </div>

                <flux:heading size="xl" class="mt-4 text-emerald-700">
                    {{ idr($report['summary']['debit']) }}
                </flux:heading>

            </div>

            {{-- Credit --}}
            <div class="rounded-2xl border border-rose-200 bg-rose-50/60 p-5">

                <div class="flex items-center justify-between">

                    <div class="flex items-center gap-3">

                        <div class="flex size-10 items-center justify-center rounded-xl bg-white shadow-sm">
                            <flux:icon.arrow-down-right class="size-5 text-rose-600" />
                        </div>

                        <div>
                            <flux:text class="font-semibold text-rose-900">
                                Credit
                            </flux:text>

                            <flux:text class="text-xs text-rose-700">
                                Total pengeluaran
                            </flux:text>
                        </div>

                    </div>

                    <flux:badge color="rose">
                        {{ $report['summary']['payment_count'] }} Transaksi
                    </flux:badge>

                </div>

                <flux:heading size="xl" class="mt-4 text-rose-700">
                    {{ idr($report['summary']['credit']) }}
                </flux:heading>

            </div>

        </div>

    </flux:card>

    {{-- Financial Position --}}
    <flux:card class="p-4 border-none!">

        <div>
            <flux:heading size="lg">
                Posisi Keuangan
            </flux:heading>

            <flux:text class="mt-1">
                Ringkasan kondisi keuangan pada akhir periode.
            </flux:text>
        </div>

        <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-3">

            {{-- Balance --}}
            <flux:card class="border border-teal-200! bg-teal-50/60 p-4">

                <div class="flex items-center gap-3">
                    <div class="flex size-9 items-center justify-center rounded-lg bg-white shadow-sm">
                        <flux:icon.banknotes class="size-4 text-teal-600" />
                    </div>

                    <flux:text class="font-medium text-teal-900">
                        Saldo Saat Ini
                    </flux:text>
                </div>

                <flux:heading size="lg" class="mt-3 text-teal-700">
                    {{ idr($report['summary']['closing_balance']) }}
                </flux:heading>

            </flux:card>

            {{-- Receivable --}}
            <flux:card class="border border-amber-200! bg-amber-50/60 p-4">

                <div class="flex items-center gap-3">
                    <div class="flex size-9 items-center justify-center rounded-lg bg-white shadow-sm">
                        <flux:icon.receipt-percent class="size-4 text-amber-600" />
                    </div>

                    <flux:text class="font-medium text-amber-900">
                        Piutang Saat Ini
                    </flux:text>
                </div>

                <flux:heading size="lg" class="mt-3 text-amber-700">
                    {{ idr($report['summary']['closing_receivable']) }}
                </flux:heading>

            </flux:card>

            {{-- Total --}}
            <flux:card class="border border-indigo-200! bg-indigo-50/60 p-4">

                <div class="flex items-center gap-3">
                    <div class="flex size-9 items-center justify-center rounded-lg bg-white shadow-sm">
                        <flux:icon.calculator class="size-4 text-indigo-600" />
                    </div>

                    <flux:text class="font-medium text-indigo-900">
                        Total Saat Ini
                    </flux:text>
                </div>

                <flux:heading size="lg" class="mt-3 text-indigo-700">
                    {{ idr($report['summary']['closing_amount']) }}
                </flux:heading>

            </flux:card>

        </div>

    </flux:card>

    {{-- Summary --}}
    <flux:card class="overflow-hidden p-0 border-none!">

        <div
            class="flex flex-col gap-2 border-b border-slate-200 p-4 pb-3 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <flux:heading size="lg">
                    Detail Summary
                </flux:heading>

                <flux:text class="mt-1">
                    Seluruh nilai utama dalam laporan keuangan.
                </flux:text>
            </div>

            <flux:badge color="slate">
                {{ $report['period']['label'] }}
            </flux:badge>

        </div>

        <div class="divide-y divide-slate-200">

            <div class="flex items-center justify-between gap-4 px-4 py-3">
                <flux:text class="font-medium text-slate-500">
                    Debit
                </flux:text>

                <flux:text class="font-semibold text-slate-600">
                    {{ idr($report['summary']['debit']) }}
                </flux:text>
            </div>

            <div class="flex items-center justify-between gap-4 px-4 py-3">
                <flux:text class="font-medium text-slate-500">
                    Credit
                </flux:text>

                <flux:text class="font-semibold text-slate-600">
                    {{ idr($report['summary']['credit']) }}
                </flux:text>
            </div>

            <div class="flex items-center justify-between gap-4 px-4 py-3">
                <flux:text class="font-medium text-slate-500">
                    Saldo
                </flux:text>

                <flux:text class="font-semibold text-slate-600">
                    {{ idr($report['summary']['closing_balance']) }}
                </flux:text>
            </div>

            <div class="flex items-center justify-between gap-4 px-4 py-3">
                <flux:text class="font-medium text-slate-500">
                    Piutang
                </flux:text>

                <flux:text class="font-semibold text-slate-600">
                    {{ idr($report['summary']['closing_receivable']) }}
                </flux:text>
            </div>

            <div class="flex items-center justify-between gap-4 bg-indigo-100 px-4 py-4">
                <flux:text class="text-lg font-bold text-indigo-700">
                    Total Posisi
                </flux:text>

                <flux:text class="text-lg font-bold text-indigo-700">
                    {{ idr($report['summary']['closing_amount']) }}
                </flux:text>
            </div>

        </div>

    </flux:card>

    {{-- Loans --}}
    <flux:card class="overflow-hidden p-4 border-none!">

        <div class="flex flex-col gap-2 border-b border-slate-100 pb-3 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <flux:heading size="lg">
                    Pinjaman
                </flux:heading>

                <flux:text class="mt-1">
                    Daftar pinjaman yang tercatat pada periode ini.
                </flux:text>
            </div>

            <flux:badge color="rose">
                {{ $report['summary']['loan_count'] }} Transaksi
            </flux:badge>

        </div>

        <div class="mt-2 overflow-x-auto">

            <flux:table>

                <flux:table.columns>

                    <flux:table.column>Nasabah</flux:table.column>

                    <flux:table.column>Pokok Pinjaman</flux:table.column>

                    <flux:table.column>Jasa</flux:table.column>

                    <flux:table.column>Total</flux:table.column>

                    <flux:table.column>Status</flux:table.column>

                </flux:table.columns>

                <flux:table.rows>

                    @forelse ($report['loans'] as $loan)
                        <flux:table.row>

                            <flux:table.cell>
                                <div class="flex items-center gap-3">

                                    <flux:avatar size="sm" :name="$loan->member->name"
                                        :initials="$loan->member->initials()" circle color="auto" />

                                    <flux:text class="font-semibold">
                                        {{ $loan->member->name }}
                                    </flux:text>

                                </div>
                            </flux:table.cell>

                            <flux:table.cell>
                                {{ idr($loan->principal) }}
                            </flux:table.cell>

                            <flux:table.cell>
                                <div class="flex gap-1 items-center">
                                    {{ idr($loan->interest_amount) }}
                                    <flux:text class="text-xs">
                                        {{ '(' . $loan->interest_percent . '%)' }}
                                    </flux:text>
                                </div>
                            </flux:table.cell>

                            <flux:table.cell>
                                <flux:text class="font-bold">
                                    {{ idr($loan->amount) }}
                                </flux:text>
                            </flux:table.cell>

                            <flux:table.cell>

                                <flux:badge :color="$loan->status?->color() ?? 'zinc'">
                                    {{ $loan->status?->label() ?? '-' }}
                                </flux:badge>

                            </flux:table.cell>

                        </flux:table.row>

                    @empty

                        <flux:table.row>

                            <flux:table.cell colspan="5">

                                <div class="py-12 text-center">

                                    <flux:icon.banknotes class="mx-auto size-6 text-zinc-400" />

                                    <flux:heading size="sm" class="mt-3">
                                        Belum ada pinjaman
                                    </flux:heading>

                                    <flux:text class="mt-1">
                                        Tidak ada pinjaman pada periode ini.
                                    </flux:text>

                                </div>

                            </flux:table.cell>

                        </flux:table.row>
                    @endforelse

                </flux:table.rows>

            </flux:table>

        </div>

    </flux:card>

    {{-- Payments --}}
    <flux:card class="overflow-hidden p-4 border-none!">

        <div class="flex flex-col gap-2 border-b border-slate-100 pb-3 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <flux:heading size="lg">
                    Pembayaran
                </flux:heading>

                <flux:text class="mt-1">
                    Riwayat pembayaran angsuran pada periode ini.
                </flux:text>
            </div>

            <flux:badge color="emerald">
                {{ $report['summary']['payment_count'] }} Transaksi
            </flux:badge>

        </div>

        <div class="mt-2 overflow-x-auto">

            <flux:table>

                <flux:table.columns>

                    <flux:table.column>Nasabah</flux:table.column>

                    <flux:table.column>Tanggal</flux:table.column>

                    <flux:table.column>Rapat</flux:table.column>

                    <flux:table.column>Angsuran</flux:table.column>

                    <flux:table.column>Metode Bayar</flux:table.column>

                </flux:table.columns>

                <flux:table.rows>

                    @forelse ($report['payments'] as $payment)
                        <flux:table.row>

                            <flux:table.cell>

                                <div class="flex items-center gap-3">

                                    <flux:avatar size="sm" :name="$payment->loan->member->name"
                                        :initials="$payment->loan->member->initials()" circle color="auto" />

                                    <flux:text class="font-semibold">
                                        {{ $payment->loan->member->name }}
                                    </flux:text>

                                </div>

                            </flux:table.cell>

                            <flux:table.cell>
                                {{ $payment->waktu }}
                            </flux:table.cell>

                            <flux:table.cell>
                                {{ $payment->meeting?->place ?? '-' }}
                            </flux:table.cell>

                            <flux:table.cell>
                                <flux:text class="font-bold">
                                    {{ idr($payment->amount) }}
                                </flux:text>
                            </flux:table.cell>

                            <flux:table.cell>

                                <flux:badge :color="$payment->method?->color() ?? 'zinc'">
                                    {{ $payment->method?->label() ?? '-' }}
                                </flux:badge>

                            </flux:table.cell>

                        </flux:table.row>

                    @empty

                        <flux:table.row>

                            <flux:table.cell colspan="5">

                                <div class="py-12 text-center">

                                    <flux:icon.banknotes class="mx-auto size-6 text-zinc-400" />

                                    <flux:heading size="sm" class="mt-3">
                                        Belum ada pembayaran
                                    </flux:heading>

                                    <flux:text class="mt-1">
                                        Tidak ada pembayaran pada periode ini.
                                    </flux:text>

                                </div>

                            </flux:table.cell>

                        </flux:table.row>
                    @endforelse

                </flux:table.rows>

            </flux:table>

        </div>

    </flux:card>

</div>
