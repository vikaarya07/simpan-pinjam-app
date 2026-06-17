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

            <flux:table.column>NPK</flux:table.column>

            <flux:table.column>Nama</flux:table.column>

            <flux:table.column>Email</flux:table.column>

            <flux:table.column>Telepon</flux:table.column>

            <flux:table.column>Usia</flux:table.column>

            <flux:table.column>Jenis Kelamin</flux:table.column>

            <flux:table.column>Status</flux:table.column>

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
                        @if ($member->gender === 'Male')
                            <span class="text-blue-600">♂ Laki-laki</span>
                        @else
                            <span class="text-pink-600">♀ Perempuan</span>
                        @endif
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:badge color="{{ $member->status === 'Active' ? 'green' : 'grey' }}">
                            {{ $member->status }}
                        </flux:badge>
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:button size="sm" variant="outline" icon="pencil-square"
                            wire:click="edit('{{ $member->slug }}')">
                            Edit
                        </flux:button>
                        <flux:button size="sm" variant="danger" icon="trash"
                            wire:click="confirmDelete('{{ $member->slug }}')">
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

    <flux:modal wire:model="showFormModal" class="md:w-3xl">

        <form wire:submit="save">

            <div class="space-y-6">

                <div>

                    <flux:heading size="lg">

                        {{ $isEdit ? 'Edit Member' : 'Tambah Member' }}

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

    </flux:modal>

</div>
