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

            <flux:table.column>Nama</flux:table.column>

            <flux:table.column>Nomor Pinjaman</flux:table.column>

            <flux:table.column>Waktu</flux:table.column>

            <flux:table.column>Jenis</flux:table.column>

            <flux:table.column>Pinjaman</flux:table.column>

            <flux:table.column>Jasa</flux:table.column>

            <flux:table.column>Nomonal Jasa</flux:table.column>

            <flux:table.column>Total</flux:table.column>

            <flux:table.column>Sisa Hutang</flux:table.column>

            <flux:table.column>Status</flux:table.column>

            {{-- <flux:table.column class="cursor-pointer" wire:click="sortBy('status')">

                <div class="flex items-center gap-1">
                    Status
                    @include('components.sort-icon', ['field' => 'status'])
                </div>

            </flux:table.column> --}}

            <flux:table.column>Aksi</flux:table.column>

        </flux:table.columns>

        <flux:table.rows>

            @forelse($loans as $loan)
                <flux:table.row>

                    <flux:table.cell>
                        {{ $loop->iteration }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $loan->member->name }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $loan->loan_number }}
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

                    {{-- <flux:table.cell>
                        <flux:button size="sm" variant="outline" icon="pencil-square"
                            wire:click="edit('{{ $loan->slug }}')">
                            Edit
                        </flux:button>
                        <flux:button size="sm" variant="danger" icon="trash"
                            wire:click="confirmDelete('{{ $loan->slug }}')">
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

    {{ $loans->links() }}

    <flux:modal wire:model="showFormModal" class="md:w-3xl">

        <form wire:submit="save">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">
                        {{ $isEdit ? 'Edit Pinjaman' : 'Tambah Pinjaman' }}
                    </flux:heading>
                    <flux:text>
                        Lengkapi data pinjaman.
                    </flux:text>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    {{-- Member --}}
                    <flux:select label="Anggota" wire:model.live="member_id">
                        <option value="">Pilih Anggota</option>
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}">
                                {{ $member->npk }} - {{ $member->name }}
                            </option>
                        @endforeach
                    </flux:select>
                    {{-- Nomor Pinjaman --}}
                    <flux:input label="Nomor Pinjaman" wire:model="loan_number" readonly />
                    {{-- Jenis --}}
                    <flux:select label="Jenis Pinjaman" wire:model="type" wire:change="onTypeChange">
                        <option value="" selected disabled>-- Pilih --</option>
                        <option value="loan">Pinjaman</option>
                        <option value="loan_overdue">Telat</option>
                    </flux:select>
                    {{-- Tanggal --}}
                    <flux:input type="date" label="Tanggal Pinjaman" wire:model="loan_date" />
                    {{-- Pokok --}}
                    <flux:input type="number" label="Pokok Pinjaman" wire:model.live="principal" />
                    {{-- Jasa --}}
                    <flux:input label="Jasa" value="{{ $interest_percent . '%' }}" readonly />
                    {{-- Nominal Jasa --}}
                    <flux:input label="Nominal Jasa" wire:model="interest_amount" readonly />
                    {{-- Total --}}
                    <flux:input label="Total Pinjaman" wire:model="amount" readonly />
                    {{-- Status --}}
                    <flux:select label="Status" wire:model="status">
                        <option value="Running">
                            Running
                        </option>
                        <option value="Finish">
                            Finish
                        </option>
                    </flux:select>
                </div>
                <div class="flex justify-end gap-2">
                    <flux:button variant="ghost" wire:click="closeModal">
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
