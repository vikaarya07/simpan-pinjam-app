<div class="space-y-5">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <flux:heading size="xl">
                Rapat SATYA MUDA GETAS
            </flux:heading>

            <flux:text class="mt-1">
                Daftar rapat dan status angsuran nasabah
            </flux:text>
        </div>
    </div>

    {{-- Filter --}}
    <flux:card class="p-4 border-none!">

        <div class="max-w-xl">
            <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass"
                placeholder="Cari tempat atau waktu rapat..." clearable />
        </div>

    </flux:card>

    {{-- Table --}}
    <flux:card class="overflow-hidden border-none!">

        <flux:table>

            <flux:table.columns>

                <flux:table.column class="w-16">#</flux:table.column>

                <flux:table.column>Tempat</flux:table.column>

                <flux:table.column>Waktu</flux:table.column>

                <flux:table.column>Status Angsuran</flux:table.column>

                <flux:table.column>Aksi</flux:table.column>

            </flux:table.columns>

            <flux:table.rows>

                @forelse($meetings as $meeting)
                    <flux:table.row wire:key="meeting-{{ $meeting->id }}" class="group">

                        {{-- No --}}
                        <flux:table.cell>
                            <flux:text size="sm" class="font-medium text-zinc-500">
                                {{ $meetings->firstItem() + $loop->index }}
                            </flux:text>
                        </flux:table.cell>

                        {{-- Pertemuan --}}
                        <flux:table.cell>

                            <div class="flex items-center gap-3">

                                <div
                                    class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-zinc-100 dark:bg-zinc-800">
                                    <flux:icon name="map-pin" class="size-5 text-zinc-500" />
                                </div>

                                <flux:text class="font-medium">
                                    {{ $meeting->place }}
                                </flux:text>

                            </div>

                        </flux:table.cell>

                        {{-- Waktu --}}
                        <flux:table.cell>

                            <div class="flex items-center gap-2">

                                <div
                                    class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-zinc-100 dark:bg-zinc-800">
                                    <flux:icon name="calendar-days" class="size-5 text-zinc-500" />
                                </div>

                                <div>
                                    <flux:text class="font-medium">
                                        {{ $meeting->tanggal }}
                                    </flux:text>

                                    @if (isset($meeting->meeting_date))
                                        <flux:text size="sm" class="text-zinc-500">
                                            {{ $meeting->jam }}
                                        </flux:text>
                                    @endif
                                </div>

                            </div>

                        </flux:table.cell>

                        {{-- Status Angsuran --}}
                        <flux:table.cell>

                            @php
                                $summary = $meeting->payment_summary;
                            @endphp

                            <div class="flex flex-wrap items-center gap-2">
                                <flux:badge :color="$paymentStatus::Clear->color()"
                                    :icon="$paymentStatus::Clear->icon()" size="sm">
                                    {{ $summary['clear'] }}
                                </flux:badge>

                                <flux:badge :color="$paymentStatus::Skip->color()" :icon="$paymentStatus::Skip->icon()"
                                    size="sm">
                                    {{ $summary['skip'] }}
                                </flux:badge>

                                <flux:badge color="red" icon="x-circle" size="sm">
                                    {{ $summary['unpaid'] }}
                                </flux:badge>
                            </div>

                        </flux:table.cell>

                        {{-- Aksi --}}
                        <flux:table.cell>

                            <flux:button size="sm" variant="ghost" icon="eye"
                                :href="route('payment.show', $meeting)" wire:navigate>
                                Lihat
                            </flux:button>

                        </flux:table.cell>

                    </flux:table.row>

                @empty

                    <flux:table.row>

                        <flux:table.cell colspan="5">

                            <div class="flex flex-col items-center justify-center py-12 text-center">

                                <div
                                    class="mb-4 flex size-14 items-center justify-center rounded-2xl bg-zinc-100 dark:bg-zinc-800">
                                    <flux:icon name="calendar-days" class="size-7 text-zinc-400" />
                                </div>

                                <flux:heading size="lg">
                                    Belum ada rapat
                                </flux:heading>

                                <flux:text class="mt-1 max-w-sm text-zinc-500">
                                    Belum ada data rapat yang sesuai dengan pencarian Anda.
                                </flux:text>

                                <flux:button class="mt-5" variant="primary" icon="plus"
                                    wire:click="$dispatch('open-meeting-form-create')">
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
    @if ($meetings->hasPages())
        <div class="pt-2">
            {{ $meetings->links() }}
        </div>
    @endif

    <livewire:meeting.form />

</div>
