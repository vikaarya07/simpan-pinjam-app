<div class="space-y-6">

    {{-- Header --}}
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
            Tambah Simpanan
        </flux:button>

    </div>


    {{-- Search --}}
    <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass" placeholder="Cari transaksi..." />


    {{-- Table --}}
    <flux:table>

        <flux:table.columns>

            <flux:table.column>No</flux:table.column>

            <flux:table.column>
                Waktu
            </flux:table.column>

            <flux:table.column>
                Jenis
            </flux:table.column>

            <flux:table.column>
                Debet
            </flux:table.column>

            <flux:table.column>
                Kredit
            </flux:table.column>

            <flux:table.column>
                Jasa
            </flux:table.column>

            <flux:table.column>
                Saldo
            </flux:table.column>

            <flux:table.column>
                Piutang
            </flux:table.column>

            <flux:table.column>
                Total
            </flux:table.column>

            <flux:table.column>
                Keterangan
            </flux:table.column>

            <flux:table.column>
                Aksi
            </flux:table.column>

        </flux:table.columns>


        <flux:table.rows>

            @forelse($savings as $saving)
                <flux:table.row wire:key="saving-{{ $saving->id }}">

                    {{-- No --}}
                    <flux:table.cell>
                        {{ $savings->firstItem() + $loop->index }}
                    </flux:table.cell>


                    {{-- Tanggal --}}
                    <flux:table.cell>
                        {{ $saving->waktu }}
                    </flux:table.cell>

                    {{-- Jenis --}}
                    <flux:table.cell>
                        <flux:badge :color="$saving->type_color">
                            {{ $saving->type_label }}
                        </flux:badge>
                    </flux:table.cell>

                    {{-- Debet --}}
                    <flux:table.cell>
                        {{ idr($saving->debit) }}
                    </flux:table.cell>

                    {{-- Kredit --}}
                    <flux:table.cell>
                        {{ idr($saving->credit) }}
                    </flux:table.cell>

                    {{-- Jasa --}}
                    {{-- Jasa --}}
                    <flux:table.cell>
                        @if (in_array($saving->type, ['Loan', 'Loan Overdue']) && $saving->interest_amount > 0)
                            <div>
                                {{ idr($saving->interest_amount) }}

                                <span class="text-xs text-zinc-500">
                                    ({{ $saving->interest_percent }}%)
                                </span>
                            </div>
                        @else
                            -
                        @endif
                    </flux:table.cell>

                    {{-- Saldo --}}
                    <flux:table.cell>
                        {{ idr($saving->balance) }}
                    </flux:table.cell>

                    {{-- Piutang --}}
                    <flux:table.cell>
                        {{ idr($saving->receivable) }}
                    </flux:table.cell>

                    {{-- Total --}}
                    <flux:table.cell>
                        <span class="font-semibold">
                            {{ idr($saving->amount) }}
                        </span>
                    </flux:table.cell>

                    {{-- Keterangan --}}
                    <flux:table.cell>
                        @if ($saving->description)
                            <div x-data="{ open: false }" class="flex justify-center">

                                {{-- Keterangan singkat --}}
                                <flux:button variant="ghost" size="sm"
                                    class="max-w-40 justify-start text-left" x-on:click="open = true">
                                    <span class="line-clamp-2">
                                        {{ $saving->description }}
                                    </span>
                                </flux:button>

                                {{-- Popup --}}
                                <div x-show="open" x-cloak x-transition.opacity
                                    class="fixed inset-0 flex items-center justify-center p-4"
                                    x-on:click.self="open = false">
                                    <div x-show="open" x-transition.scale
                                        class="w-full max-w-lg rounded-lg bg-slate-600 p-5" x-on:click.stop>
                                        {{-- Header --}}
                                        <div class="flex items-center justify-between">
                                            <h2 class="text-lg font-semibold text-white">
                                                Keterangan
                                            </h2>

                                            <button type="button" x-on:click="open = false"
                                                class="text-white transition hover:scale-125">
                                                ✕
                                            </button>
                                        </div>

                                        {{-- Isi --}}
                                        <div class="mt-4 rounded-lg bg-gray-50 p-4">
                                            <p class="whitespace-normal text-sm leading-relaxed text-justify text-gray-700">
                                                {{ $saving->description }}
                                            </p>
                                        </div>

                                        {{-- Footer --}}
                                        <div class="mt-5 flex justify-end">
                                            <flux:button variant="outline" x-on:click="open = false">
                                                Tutup
                                            </flux:button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @else
                            -
                        @endif
                    </flux:table.cell>

                    {{-- Aksi --}}
                    <flux:table.cell>

                        @if (in_array($saving->type, ['Opening', 'Assistance']))
                            <div class="flex gap-2">

                                <flux:button class="flex gap-0!" size="sm" variant="outline" icon="pencil-square"
                                    wire:click="edit({{ $saving->id }})">
                                </flux:button>

                                <flux:button class="flex gap-0!" size="sm" variant="danger" icon="trash"
                                    wire:click="confirmDelete({{ $saving->id }})">
                                </flux:button>

                            </div>
                        @else
                            <span class="text-xs text-zinc-500">
                                Otomatis
                            </span>
                        @endif

                    </flux:table.cell>

                </flux:table.row>

            @empty

                <flux:table.row>

                    <flux:table.cell colspan="11">

                        <div class="py-6 text-center text-zinc-500">
                            Belum ada data simpanan.
                        </div>

                    </flux:table.cell>

                </flux:table.row>
            @endforelse

        </flux:table.rows>

    </flux:table>


    {{-- Pagination --}}
    {{ $savings->links() }}


    {{-- Form --}}
    <livewire:saving.form />

</div>
