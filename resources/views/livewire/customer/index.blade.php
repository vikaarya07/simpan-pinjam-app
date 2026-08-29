<div class="space-y-5">

    {{-- Header --}}
    <div>
        <flux:heading size="xl">
            Data Nasabah
        </flux:heading>

        <flux:text class="mt-1">
            Daftar seluruh nasabah Simpan Pinjam SATYA MUDA GETAS
        </flux:text>
    </div>


    {{-- Search --}}
    <flux:card class="p-4">

        <div class="max-w-xl">

            <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass"
                placeholder="Cari NPK, nama, atau nomor telepon..." />

        </div>

    </flux:card>


    {{-- Table --}}
    <flux:card class="overflow-hidden">

        <flux:table>

            <flux:table.columns>

                <flux:table.column class="w-12">
                    #
                </flux:table.column>


                {{-- NPK --}}
                <flux:table.column class="cursor-pointer" wire:click="sortBy('npk')">
                    <div class="flex items-center gap-1">
                        NPK

                        @include('components.sort-icon', [
                            'field' => 'npk',
                        ])
                    </div>
                </flux:table.column>


                <flux:table.column>
                    Nasabah
                </flux:table.column>


                <flux:table.column>
                    Telepon
                </flux:table.column>


                <flux:table.column class="text-center">
                    Pinjaman
                </flux:table.column>


                {{-- Usia --}}
                <flux:table.column class="cursor-pointer" wire:click="sortBy('date_birth')">
                    <div class="flex items-center gap-1">
                        Usia

                        @include('components.sort-icon', [
                            'field' => 'date_birth',
                        ])
                    </div>
                </flux:table.column>


                <flux:table.column>
                    Jenis Kelamin
                </flux:table.column>


                <flux:table.column class="text-right">
                    Aksi
                </flux:table.column>

            </flux:table.columns>


            <flux:table.rows>

                @forelse($customers as $customer)
                    <flux:table.row wire:key="customer-{{ $customer->id }}"
                        class="transition hover:bg-zinc-50 dark:hover:bg-zinc-800/50">

                        {{-- No --}}
                        <flux:table.cell class="text-zinc-500">
                            {{ $customers->firstItem() + $loop->index }}
                        </flux:table.cell>


                        {{-- NPK --}}
                        <flux:table.cell>

                            <span class="font-medium whitespace-nowrap">
                                {{ $customer->npk }}
                            </span>

                        </flux:table.cell>


                        {{-- Nasabah --}}
                        <flux:table.cell>

                            <div class="flex items-center gap-3">

                                <flux:avatar size="sm" :name="$customer->name" />

                                <div class="min-w-0">

                                    <div class="truncate font-medium">
                                        {{ $customer->name }}
                                    </div>

                                </div>

                            </div>

                        </flux:table.cell>


                        {{-- Telepon --}}
                        <flux:table.cell>

                            @if ($customer->phone)
                                <div class="flex items-center gap-2 whitespace-nowrap">

                                    <flux:icon name="phone" class="size-4 text-zinc-500" />

                                    <span>
                                        {{ $customer->phone }}
                                    </span>

                                </div>
                            @else
                                <span class="text-zinc-400">
                                    -
                                </span>
                            @endif

                        </flux:table.cell>


                        {{-- Jumlah Pinjaman --}}
                        <flux:table.cell class="text-center">

                            <flux:badge color="zinc" size="sm">
                                {{ $customer->loans_count }}
                            </flux:badge>

                        </flux:table.cell>


                        {{-- Usia --}}
                        <flux:table.cell>

                            <span class="whitespace-nowrap">
                                {{ $customer->age }} tahun
                            </span>

                        </flux:table.cell>


                        {{-- Gender --}}
                        <flux:table.cell>

                            <flux:badge :color="$customer->gender->color()" size="sm">
                                {{ $customer->gender->label() }}
                            </flux:badge>

                        </flux:table.cell>


                        {{-- Aksi --}}
                        <flux:table.cell>

                            <div class="flex justify-start">

                                <flux:button size="sm" variant="ghost" icon="eye"
                                    :href="route('customer.show', $customer)" tooltip="Lihat detail nasabah">
                                    Lihat
                                </flux:button>

                            </div>

                        </flux:table.cell>

                    </flux:table.row>

                @empty

                    <flux:table.row>

                        <flux:table.cell colspan="8">

                            <div class="flex flex-col items-center justify-center py-12 text-center">

                                <flux:icon name="users" class="size-10 text-zinc-400" />

                                <flux:heading size="sm" class="mt-3">
                                    Belum ada nasabah
                                </flux:heading>

                                <flux:text class="mt-1">
                                    Belum terdapat anggota yang memiliki riwayat pinjaman.
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
        {{ $customers->links() }}
    </div>

</div>
