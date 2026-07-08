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

        {{-- <flux:button variant="primary" icon="plus" wire:click="create">
            Tambah Anggota
        </flux:button> --}}

    </div>

    <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass" placeholder="Cari NPK atau Nama ..." />

    <flux:table>

        <flux:table.columns>

            <flux:table.column>No</flux:table.column>

            <flux:table.column>Waktu</flux:table.column>

            <flux:table.column>Jenis</flux:table.column>

            <flux:table.column>Debet</flux:table.column>

            <flux:table.column>Kredit</flux:table.column>

            <flux:table.column>Saldo</flux:table.column>

            <flux:table.column>Piutang</flux:table.column>

            <flux:table.column>Total</flux:table.column>

            <flux:table.column>Keterangan</flux:table.column>

            {{-- <flux:table.column class="cursor-pointer" wire:click="sortBy('status')">

                <div class="flex items-center gap-1">
                    Status
                    @include('components.sort-icon', ['field' => 'status'])
                </div>

            </flux:table.column> --}}

            <flux:table.column>Aksi</flux:table.column>

        </flux:table.columns>

        <flux:table.rows>

            @forelse($savings as $saving)
                <flux:table.row>

                    <flux:table.cell>
                        {{ $loop->iteration }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $saving->tanggal }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $saving->type }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ idr($saving->debit) }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ idr($saving->credit) }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ idr($saving->balance) }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ idr($saving->receivable) }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ idr($saving->amount) }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $saving->description }}
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:badge color="{{ $saving->status === 'Active' ? 'green' : 'grey' }}">
                            {{ $saving->status }}
                        </flux:badge>
                    </flux:table.cell>

                    {{-- <flux:table.cell>
                        <flux:button size="sm" variant="outline" icon="pencil-square"
                            wire:click="edit('{{ $saving->id }}')">
                            Edit
                        </flux:button>
                        <flux:button size="sm" variant="danger" icon="trash"
                            wire:click="confirmDelete('{{ $saving->id }}')">
                            Hapus
                        </flux:button>
                    </flux:table.cell> --}}

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

    {{ $savings->links() }}

    {{-- <flux:modal wire:model="showFormModal" class="md:w-3xl">

        <form wire:submit="save">

            <div class="space-y-6">

                <div>

                    <flux:heading size="lg">

                        {{ $isEdit ? 'Edit saving' : 'Tambah saving' }}

                    </flux:heading>

                    <flux:text>
                        Lengkapi data anggota.
                    </flux:text>

                </div>

                <div class="grid grid-cols-2 gap-4">

                    <flux:input label="Nama" wire:model="name" />

                    <flux:input label="Email" type="email" wire:model="email" />

                    <flux:input label="No HP" wire:model="phone" />

                    <flux:select label="Jenis Kelamin" wire:model="gender">

                        <option value="">Pilih</option>
                        <option value="Male">Laki-laki</option>
                        <option value="Female">Perempuan</option>

                    </flux:select>

                    <flux:input type="date" label="Tanggal Lahir" wire:model="date_birth" />

                    <flux:input type="date" label="Tanggal Bergabung" wire:model="date_join" />

                    <flux:select label="Status" wire:model="status">
                        <option value="Active">Aktif</option>
                        <option value="Inactive">Nonaktif</option>
                    </flux:select>

                </div>

                <div class="flex justify-end gap-2">

                    <flux:button variant="ghost" wire:click="$set('showFormModal', false)">
                        Batal
                    </flux:button>

                    <flux:button type="submit" variant="primary">
                        {{ $isEdit ? 'Update' : 'Simpan' }}
                    </flux:button>

                </div>

            </div>

        </form>

    </flux:modal> --}}

</div>
