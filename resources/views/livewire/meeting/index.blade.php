<div class="space-y-5">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <flux:heading size="xl">
                Data Rapat
            </flux:heading>

            <flux:text class="mt-1">
                Daftar seluruh rapat SATYA MUDA GETAS
            </flux:text>
        </div>

        <flux:button variant="primary" icon="plus" wire:click="create">
            Tambah Rapat
        </flux:button>

    </div>

    {{-- Search --}}
    <flux:card class="p-4 border-none!">

        <div class="max-w-xl">

            <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass"
                placeholder="Cari tempat atau waktu..." />

        </div>

    </flux:card>

    {{-- Table --}}
    <flux:card class="overflow-hidden border-none!">

        <flux:table>

            <flux:table.columns>

                <flux:table.column class="w-12">#</flux:table.column>

                <flux:table.column>Tempat</flux:table.column>

                <flux:table.column class="cursor-pointer" wire:click="sortBy('meeting_date')">
                    <div class="flex items-center gap-1">
                        Waktu

                        @include('components.sort-icon', [
                            'field' => 'meeting_date',
                        ])
                    </div>
                </flux:table.column>

                <flux:table.column class="text-right">Aksi</flux:table.column>

            </flux:table.columns>

            <flux:table.rows>

                @forelse($meetings as $meeting)
                    <flux:table.row wire:key="meeting-{{ $meeting->id }}"
                        class="transition hover:bg-zinc-50 dark:hover:bg-zinc-800/50">

                        {{-- No --}}
                        <flux:table.cell class="text-zinc-500">
                            {{ $loop->iteration }}
                        </flux:table.cell>

                        {{-- Place --}}
                        <flux:table.cell>

                            <div class="flex items-center gap-3">

                                <div
                                    class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-zinc-100 dark:bg-zinc-800">
                                    <flux:icon name="map-pin" class="size-5 text-zinc-500" />
                                </div>

                                <div>
                                    <div class="font-medium">
                                        {{ $meeting->place }}
                                    </div>
                                </div>

                            </div>

                        </flux:table.cell>

                        {{-- Date --}}
                        <flux:table.cell>

                            <div class="flex items-center gap-3">

                                <div
                                    class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-zinc-100 dark:bg-zinc-800">
                                    <flux:icon name="calendar-days" class="size-5 text-zinc-500" />
                                </div>

                                <div>
                                    <div class="font-medium">
                                        {{ $meeting->waktu }}
                                    </div>
                                    <div>
                                        {{ $meeting->jam }}
                                    </div>
                                </div>

                            </div>

                        </flux:table.cell>


                        {{-- Actions --}}
                        <flux:table.cell>

                            <div class="flex justify-start gap-1">

                                <flux:button size="sm" variant="ghost" icon="pencil-square"
                                    wire:click="edit('{{ $meeting->id }}')" tooltip="Edit rapat" />

                                <flux:button size="sm" variant="ghost" icon="trash"
                                    class="text-red-500 hover:text-red-600"
                                    wire:click="confirmDelete('{{ $meeting->id }}')" tooltip="Hapus rapat" />

                            </div>

                        </flux:table.cell>

                    </flux:table.row>

                @empty

                    <flux:table.row>

                        <flux:table.cell colspan="4">

                            <div class="flex flex-col items-center justify-center py-12 text-center">

                                <flux:icon name="calendar-days" class="size-10 text-zinc-400" />

                                <flux:heading size="sm" class="mt-3">
                                    Belum ada data rapat
                                </flux:heading>

                                <flux:text class="mt-1">
                                    Belum terdapat jadwal rapat yang terdaftar.
                                </flux:text>

                                <flux:button class="mt-4" variant="primary" icon="plus" wire:click="create">
                                    Tambah Rapat
                                </flux:button>

                            </div>

                        </flux:table.cell>

                    </flux:table.row>
                @endforelse

            </flux:table.rows>

        </flux:table>

    </flux:card>

    {{-- Pagination --}}
    <div>
        {{ $meetings->links() }}
    </div>

    {{-- Form --}}
    <livewire:meeting.form />

</div>
