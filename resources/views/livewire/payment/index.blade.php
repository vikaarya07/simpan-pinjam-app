<div class="space-y-6">

    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-bold">
                Rapat SATYA MUDA GETAS
            </h1>

            <p class="text-zinc-500">
                Daftar Rapat SATYA MUDA GETAS
            </p>
        </div>

    </div>

    <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass" placeholder="Cari Tempat atau Waktu ..." />

    <flux:table>

        <flux:table.columns>

            <flux:table.column>No</flux:table.column>

            <flux:table.column>Pertemuan</flux:table.column>

            <flux:table.column>Waktu</flux:table.column>

            <flux:table.column>Angsuran Tersedia</flux:table.column>

            <flux:table.column>Aksi</flux:table.column>

        </flux:table.columns>

        <flux:table.rows>

            @forelse($meetings as $meeting)
                <flux:table.row>

                    <flux:table.cell>
                        {{ $loop->iteration }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $meeting->place }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $meeting->tanggal }}
                    </flux:table.cell>

                    <flux:table.cell>
                        <div class="flex items-center gap-1">
                            <flux:badge color="green">
                                Clear : {{ $meeting->payment_summary['clear'] }}
                            </flux:badge>
                            |
                            <flux:badge color="amber">
                                Skip : {{ $meeting->payment_summary['skip'] }}
                            </flux:badge>
                            |
                            <flux:badge color="red">
                                Unpaid : {{ $meeting->payment_summary['unpaid'] }}
                            </flux:badge>
                        </div>
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:button size="sm" variant="outline" icon="eye"
                            :href="route('payment.show', $meeting)" wire:navigate>
                            Lihat
                        </flux:button>
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

    {{ $meetings->links() }}

    <livewire:meeting.form />

</div>
