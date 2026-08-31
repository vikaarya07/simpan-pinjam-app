<div class="space-y-5">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

        <div>
            <flux:heading size="xl">
                Overview
            </flux:heading>

            <flux:text class="mt-1">
                Ringkasan kondisi dan aktivitas Simpan Pinjam.
            </flux:text>
        </div>

        <flux:badge color="slate">
            {{ now()->translatedFormat('l, d F Y') }}
        </flux:badge>

    </div>

    {{-- FINANCIAL OVERVIEW --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Pinjaman Aktif --}}
        <flux:card class="p-5 border-2 border-slate-200!">
            <div class="flex items-start justify-between gap-4">

                <div>
                    <flux:text class="text-sm font-medium">
                        Pinjaman Aktif
                    </flux:text>

                    <flux:heading size="lg" class="mt-2">
                        {{ $this->overview['loans']['running_count'] }}
                    </flux:heading>
                </div>

                <div class="flex size-10 items-center justify-center rounded-xl bg-slate-100">
                    <flux:icon.shopping-cart class="size-5 text-slate-700" />
                </div>

            </div>

            <flux:text class="mt-2 text-xs">
                Rp {{ idr($this->overview['loans']['running_amount']) }}
            </flux:text>
        </flux:card>

        {{-- Saldo --}}
        <flux:card class="p-5 border-2 border-emerald-100!">
            <div class="flex items-start justify-between gap-4">

                <div>
                    <flux:text class="text-sm font-medium">
                        Saldo
                    </flux:text>

                    <flux:heading size="lg" class="mt-2 text-emerald-600">
                        Rp {{ idr($this->overview['financial']['balance']) }}
                    </flux:heading>
                </div>

                <div class="flex size-10 items-center justify-center rounded-xl bg-emerald-50">
                    <flux:icon.banknotes class="size-5 text-emerald-600" />
                </div>

            </div>

            <flux:text class="mt-2 text-xs">
                Dana tersedia
            </flux:text>
        </flux:card>

        {{-- Piutang --}}
        <flux:card class="p-5 border-2 border-amber-100!">
            <div class="flex items-start justify-between gap-4">

                <div>
                    <flux:text class="text-sm font-medium">
                        Piutang
                    </flux:text>

                    <flux:heading size="lg" class="mt-2 text-amber-600">
                        Rp {{ idr($this->overview['financial']['receivable']) }}
                    </flux:heading>
                </div>

                <div class="flex size-10 items-center justify-center rounded-xl bg-amber-50">
                    <flux:icon.receipt-percent class="size-5 text-amber-600" />
                </div>

            </div>

            <flux:text class="mt-2 text-xs">
                Uang yang dipinjam
            </flux:text>
        </flux:card>

        {{-- Total Keseluruhan --}}
        <flux:card class="p-5 border-2 border-indigo-100!">
            <div class="flex items-start justify-between gap-4">

                <div>
                    <flux:text class="text-sm font-medium">
                        Total Keseluruhan
                    </flux:text>

                    <flux:heading size="lg" class="mt-2 text-indigo-600">
                        Rp {{ idr($this->overview['financial']['amount']) }}
                    </flux:heading>
                </div>

                <div class="flex size-10 items-center justify-center rounded-xl bg-indigo-50">
                    <flux:icon.calculator class="size-5 text-indigo-600" />
                </div>

            </div>

            <flux:text class="mt-2 text-xs">
                Saldo + Piutang
            </flux:text>
        </flux:card>

    </div>

    {{-- MONTHLY OVERVIEW --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">

        {{-- Pinjaman --}}
        <flux:card class="p-5">

            <div class="flex items-center justify-between">

                <div>
                    <flux:heading size="sm">
                        Pinjaman Bulan Ini
                    </flux:heading>

                    <flux:text class="mt-1 text-xs">
                        Aktivitas pencairan
                    </flux:text>
                </div>

                <flux:icon.arrow-down-right class="size-5 text-rose-500" />

            </div>

            <div class="mt-5">
                <flux:heading size="xl" class="text-rose-600">
                    Rp {{ idr($this->overview['monthly']['loan_amount']) }}
                </flux:heading>

                <flux:text class="mt-1 text-sm">
                    {{ $this->overview['monthly']['loan_count'] }} Transaksi
                </flux:text>
            </div>

        </flux:card>

        {{-- Pembayaran --}}
        <flux:card class="p-5">

            <div class="flex items-center justify-between">

                <div>
                    <flux:heading size="sm">
                        Angsuran Bulan Ini
                    </flux:heading>

                    <flux:text class="mt-1 text-xs">
                        Total pembayaran
                    </flux:text>
                </div>

                <flux:icon.arrow-up-right class="size-5 text-emerald-500" />

            </div>

            <div class="mt-5">
                <flux:heading size="xl" class="text-emerald-600">
                    Rp {{ idr($this->overview['monthly']['payment_amount']) }}
                </flux:heading>

                <flux:text class="mt-1 text-sm">
                    {{ $this->overview['monthly']['payment_count'] }} Transaksi
                </flux:text>
            </div>

        </flux:card>

        {{-- Nasabah --}}
        <flux:card class="p-5">

            <div class="flex items-center justify-between">

                <div>
                    <flux:heading size="sm">
                        Nasabah
                    </flux:heading>

                    <flux:text class="mt-1 text-xs">
                        Data keanggotaan
                    </flux:text>
                </div>

                <flux:icon.users class="size-5 text-slate-600" />

            </div>

            <div class="grid grid-cols-3 divide-y-0 divide-slate-200 divide-x gap-3 mt-5">

                <div>

                    <flux:heading size="xl" class="mt-2">
                        {{ $this->overview['members']['total'] }}
                    </flux:heading>

                    <flux:text size="sm">
                        Total Anggota
                    </flux:text>

                </div>

                <div>

                    <flux:heading size="xl" class="mt-2">
                        {{ $this->overview['members']['customers'] }}
                    </flux:heading>

                    <flux:text size="sm">
                        Nasabah
                    </flux:text>

                </div>

                <div>

                    <flux:heading size="xl" class="mt-2">
                        {{ $this->overview['loans']['running_count'] }}
                    </flux:heading>

                    <flux:text size="sm">
                        Pinjaman Aktif
                    </flux:text>

                </div>

            </div>

        </flux:card>

    </div>

    {{-- LOAN STATUS --}}
    <flux:card class="p-5">

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <flux:heading size="lg">
                    Kondisi Pinjaman
                </flux:heading>

                <flux:text class="mt-1">
                    Distribusi status seluruh pinjaman.
                </flux:text>
            </div>

            <flux:badge color="slate">
                {{ $this->overview['loans']['total_count'] }} Pinjaman
            </flux:badge>

        </div>

        <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-3">

            {{-- Running --}}
            <div class="rounded-xl border border-blue-200 bg-blue-50/60 p-4">

                <div class="flex items-center justify-between">

                    <flux:text class="font-medium text-blue-900">
                        Berjalan
                    </flux:text>

                    <flux:badge color="blue">
                        {{ $this->overview['loans']['running_count'] }}
                    </flux:badge>

                </div>

                <flux:heading size="lg" class="mt-3 text-blue-700">
                    Rp {{ idr($this->overview['loans']['running_amount']) }}
                </flux:heading>

            </div>

            {{-- Finish --}}
            <div class="rounded-xl border border-green-200 bg-green-50/60 p-4">

                <div class="flex items-center justify-between">

                    <flux:text class="font-medium text-green-900">
                        Lunas
                    </flux:text>

                    <flux:badge color="green">
                        {{ $this->overview['loans']['finish_count'] }}
                    </flux:badge>

                </div>

                <flux:heading size="lg" class="mt-3 text-green-700">
                    Rp {{ idr($this->overview['loans']['finish_amount']) }}
                </flux:heading>

            </div>

            {{-- Overdue --}}
            <div class="rounded-xl border border-red-200 bg-red-50/60 p-4">

                <div class="flex items-center justify-between">

                    <flux:text class="font-medium text-red-900">
                        Telat
                    </flux:text>

                    <flux:badge color="red">
                        {{ $this->overview['loans']['overdue_count'] }}
                    </flux:badge>

                </div>

                <flux:heading size="lg" class="mt-3 text-red-700">
                    Rp {{ idr($this->overview['loans']['overdue_amount']) }}
                </flux:heading>

            </div>

        </div>

    </flux:card>

    {{-- PAYMENT PROGRESS --}}
    <flux:card class="p-5">

        <div>
            <flux:heading size="lg">
                Progress Angsuran
            </flux:heading>

            <flux:text class="mt-1">
                Distribusi pembayaran berdasarkan pertemuan ke-1 sampai ke-6.
            </flux:text>
        </div>

        <div class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6">

            @foreach ($this->overview['payments']['meetings'] as $meeting)
                <div class="rounded-xl border border-slate-200 p-4 text-center">

                    <flux:text class="text-xs font-medium">
                        Ke-{{ $meeting['number'] }}
                    </flux:text>

                    <flux:heading size="lg" class="mt-2">
                        {{ $meeting['clear'] }}
                    </flux:heading>

                    <flux:text class="mt-1 text-xs">
                        Pembayaran
                    </flux:text>

                    <div class="mt-3 flex justify-center gap-1">

                        @if ($meeting['skip'] > 0)
                            <flux:badge size="sm" color="amber">
                                {{ $meeting['skip'] }} Skip
                            </flux:badge>
                        @endif

                        @if ($meeting['unpaid'] > 0)
                            <flux:badge size="sm" color="rose">
                                {{ $meeting['unpaid'] }} Belum
                            </flux:badge>
                        @endif

                    </div>

                </div>
            @endforeach

        </div>

    </flux:card>

    {{-- RECENT ACTIVITY + QUICK ACTION --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">

        {{-- Recent Activity --}}
        <flux:card class="p-5 lg:col-span-2">

            <div class="flex items-center justify-between">

                <div>
                    <flux:heading size="lg">
                        Aktivitas Terbaru
                    </flux:heading>

                    <flux:text class="mt-1">
                        Transaksi terakhir dalam aplikasi.
                    </flux:text>
                </div>

                <div class="flex items-center gap-2">
                    <flux:button size="xs" :variant="$activitySort === 'date' ? 'primary' : 'ghost'"
                        wire:click="$set('activitySort', 'date')">
                        Tanggal Transaksi
                    </flux:button>

                    <flux:button size="xs" :variant="$activitySort === 'created' ? 'primary' : 'ghost'"
                        wire:click="$set('activitySort', 'created')">
                        Baru Dibuat
                    </flux:button>
                </div>

            </div>

            <div class="mt-5 divide-y divide-slate-100">

                @forelse ($this->overview['activities'] as $activity)
                    <div class="flex items-center gap-3 py-3">

                        <div @class([
                            'flex size-9 shrink-0 items-center justify-center rounded-full',
                            'bg-indigo-50 text-indigo-600' => $activity['type'] === 'loan',
                            'bg-green-50 text-green-600' => $activity['type'] === 'payment',
                            'bg-slate-100 text-slate-600' => $activity['type'] === 'saving',
                        ])>

                            <flux:icon
                                :name="$activity['type'] === 'loan' ?
                                    'banknotes' :
                                    ($activity['type'] === 'payment' ?
                                        'arrow-up-right' :
                                        'wallet')"
                                class="size-4" />

                        </div>

                        <div class="min-w-0 flex-1">

                            <flux:text class="font-medium truncate">
                                {{ $activity['title'] }}
                            </flux:text>

                            <flux:text class="text-xs">
                                {{ $activity['description'] }}
                            </flux:text>

                        </div>

                        <div class="shrink-0 text-right">

                            <flux:text class="text-xs">
                                {{ $activity['time']->translatedFormat('l, d F Y') }}
                            </flux:text>

                            @if ($activity['amount'] > 0)
                                <flux:text class="text-sm font-semibold">
                                    Rp {{ idr($activity['amount']) }}
                                </flux:text>
                            @else
                                <flux:text class="text-sm font-semibold">
                                    Rp 0
                                </flux:text>
                            @endif

                        </div>

                    </div>

                @empty

                    <div class="py-10 text-center">

                        <flux:icon.information-circle class="mx-auto size-8 text-slate-300" />

                        <flux:text class="mt-2">
                            Belum ada aktivitas.
                        </flux:text>

                    </div>
                @endforelse

            </div>

        </flux:card>

        {{-- Quick Action --}}
        <flux:card class="p-5">

            <div>
                <flux:heading size="lg">
                    Aksi Cepat
                </flux:heading>

                <flux:text class="mt-1">
                    Akses fitur yang sering digunakan.
                </flux:text>
            </div>

            <div class="mt-5 grid grid-cols-2 gap-3">

                <flux:button variant="outline" icon="user-plus" href="{{ route('member.index') }}"
                    class="justify-start">
                    Nasabah
                </flux:button>

                <flux:button variant="outline" icon="banknotes" href="{{ route('loan.index') }}"
                    class="justify-start">
                    Pinjaman
                </flux:button>

                <flux:button variant="outline" icon="credit-card" href="{{ route('payment.index') }}"
                    class="justify-start">
                    Angsuran
                </flux:button>

                <flux:button variant="outline" icon="calendar-days" href="{{ route('meeting.index') }}"
                    class="justify-start">
                    Meeting
                </flux:button>

            </div>

            <div class="mt-3">

                <flux:button variant="outline" icon="wallet" href="{{ route('saving.index') }}"
                    class="w-full justify-start">
                    Saving
                </flux:button>

            </div>

            <div class="mt-5 grid grid-cols-2 gap-3">

                <flux:button variant="outline" icon="document-chart-bar" href="{{ route('member.index') }}"
                    class="justify-start">
                    Laporan Bulanan
                </flux:button>

                <flux:button variant="outline" icon="clipboard-document-check" href="{{ route('loan.index') }}"
                    class="justify-start">
                    Laporan Nasabah
                </flux:button>

            </div>

        </flux:card>

    </div>

</div>
