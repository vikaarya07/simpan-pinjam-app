<div class="space-y-5">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <flux:heading size="xl">
                Angsuran
            </flux:heading>

            <flux:text class="mt-1">
                Daftar angsuran anggota SATYA MUDA GETAS
            </flux:text>
        </div>

        {{-- Info Pertemuan --}}
        <div
            class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 shadow-sm dark:border-slate-700 dark:bg-slate-800">

            <div
                class="flex size-9 items-center justify-center rounded-lg bg-mist-100 text-mist-700 dark:bg-mist-900/40 dark:text-mist-300">
                <flux:icon name="calendar-days" class="size-5" />
            </div>

            <div class="leading-tight">
                <div class="text-xs font-medium text-slate-500">
                    Pertemuan
                </div>

                <div class="mt-0.5 flex items-center gap-2 text-sm font-semibold">
                    <span>{{ $meeting->place }}</span>
                    <span class="text-slate-300">•</span>
                    <span>{{ $meeting->waktu }}</span>
                </div>
            </div>

        </div>

    </div>

    {{-- Table Card --}}
    <flux:card class="overflow-hidden p-0 border-none!">

        {{-- Table Header --}}
        <div
            class="flex flex-col gap-3 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-slate-700">

            <div>
                <div class="text-sm font-semibold text-slate-900 dark:text-white">
                    Daftar Angsuran
                </div>

                <div class="text-xs text-slate-500">
                    Data pembayaran pada pertemuan ini
                </div>
            </div>

            <div class="flex items-center gap-2">

                <flux:badge color="slate">
                    {{ $loans->total() }} Pinjaman
                </flux:badge>

            </div>

        </div>

        <flux:table class="px-5! border-none!">

            <flux:table.columns>

                <flux:table.column class="w-12">#</flux:table.column>

                <flux:table.column class="cursor-pointer" wire:click="sortBy('loan_number')">
                    <div class="flex items-center gap-1">
                        Nomor Pinjaman
                        @include('components.sort-icon', ['field' => 'loan_number'])
                    </div>
                </flux:table.column>

                <flux:table.column>Nasabah</flux:table.column>

                <flux:table.column>Pertemuan</flux:table.column>

                <flux:table.column>Pokok Pinjaman</flux:table.column>

                <flux:table.column class="cursor-pointer" wire:click="sortBy('loan_date')">
                    <div class="flex items-center gap-1">
                        Waktu
                        @include('components.sort-icon', ['field' => 'loan_date'])
                    </div>
                </flux:table.column>

                <flux:table.column>Metode</flux:table.column>

                <flux:table.column>Sisa Hutang</flux:table.column>

                <flux:table.column>Status</flux:table.column>

                <flux:table.column class="text-right">Aksi</flux:table.column>

            </flux:table.columns>

            <flux:table.rows>

                @forelse($loans as $loan)
                    <flux:table.row wire:key="loan-{{ $loan->id }}"
                        class="transition hover:bg-zinc-50 dark:hover:bg-zinc-800/50">

                        {{-- No --}}
                        <flux:table.cell class="text-zinc-500">
                            {{ $loop->iteration }}
                        </flux:table.cell>

                        {{-- Loan Number --}}
                        <flux:table.cell>

                            <div class="font-medium">
                                {{ $loan->loan_number }}
                            </div>

                            <flux:badge size="sm" :color="$loan->type->color()" class="mt-0.5">
                                {{ $loan->type->label() }}
                            </flux:badge>

                        </flux:table.cell>

                        {{-- Member --}}
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

                            <div class="font-medium tabular-nums">
                                {{ idr($loan->amount) }}
                            </div>

                        </flux:table.cell>

                        {{-- Date --}}
                        <flux:table.cell>
                            <flux:text>
                                {{ $loan->tanggal }}
                            </flux:text>
                        </flux:table.cell>

                        {{-- Payment Method --}}
                        <flux:table.cell>
                            <flux:badge :color="$loan->current_payment?->method?->color() ?? 'zinc'" size="sm">
                                {{ $loan->current_payment?->method?->label() ?? '-' }}
                            </flux:badge>
                        </flux:table.cell>

                        {{-- Remaining --}}
                        <flux:table.cell>

                            <div class="font-semibold tabular-nums">
                                {{ idr($loan->remaining) }}
                            </div>

                        </flux:table.cell>

                        {{-- Status --}}
                        <flux:table.cell>

                            <flux:badge :color="$loan->payment_status?->color() ?? 'red'" size="sm">
                                {{ $loan->payment_status?->label() ?? 'Unpaid' }}
                            </flux:badge>

                        </flux:table.cell>

                        {{-- Actions --}}
                        <flux:table.cell>

                            <div class="flex justify-end gap-1">

                                @if ($loan->current_payment)
                                    {{-- Detail --}}
                                    <flux:button size="sm" variant="ghost" icon="eye"
                                        :href="route('payment.detail',$loan->current_payment)"
                                        tooltip="Lihat pembayaran" />

                                    {{-- Edit --}}
                                    <flux:button size="sm" variant="ghost" icon="pencil-square"
                                        wire:click="edit({{ $loan->current_payment->id }})"
                                        tooltip="Edit pembayaran" />

                                    {{-- Reset --}}
                                    <flux:button size="sm" variant="ghost" icon="arrow-uturn-left"
                                        class="text-red-500 hover:text-red-600"
                                        wire:click="confirmResetPayment({{ $loan->current_payment->id }})"
                                        tooltip="Reset pembayaran" />
                                @else
                                    <flux:button size="sm" variant="primary" icon="banknotes"
                                        wire:click="create({{ $loan->id }})">
                                        Bayar
                                    </flux:button>
                                @endif

                            </div>

                        </flux:table.cell>

                    </flux:table.row>

                @empty

                    <flux:table.row>

                        <flux:table.cell colspan="10">

                            <div class="flex flex-col items-center justify-center py-12 text-center">

                                <flux:icon name="clipboard-document-list" class="size-10 text-zinc-400" />

                                <flux:heading size="sm" class="mt-3">
                                    Belum ada data angsuran
                                </flux:heading>

                                <flux:text class="mt-1">
                                    Belum terdapat daftar angsuran untuk pertemuan ini.
                                </flux:text>

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

    {{-- Payment Form --}}
    <livewire:payment.form />

</div>
