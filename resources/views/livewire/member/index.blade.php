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

    <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass" placeholder="Cari NPK atau Nama ..." />

    <flux:table>

        <flux:table.columns>

            <flux:table.column>No</flux:table.column>

            <flux:table.column class="cursor-pointer" wire:click="sortBy('npk')">

                <div class="flex items-center gap-1">
                    NPK
                    @include('components.sort-icon', ['field' => 'npk'])
                </div>

            </flux:table.column>

            <flux:table.column>Nama</flux:table.column>

            <flux:table.column>Email</flux:table.column>

            <flux:table.column>Telepon</flux:table.column>


            <flux:table.column class="cursor-pointer" wire:click="sortBy('date_birth')">

                <div class="flex items-center gap-1">
                    Usia
                    @include('components.sort-icon', ['field' => 'date_birth'])
                </div>

            </flux:table.column>

            <flux:table.column>Jenis Kelamin</flux:table.column>

            <flux:table.column class="cursor-pointer" wire:click="sortBy('status')">

                <div class="flex items-center gap-1">
                    Status
                    @include('components.sort-icon', ['field' => 'status'])
                </div>

            </flux:table.column>

            <flux:table.column>Aksi</flux:table.column>

        </flux:table.columns>

        <flux:table.rows>

            @forelse($members as $member)
                <flux:table.row>

                    <flux:table.cell>
                        {{ $loop->iteration }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $member->npk }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $member->name }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $member->email }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $member->phone }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $member->age }}
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:badge color="{{ $member->gender === 'Male' ? 'blue' : 'red' }}">
                            {{ $member->gender === 'Male' ? '♂ Laki-laki' : '♀ Perempuan' }}
                        </flux:badge>
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:badge color="{{ $member->status === 'Active' ? 'green' : 'grey' }}">
                            {{ $member->status }}
                        </flux:badge>
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:button size="sm" variant="outline" icon="pencil-square"
                            wire:click="edit('{{ $member->id }}')">
                            Edit
                        </flux:button>
                        <flux:button size="sm" variant="danger" icon="trash"
                            wire:click="confirmDelete('{{ $member->id }}')">
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

    {{ $members->links() }}

    <livewire:member.form />

</div>
