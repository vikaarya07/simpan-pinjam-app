<div class="space-y-5">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

        <div>
            <flux:heading size="xl">
                Laporan Nasabah
            </flux:heading>

            <flux:text class="mt-1">
                Ringkasan pinjaman, riwayat pembayaran, dan notification nasabah
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

        <flux:select label="Nasabah" wire:model.live="customerId" placeholder="-- Pilih Nasabah --">
            @foreach ($customers as $customer)
                <flux:select.option value="{{ $customer->id }}">
                    {{ $customer->npk }} - {{ $customer->name }}
                </flux:select.option>
            @endforeach
        </flux:select>

    </flux:card>

    {{-- REPORT --}}
    @if ($report)

        @php
            $customer = $report['customer'];
            $summary = $report['summary'];
            $loans = $report['loans'];

            $hasRunningLoan = $loans->contains(
                fn($loan) => $loan->status?->value === \App\Enums\LoanStatus::Running->value,
            );
        @endphp

        {{-- CUSTOMER INFORMATION --}}
        <flux:card class="p-4">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                {{-- Identity --}}
                <div class="flex min-w-0 items-center gap-3">

                    <div
                        class="flex size-11 shrink-0 items-center justify-center
                               rounded-full bg-zinc-100 text-lg font-bold text-zinc-600
                               dark:bg-zinc-800 dark:text-zinc-300">
                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                    </div>

                    <div class="min-w-0">

                        <div class="flex flex-wrap items-center gap-2">

                            <flux:heading size="lg">
                                {{ $customer->name }}
                            </flux:heading>

                            <flux:badge :color="$customer->status?->color() ?? 'zinc'">
                                {{ $customer->status?->label() ?? '-' }}
                            </flux:badge>

                        </div>

                        <div class="mt-1 flex flex-wrap gap-x-4 gap-y-1">

                            <flux:text class="text-sm">
                                NPK: {{ $customer->npk }}
                            </flux:text>

                            <flux:text class="text-sm">
                                HP: {{ $customer->phone ?? '-' }}
                            </flux:text>

                        </div>

                    </div>

                </div>

                {{-- Statistics --}}
                <div class="flex shrink-0 gap-2">

                    <flux:badge color="zinc">
                        {{ $summary['loan_count'] }} Pinjaman
                    </flux:badge>

                    <flux:badge color="zinc">
                        {{ $this->notificationCount }} Notification
                    </flux:badge>

                </div>

            </div>

        </flux:card>

        {{-- TAB NAVIGATION --}}
        <div class="border-b border-zinc-200 dark:border-zinc-700">

            <nav class="flex gap-1 overflow-x-auto overflow-y-hidden">

                {{-- SUMMARY --}}
                <button type="button" wire:click="selectTab('summary')"
                    class="relative flex shrink-0 items-center gap-2 px-4 py-3 text-sm font-medium transition
                           {{ $tab === 'summary'
                               ? 'text-zinc-900 dark:text-white'
                               : 'text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white' }}">

                    <flux:icon name="chart-bar" class="size-4" />

                    <span>Ringkasan</span>

                    @if ($tab === 'summary')
                        <span
                            class="absolute inset-x-0 -bottom-px h-1 rounded-t-lg
                                   bg-zinc-700 dark:bg-white"></span>
                    @endif

                </button>

                {{-- LOANS --}}
                <button type="button" wire:click="selectTab('loans')"
                    class="relative flex shrink-0 items-center gap-2 px-4 py-3
                           text-sm font-medium transition
                           {{ $tab === 'loans'
                               ? 'text-zinc-900 dark:text-white'
                               : 'text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white' }}">

                    <flux:icon name="banknotes" class="size-4" />

                    <span>Riwayat Pinjaman</span>

                    <span
                        class="rounded-full bg-zinc-100 px-2 py-0.5 text-xs
                               text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
                        {{ $summary['loan_count'] }}
                    </span>

                    @if ($tab === 'loans')
                        <span
                            class="absolute inset-x-0 -bottom-px h-1 rounded-t-lg
                                   bg-zinc-700 dark:bg-white"></span>
                    @endif

                </button>

                {{-- NOTIFICATION --}}
                <button type="button" wire:click="selectTab('notification')"
                    class="relative flex shrink-0 items-center gap-2 px-4 py-3
                           text-sm font-medium transition
                           {{ $tab === 'notification'
                               ? 'text-zinc-900 dark:text-white'
                               : 'text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white' }}">

                    <flux:icon name="bell" class="size-4" />

                    <span>Notification</span>

                    @if ($this->notificationCount)
                        <span
                            class="rounded-full bg-zinc-100 px-2 py-0.5 text-xs text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
                            {{ $this->notificationCount }}
                        </span>
                    @endif

                    @if ($this->unreadNotificationCount)
                        <span
                            class="rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-700 dark:bg-blue-950 dark:text-blue-300">
                            {{ $this->unreadNotificationCount }} baru
                        </span>
                    @endif

                    @if ($tab === 'notification')
                        <span
                            class="absolute inset-x-0 -bottom-px h-1 rounded-t-lg
                                   bg-zinc-700 dark:bg-white"></span>
                    @endif

                </button>

            </nav>

        </div>

        {{-- SUMMARY TAB --}}
        @if ($tab === 'summary')

            <div class="space-y-5">

                {{-- SUMMARY CARDS --}}
                <div class="grid grid-cols-2 gap-3 xl:grid-cols-4">

                    {{-- TOTAL LOAN --}}
                    <flux:card class="p-4">

                        <div class="flex items-start justify-between gap-3">

                            <div>

                                <flux:text class="text-sm">
                                    Total Pinjaman
                                </flux:text>

                                <flux:heading size="lg" class="mt-2">
                                    Rp {{ idr($summary['loan_amount']) }}
                                </flux:heading>

                                <flux:text class="mt-1 text-xs">
                                    {{ $summary['loan_count'] }} Transaksi
                                </flux:text>

                            </div>

                            <flux:icon name="banknotes" class="size-5 text-zinc-400" />

                        </div>

                    </flux:card>

                    {{-- PAYMENT --}}
                    <flux:card class="p-4">

                        <div class="flex items-start justify-between gap-3">

                            <div>

                                <flux:text class="text-sm">
                                    Total Dibayar
                                </flux:text>

                                <flux:heading size="lg" class="mt-2">
                                    Rp {{ idr($summary['payment_amount']) }}
                                </flux:heading>

                                <flux:text class="mt-1 text-xs">
                                    Total pembayaran
                                </flux:text>

                            </div>

                            <flux:icon name="arrow-trending-up" class="size-5 text-zinc-400" />

                        </div>

                    </flux:card>

                    {{-- REMAINING --}}
                    <flux:card class="p-4">

                        <div class="flex items-start justify-between gap-3">

                            <div>

                                <flux:text class="text-sm">
                                    Sisa Pinjaman
                                </flux:text>

                                <flux:heading size="lg"
                                    class="mt-2 {{ $summary['remaining'] > 0 ? 'text-amber-600' : 'text-emerald-600' }}">
                                    Rp {{ idr($summary['remaining']) }}
                                </flux:heading>

                                <flux:text class="mt-1 text-xs">
                                    Outstanding
                                </flux:text>

                            </div>

                            <flux:icon name="clock" class="size-5 text-zinc-400" />

                        </div>

                    </flux:card>

                    {{-- STATUS --}}
                    <flux:card class="p-4">

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
                                    {{ $summary['loan_count'] }} pinjaman
                                </flux:text>

                            </div>

                            <flux:icon name="chart-bar" class="size-5 text-zinc-400" />

                        </div>

                    </flux:card>

                </div>

                {{-- INFORMATION --}}
                <flux:card class="p-5">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <div>

                            <flux:heading size="sm">
                                Informasi Nasabah
                            </flux:heading>

                            <flux:text class="mt-1">
                                Gunakan tab di atas untuk melihat detail pinjaman
                                dan notification.
                            </flux:text>

                        </div>

                        <div class="flex flex-wrap gap-2">

                            <flux:badge color="zinc">
                                {{ $summary['loan_count'] }} Pinjaman
                            </flux:badge>

                            <flux:badge color="zinc">
                                {{ $this->notificationCount }} Notification
                            </flux:badge>

                        </div>

                    </div>

                </flux:card>

            </div>

        @endif

        {{-- LOANS TAB --}}
        @if ($tab === 'loans')

            <div class="space-y-4">

                {{-- HEADER --}}
                <div class="flex items-center justify-between gap-3">

                    <div>

                        <flux:heading size="lg">
                            Riwayat Pinjaman
                        </flux:heading>

                        <flux:text class="mt-1">
                            Detail pinjaman dan pembayaran nasabah
                        </flux:text>

                    </div>

                    <flux:badge color="zinc">
                        {{ $summary['loan_count'] }} Pinjaman
                    </flux:badge>

                </div>

                {{-- LOAN LIST --}}
                <div class="space-y-3">

                    @forelse ($loans as $loan)
                        @php
                            $payments = $loan->payments->keyBy('payment_count');
                            $paidCount = $loan->payments->count();
                        @endphp

                        <details wire:key="loan-{{ $loan->id }}"
                            class="group overflow-hidden rounded-xl border
                                   border-zinc-200 bg-white shadow-sm
                                   dark:border-zinc-700 dark:bg-zinc-900">

                            {{-- LOAN HEADER --}}
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

                                {{-- SUMMARY --}}
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

                            {{-- LOAN CONTENT --}}
                            <div class="border-t border-zinc-200 dark:border-zinc-700">

                                <div class="space-y-5 p-4">

                                    {{-- LOAN INFORMATION --}}
                                    <div class="grid grid-cols-2 gap-4 md:grid-cols-4">

                                        <div>

                                            <flux:text class="text-xs">
                                                Pokok Pinjaman
                                            </flux:text>

                                            <flux:text class="mt-1 font-semibold">
                                                Rp {{ idr($loan->principal) }}
                                            </flux:text>

                                        </div>

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

                                        <div>

                                            <flux:text class="text-xs">
                                                Total Pinjaman
                                            </flux:text>

                                            <flux:text class="mt-1 font-semibold">
                                                Rp {{ idr($loan->amount) }}
                                            </flux:text>

                                        </div>

                                        <div>

                                            <flux:text class="text-xs">
                                                Sisa Hutang
                                            </flux:text>

                                            <flux:text
                                                class="mt-1 font-semibold
                                                       {{ $loan->has_outstanding_overdue ? 'text-red-600' : '' }}">
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

                                                            {{-- COUNT --}}
                                                            <flux:table.cell>
                                                                <span class="font-medium">
                                                                    {{ $i }}
                                                                </span>
                                                            </flux:table.cell>

                                                            {{-- DATE --}}
                                                            <flux:table.cell>
                                                                {{ $payment?->waktu ?? '-' }}
                                                            </flux:table.cell>

                                                            {{-- AMOUNT --}}
                                                            <flux:table.cell>

                                                                @if ($payment)
                                                                    <span class="font-semibold">
                                                                        Rp {{ idr($payment->amount) }}
                                                                    </span>
                                                                @else
                                                                    -
                                                                @endif

                                                            </flux:table.cell>

                                                            {{-- METHOD --}}
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

                                                            {{-- STATUS --}}
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

                                                            {{-- NOTE --}}
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

                                                                            <flux:card
                                                                                class="bg-zinc-50 dark:bg-zinc-800">

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

                                <div
                                    class="flex size-12 items-center justify-center
                                           rounded-full bg-zinc-100
                                           dark:bg-zinc-800">
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

        {{-- NOTIFICATION TAB --}}
        @if ($tab === 'notification')

            <div class="space-y-4">

                {{-- HEADER --}}
                <div class="flex flex-col gap-4">

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">

                        <div>

                            <flux:heading size="lg">
                                Notification
                            </flux:heading>

                            <flux:text class="mt-1">
                                Riwayat pemberitahuan dan bukti transaksi nasabah
                            </flux:text>

                        </div>

                        <flux:badge color="zinc">
                            {{ $this->notificationCount }} Notification
                        </flux:badge>

                    </div>

                    {{-- FILTER --}}
                    <div class="flex flex-col gap-3 sm:flex-row">

                        <div class="flex-1">

                            <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass"
                                placeholder="Cari notification..." />

                        </div>

                        <div class="sm:w-56">

                            <flux:select wire:model.live="type">

                                <flux:select.option value="">
                                    Semua Jenis
                                </flux:select.option>

                                @foreach ($notificationTypes as $notificationType)
                                    <flux:select.option value="{{ $notificationType->value }}">
                                        {{ $notificationType->label() }}
                                    </flux:select.option>
                                @endforeach

                            </flux:select>

                        </div>

                    </div>

                </div>

                {{-- NOTIFICATION GRID --}}
                <div class="grid gap-3 md:grid-cols-2">

                    @forelse ($notifications as $notification)
                        @php
                            $isSent = filled($notification->sent_at);
                        @endphp

                        <details wire:key="notification-{{ $notification->id }}"
                            class="group overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm transition hover:shadow-md dark:border-zinc-700 dark:bg-zinc-900">

                            {{-- NOTIFICATION HEADER --}}
                            <summary
                                class="flex cursor-pointer list-none items-center gap-3 px-4 py-3.5 transition hover:bg-zinc-50 dark:hover:bg-zinc-800">

                                {{-- ICON --}}
                                <div
                                    class="flex size-10 shrink-0 items-center justify-center rounded-lg bg-zinc-100 dark:bg-zinc-800">

                                    <flux:icon :name="$notification->type->icon()" class="size-5 text-zinc-500" />

                                </div>

                                {{-- INFORMATION --}}
                                <div class="min-w-0 flex-1">

                                    <div class="flex flex-wrap items-center gap-2">

                                        <flux:badge :color="$notification->type->color()" size="sm">
                                            {{ $notification->type->label() }}
                                        </flux:badge>

                                        @if ($isSent)
                                            <flux:badge color="green" size="sm">
                                                Terkirim
                                            </flux:badge>
                                        @else
                                            <flux:badge color="amber" size="sm">
                                                Belum Dikirim
                                            </flux:badge>
                                        @endif

                                    </div>

                                    <flux:text class="mt-0.5 text-sm font-medium">
                                        {{ $notification->title }}
                                    </flux:text>

                                    <flux:text class="mt-0.5 text-xs">
                                        {{ $notification->created_at->format('d M Y, H:i') }}
                                    </flux:text>

                                </div>

                                {{-- ACTIONS --}}
                                <div class="flex shrink-0 items-center gap-1" @click.stop>
                                    {{-- DETAIL --}}
                                    <flux:button size="sm" variant="ghost" icon="eye"
                                        wire:click="openNotification({{ $notification->id }})">
                                        <span class="hidden sm:inline">
                                            Detail
                                        </span>
                                    </flux:button>

                                    {{-- SEND --}}
                                    @if (!$isSent)
                                        <flux:button size="sm" variant="primary" icon="paper-airplane"
                                            wire:click="sendNotification({{ $notification->id }})">
                                            <span class="hidden sm:inline">
                                                Kirim
                                            </span>
                                        </flux:button>
                                    @endif

                                    {{-- CHEVRON --}}
                                    <flux:icon name="chevron-down"
                                        class="ml-1 size-4 text-zinc-400 transition-transform duration-200 group-open:rotate-180" />
                                </div>

                            </summary>

                            {{-- NOTIFICATION CONTENT --}}
                            <div class="border-t border-zinc-200 dark:border-zinc-700">

                                <div class="space-y-4 p-4">

                                    {{-- TRANSACTION INFO --}}
                                    <div class="grid gap-3 sm:grid-cols-2">

                                        @if ($notification->loan)
                                            <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">

                                                <flux:text class="text-xs text-zinc-500">
                                                    Pinjaman
                                                </flux:text>

                                                <flux:text class="mt-1 text-sm font-medium">
                                                    {{ $notification->loan->loan_number }}
                                                </flux:text>

                                            </div>
                                        @endif

                                        @if ($notification->payment)
                                            <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">

                                                <flux:text class="text-xs text-zinc-500">
                                                    Pembayaran
                                                </flux:text>

                                                <flux:text class="mt-1 text-sm font-medium">
                                                    Ke-{{ $notification->payment->payment_count ?? '-' }}
                                                </flux:text>

                                            </div>
                                        @endif

                                        @if ($notification->meeting)
                                            <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">

                                                <flux:text class="text-xs text-zinc-500">
                                                    Pertemuan
                                                </flux:text>

                                                <flux:text class="mt-1 text-sm font-medium">
                                                    {{ $notification->meeting->meeting_date?->format('d M Y') ?? '-' }}
                                                </flux:text>

                                            </div>
                                        @endif

                                        <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">

                                            <flux:text class="text-xs text-zinc-500">
                                                Dibuat
                                            </flux:text>

                                            <flux:text class="mt-1 text-sm font-medium">
                                                {{ $notification->created_at->format('d M Y H:i') }}
                                            </flux:text>

                                        </div>

                                    </div>

                                    {{-- MESSAGE --}}
                                    <div>

                                        <flux:text class="mb-2 text-xs font-medium text-zinc-500">
                                            Isi Notification
                                        </flux:text>

                                        <div
                                            class="rounded-lg border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-800">

                                            <flux:text class="whitespace-pre-line text-sm leading-relaxed">
                                                {{ $notification->message }}
                                            </flux:text>

                                        </div>

                                    </div>

                                    {{-- SENT INFORMATION --}}
                                    <div
                                        class="flex flex-col gap-2 border-t border-zinc-200 pt-3 sm:flex-row sm:items-center sm:justify-between dark:border-zinc-700">

                                        @if ($isSent)
                                            <div class="flex items-center gap-2">

                                                <flux:icon name="check-circle" class="size-4 text-green-500" />

                                                <flux:text class="text-xs">
                                                    Terkirim
                                                    {{ $notification->sent_at->format('d M Y H:i') }}
                                                </flux:text>

                                            </div>
                                        @else
                                            <div class="flex items-center gap-2">

                                                <flux:icon name="clock" class="size-4 text-amber-500" />

                                                <flux:text class="text-xs">
                                                    Notification belum dikirim
                                                </flux:text>

                                            </div>

                                            <flux:button size="sm" variant="primary" icon="paper-airplane"
                                                wire:click="sendNotification({{ $notification->id }})">
                                                Kirim Notification
                                            </flux:button>
                                        @endif

                                    </div>

                                </div>

                            </div>

                        </details>

                    @empty

                        <div class="md:col-span-2">

                            <flux:card class="p-10">

                                <div class="flex flex-col items-center text-center">

                                    <div
                                        class="flex size-12 items-center justify-center rounded-full bg-zinc-100 dark:bg-zinc-800">

                                        <flux:icon name="bell-slash" class="size-6 text-zinc-400" />

                                    </div>

                                    <flux:heading size="sm" class="mt-4">
                                        Belum ada notification
                                    </flux:heading>

                                    <flux:text class="mt-1">
                                        Notification akan muncul setelah transaksi atau reminder dibuat.
                                    </flux:text>

                                </div>

                            </flux:card>

                        </div>
                    @endforelse

                </div>

                {{-- PAGINATION --}}
                @if ($notifications->hasPages())
                    <div class="pt-2">
                        {{ $notifications->links() }}
                    </div>
                @endif

            </div>

        @endif

        {{-- NOTIFICATION DETAIL MODAL --}}
        @if ($selectedNotification)

            <flux:modal wire:model="showNotificationModal" class="md:w-xl">

                <div class="space-y-5">

                    {{-- HEADER --}}
                    <div class="flex items-start gap-3">

                        <div
                            class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-zinc-100 dark:bg-zinc-800">
                            <flux:icon :name="$selectedNotification->type?->icon() ?? 'bell'"
                                class="size-5 text-zinc-600 dark:text-zinc-300" />
                        </div>

                        <div class="min-w-0 flex-1">

                            <div class="flex flex-wrap items-center gap-2">

                                <flux:heading size="lg">
                                    {{ $selectedNotification->type?->label() ?? '-' }}
                                </flux:heading>

                                @if ($isSent)
                                    <flux:badge color="green" size="sm">
                                        Terkirim
                                    </flux:badge>
                                @else
                                    <flux:badge color="amber" size="sm">
                                        Belum Dikirim
                                    </flux:badge>
                                @endif

                                @if ($notification->read_at)
                                    <flux:badge color="zinc" size="sm">
                                        Dibaca
                                    </flux:badge>
                                @else
                                    <flux:badge color="blue" size="sm">
                                        Belum Dibaca
                                    </flux:badge>
                                @endif

                            </div>

                            <flux:text class="mt-1 text-sm">
                                {{ $selectedNotification->created_at?->format('d M Y, H:i') ?? '-' }}
                            </flux:text>

                        </div>

                    </div>

                    {{-- RELATED DATA --}}
                    <div class="grid gap-3 sm:grid-cols-2">

                        @if ($selectedNotification->loan)
                            <flux:card class="bg-zinc-50 dark:bg-zinc-800">

                                <flux:text class="text-xs">
                                    Pinjaman
                                </flux:text>

                                <flux:text class="mt-1 font-semibold">
                                    {{ $selectedNotification->loan->loan_number }}
                                </flux:text>

                            </flux:card>
                        @endif

                        @if ($selectedNotification->payment)
                            <flux:card class="bg-zinc-50 dark:bg-zinc-800">

                                <flux:text class="text-xs">
                                    Pembayaran
                                </flux:text>

                                <flux:text class="mt-1 font-semibold">
                                    Ke-{{ $selectedNotification->payment->payment_count ?? '-' }}
                                </flux:text>

                                <flux:text class="mt-1 text-xs">
                                    Rp {{ idr($selectedNotification->payment->amount ?? 0) }}
                                </flux:text>

                            </flux:card>
                        @endif

                        @if ($selectedNotification->meeting)
                            <flux:card class="bg-zinc-50 dark:bg-zinc-800">

                                <flux:text class="text-xs">
                                    Pertemuan
                                </flux:text>

                                <flux:text class="mt-1 font-semibold">
                                    {{ $selectedNotification->meeting->meeting_date?->format('d M Y') ?? '-' }}
                                </flux:text>

                            </flux:card>
                        @endif

                    </div>

                    {{-- MESSAGE --}}
                    <div>

                        <flux:text class="mb-2 text-sm font-medium">
                            Isi Notification
                        </flux:text>

                        <flux:card class="bg-zinc-50 dark:bg-zinc-800">

                            <flux:text class="whitespace-pre-line leading-relaxed">
                                {{ $selectedNotification->message }}
                            </flux:text>

                        </flux:card>

                    </div>

                    {{-- SENT INFORMATION --}}
                    @if ($selectedNotification->sent_at)
                        <div
                            class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 dark:border-green-900 dark:bg-green-950/30">

                            <div class="flex items-center gap-2">

                                <flux:icon name="check-circle" class="size-4 text-green-600" />

                                <flux:text
                                    class="text-sm text-green-700
                                   dark:text-green-400">
                                    Notification telah dikirim
                                    {{ $selectedNotification->sent_at->format('d M Y, H:i') }}
                                </flux:text>

                            </div>

                        </div>
                    @else
                        <div
                            class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 dark:border-amber-900 dark:bg-amber-950/30">

                            <div class="flex items-center gap-2">

                                <flux:icon name="clock" class="size-4 text-amber-600" />

                                <flux:text class="text-sm text-amber-700 dark:text-amber-400">
                                    Notification belum dikirim.
                                </flux:text>

                            </div>

                        </div>
                    @endif

                    {{-- FOOTER --}}
                    <div class="flex justify-end gap-2">

                        @if (!$selectedNotification->sent_at)
                            <flux:button variant="primary" icon="paper-airplane"
                                wire:click="sendNotification({{ $selectedNotification->id }})">
                                Kirim
                            </flux:button>
                        @endif

                        <flux:button variant="outline" wire:click="closeNotification">
                            Tutup
                        </flux:button>

                    </div>

                </div>

            </flux:modal>

        @endif

    @endif

</div>
