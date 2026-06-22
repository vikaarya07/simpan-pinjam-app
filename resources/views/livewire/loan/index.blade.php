<div class="space-y-6">

    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-bold">
                Simpanan
            </h1>

            <p class="text-zinc-500">
                Simpanan SATYA MUDA GETAS
            </p>
        </div>

        <flux:button variant="primary" icon="plus" wire:click="create">
            Tambah Anggota
        </flux:button>

    </div>

    <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass"
        placeholder="Cari NPK, Nama atau No Pinjaman ..." />

    <flux:table>

        <flux:table.columns>

            <flux:table.column>No</flux:table.column>

            <flux:table.column class="cursor-pointer" wire:click="sortBy('loan_number')">
                <div class="flex items-center gap-1">
                    Nomor Pinjaman
                    @include('components.sort-icon', ['field' => 'loan_number'])
                </div>
            </flux:table.column>

            <flux:table.column>Nama</flux:table.column>

            <flux:table.column class="cursor-pointer" wire:click="sortBy('loan_date')">
                <div class="flex items-center gap-1">
                    Waktu
                    @include('components.sort-icon', ['field' => 'loan_date'])
                </div>
            </flux:table.column>

            <flux:table.column class="cursor-pointer" wire:click="sortBy('type')">
                <div class="flex items-center gap-1">
                    Jenis
                    @include('components.sort-icon', ['field' => 'type'])
                </div>
            </flux:table.column>

            <flux:table.column class="cursor-pointer" wire:click="sortBy('principal')">
                <div class="flex items-center gap-1">
                    Pinjaman
                    @include('components.sort-icon', ['field' => 'principal'])
                </div>
            </flux:table.column>

            <flux:table.column>Jasa</flux:table.column>

            <flux:table.column>Nominal Jasa</flux:table.column>

            <flux:table.column>Total</flux:table.column>

            <flux:table.column class="cursor-pointer" wire:click="sortBy('remaining')">
                <div class="flex items-center gap-1">
                    Sisa Hutang
                    @include('components.sort-icon', ['field' => 'remaining'])
                </div>
            </flux:table.column>

            <flux:table.column class="cursor-pointer" wire:click="sortBy('status')">
                <div class="flex items-center gap-1">
                    Status
                    @include('components.sort-icon', ['field' => 'status'])
                </div>
            </flux:table.column>

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
                        {{ $loan->tanggal }}
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:badge color="{{ $loan->type === 'loan_overdue' ? 'red' : 'blue' }}">
                            {{ $loan->type === 'loan_overdue' ? 'Telat' : 'Pinjaman' }}
                        </flux:badge>
                    </flux:table.cell>

                    <flux:table.cell class="text-right">
                        {{ idr($loan->principal) }}
                    </flux:table.cell>

                    <flux:table.cell class="text-center">
                        {{ $loan->interest_percent . '%' }}
                    </flux:table.cell>

                    <flux:table.cell class="text-right">
                        {{ idr($loan->interest_amount) }}
                    </flux:table.cell>

                    <flux:table.cell class="text-right">
                        {{ idr($loan->amount) }}
                    </flux:table.cell>

                    <flux:table.cell class="text-right">
                        {{ idr($loan->remaining) }}
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:badge color="{{ $loan->status === 'finish' ? 'green' : 'blue' }}">
                            {{ $loan->status === 'finish' ? 'Lunas' : 'Berjalan' }}
                        </flux:badge>
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:button size="sm" variant="outline" icon="pencil-square"
                            wire:click="edit('{{ $loan->slug }}')">
                            Edit
                        </flux:button>
                        <flux:button size="sm" variant="danger" icon="trash"
                            wire:click="confirmDelete('{{ $loan->slug }}')">
                            Hapus
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

    {{ $loans->links() }}

    @include('loan.create-edit')

</div>
