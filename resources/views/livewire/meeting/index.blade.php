<div class="space-y-6">

    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-bold">
                Data Anggota
            </h1>

            <p class="text-zinc-500">
                Daftar seluruh anggota SATYA MUDA GETAS
            </p>
        </div>

        <flux:button variant="primary" icon="plus" wire:click="create">
            Tambah Anggota
        </flux:button>

    </div>

    <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass" placeholder="Cari Tempat atau Waktu ..." />

    <flux:table>

        <flux:table.columns>

            <flux:table.column>No</flux:table.column>

            <flux:table.column>Tempat</flux:table.column>

            <flux:table.column class="cursor-pointer" wire:click="sortBy('meeting_date')">
                <div class="flex items-center gap-1">
                    Waktu
                    @include('components.sort-icon', ['field' => 'meeting_date'])
                </div>
            </flux:table.column>

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
                        {{ $meeting->waktu }}
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:button size="sm" variant="outline" icon="pencil-square"
                            wire:click="edit('{{ $meeting->id }}')">
                            Edit
                        </flux:button>
                        <flux:button size="sm" variant="danger" icon="trash"
                            wire:click="confirmDelete('{{ $meeting->id }}')">
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

    {{ $meetings->links() }}

    <livewire:meeting.form />

</div>
