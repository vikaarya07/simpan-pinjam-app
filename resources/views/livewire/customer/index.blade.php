<div class="space-y-6">

    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-bold">
                Data Nasabah
            </h1>

            <p class="text-zinc-500">
                Daftar seluruh nasabah Simpan Pinjam SATYA MUDA GETAS
            </p>
        </div>

    </div>

    <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass" placeholder="Cari NPK, Nama, No Telp..." />

    <flux:table>

        <flux:table.columns>

            <flux:table.column>No</flux:table.column>

            <flux:table.column class="cursor-pointer" wire:click="sortBy('npk')">

                <div class="flex items-center gap-1">
                    NPK
                    @include('components.sort-icon', ['field' => 'npk'])
                </div>

            </flux:table.column>

            <flux:table.column>Nama Nasabah</flux:table.column>

            <flux:table.column>Telepon</flux:table.column>

            <flux:table.column>Jumlah Pinjaman</flux:table.column>

            <flux:table.column class="cursor-pointer" wire:click="sortBy('date_birth')">

                <div class="flex items-center gap-1">
                    Usia
                    @include('components.sort-icon', ['field' => 'date_birth'])
                </div>

            </flux:table.column>

            <flux:table.column>Jenis Kelamin</flux:table.column>

            <flux:table.column>Aksi</flux:table.column>

        </flux:table.columns>

        <flux:table.rows>

            @forelse($customers as $customer)
                <flux:table.row>

                    <flux:table.cell>
                        {{ $loop->iteration }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $customer->npk }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $customer->name }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $customer->phone }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $customer->loans_count }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $customer->age }}
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:badge color="{{ $customer->gender_color }}">
                            {{ $customer->gender_label }}
                        </flux:badge>
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:button size="sm" variant="outline" icon="eye"
                            :href="route('customer.show', $customer)">
                            Lihat
                        </flux:button>
                    </flux:table.cell>

                </flux:table.row>

            @empty
                <flux:table.row>
                    <flux:table.cell colspan="6">
                        Belum ada customer.
                    </flux:table.cell>
                </flux:table.row>
            @endforelse

        </flux:table.rows>

    </flux:table>

    {{ $customers->links() }}

</div>
