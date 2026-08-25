<div class="space-y-4">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">
                Angsuran
            </h1>
            <p class="text-zinc-500">
                Daftar angsuran anggota SATYA MUDA GETAS
            </p>
        </div>
    </div>

    <div class="flex items-center text-base font-semibold">
        <div class="rounded-md bg-mist-300 px-3 py-1 text-mist-700 space-x-2">
            <span>{{ $meeting->place }}</span>
            <span>|</span>
            <span>{{ $meeting->waktu }}</span>
        </div>
    </div>

    <flux:table>

        <flux:table.columns>

            <flux:table.column>No</flux:table.column>

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

            <flux:table.column>Metode Bayar</flux:table.column>

            <flux:table.column>Sisa Hutang</flux:table.column>

            <flux:table.column>Status</flux:table.column>

            <flux:table.column>Aksi</flux:table.column>

        </flux:table.columns>

        <flux:table.rows>

            @forelse($loans as $loan)
                <flux:table.row>

                    <flux:table.cell>
                        {{ $loop->iteration }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $loan->loan_number }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $loan->member->name }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $loan->payment_progress }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ idr($loan->amount) }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $loan->tanggal }}
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:badge
                            color="{{ match ($loan->current_payment?->method) {
                                'cash' => 'green',
                                'transfer' => 'blue',
                                'qris' => 'purple',
                                default => 'gray',
                            } }}">
                            {{ $loan->current_payment?->method ? ucfirst($loan->current_payment->method) : '-' }}
                        </flux:badge>
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ idr($loan->remaining) }}
                    </flux:table.cell>

                    <flux:table.cell>
                        @php
                            $payment = $loan->current_payment;

                            if (!$payment) {
                                $status = 'Unpaid';
                                $color = 'red';
                            } elseif ($payment->status === 'skip') {
                                $status = 'Skip';
                                $color = 'yellow';
                            } else {
                                $status = 'Clear';
                                $color = 'green';
                            }
                        @endphp
                        <flux:badge color="{{ $color }}">
                            {{ $status }}
                        </flux:badge>
                    </flux:table.cell>

                    <flux:table.cell>
                        @if ($loan->current_payment)
                            <flux:button class="flex gap-0!" size="sm" variant="outline" icon="eye"
                                :href="route('payment.detail', $loan->current_payment)">
                            </flux:button>

                            <flux:button class="flex gap-0!" size="sm" variant="outline" icon="pencil-square"
                                wire:click="edit({{ $loan->current_payment->id }})">
                            </flux:button>

                            <flux:button class="flex gap-0!" size="sm" variant="danger" icon="backspace"
                                wire:click="confirmResetPayment({{ $loan->current_payment->id }})">
                            </flux:button>
                        @else
                            <flux:button size="sm" variant="primary" wire:click="create({{ $loan->id }})">
                                Bayar
                            </flux:button>
                        @endif
                    </flux:table.cell>

                </flux:table.row>

            @empty
                <flux:table.row>
                    <flux:table.cell colspan="6">
                        Belum ada data.
                    </flux:table.cell>
                </flux:table.row>
            @endforelse

        </flux:table.rows>

    </flux:table>

    {{ $loans->links() }}

    <livewire:payment.form />

</div>
