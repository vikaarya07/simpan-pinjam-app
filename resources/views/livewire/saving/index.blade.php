<div class="space-y-5">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <flux:heading size="xl">
                Simpanan
            </flux:heading>

            <flux:text class="mt-1">
                Simpanan SATYA MUDA GETAS
            </flux:text>
        </div>

        <flux:button variant="primary" icon="plus" wire:click="create">
            Tambah Simpanan
        </flux:button>

    </div>


    {{-- Table --}}
    <flux:card class="overflow-hidden">

        <flux:table>

            <flux:table.columns>

                <flux:table.column class="w-12">
                    #
                </flux:table.column>

                <flux:table.column>
                    Waktu
                </flux:table.column>

                <flux:table.column>
                    Jenis
                </flux:table.column>

                <flux:table.column class="text-right">
                    Debet
                </flux:table.column>

                <flux:table.column class="text-right">
                    Kredit
                </flux:table.column>

                <flux:table.column class="text-right">
                    Jasa
                </flux:table.column>

                <flux:table.column class="text-right">
                    Saldo
                </flux:table.column>

                <flux:table.column class="text-right">
                    Piutang
                </flux:table.column>

                <flux:table.column class="text-right">
                    Total
                </flux:table.column>

                <flux:table.column>
                    Keterangan
                </flux:table.column>

                <flux:table.column class="text-right">
                    Aksi
                </flux:table.column>

            </flux:table.columns>


            <flux:table.rows>

                @forelse($savings as $saving)
                    <flux:table.row wire:key="saving-{{ $saving->id }}"
                        class="transition hover:bg-zinc-50 dark:hover:bg-zinc-800/50">

                        {{-- No --}}
                        <flux:table.cell class="text-zinc-500">
                            {{ $savings->firstItem() + $loop->index }}
                        </flux:table.cell>


                        {{-- Waktu --}}
                        <flux:table.cell>
                            <div class="whitespace-nowrap font-medium">
                                {{ $saving->waktu }}
                            </div>
                        </flux:table.cell>


                        {{-- Jenis --}}
                        <flux:table.cell>

                            <flux:badge :color="$saving->type->color()" size="sm">
                                {{ $saving->type->label() }}
                            </flux:badge>

                        </flux:table.cell>


                        {{-- Debet --}}
                        <flux:table.cell class="text-right">

                            @if ($saving->debit > 0)
                                <span class="font-medium tabular-nums">
                                    {{ idr($saving->debit) }}
                                </span>
                            @else
                                <span class="text-zinc-400">
                                    -
                                </span>
                            @endif

                        </flux:table.cell>


                        {{-- Kredit --}}
                        <flux:table.cell class="text-right">

                            @if ($saving->credit > 0)
                                <span class="font-medium tabular-nums">
                                    {{ idr($saving->credit) }}
                                </span>
                            @else
                                <span class="text-zinc-400">
                                    -
                                </span>
                            @endif

                        </flux:table.cell>


                        {{-- Jasa --}}
                        <flux:table.cell class="text-right">

                            @if (in_array($saving->type, [\App\Enums\SavingType::Loan, \App\Enums\SavingType::LoanOverdue], true) &&
                                    $saving->interest_amount > 0)
                                <div class="flex items-center gap-1">

                                    <span class="font-medium tabular-nums">
                                        {{ idr($saving->interest_amount) }}
                                    </span>

                                    <flux:text as="span" size="xs">
                                        ({{ $saving->interest_percent }}%)
                                    </flux:text>

                                </div>
                            @else
                                <span class="text-zinc-400">
                                    -
                                </span>
                            @endif

                        </flux:table.cell>


                        {{-- Saldo --}}
                        <flux:table.cell class="text-right">

                            <span class="font-medium tabular-nums">
                                {{ idr($saving->balance) }}
                            </span>

                        </flux:table.cell>

                        {{-- Piutang --}}
                        <flux:table.cell class="text-right">

                            <span class="font-medium tabular-nums">
                                {{ idr($saving->receivable) }}
                            </span>

                        </flux:table.cell>

                        {{-- Total --}}
                        <flux:table.cell class="text-right">

                            <span class="font-semibold tabular-nums">
                                {{ idr($saving->amount) }}
                            </span>

                        </flux:table.cell>

                        {{-- Keterangan --}}
                        <flux:table.cell>

                            @if ($saving->description)
                                <flux:modal.trigger name="description-{{ $saving->id }}">

                                    <flux:button variant="ghost" size="sm"
                                        class="max-w-48 justify-start text-left">
                                        <span class="line-clamp-2">
                                            {{ $saving->description }}
                                        </span>
                                    </flux:button>

                                </flux:modal.trigger>

                                <flux:modal name="description-{{ $saving->id }}" class="md:w-lg">

                                    <div class="space-y-6">

                                        {{-- Header --}}
                                        <div>
                                            <flux:heading size="lg">
                                                Keterangan
                                            </flux:heading>

                                            <flux:text class="mt-1">
                                                Detail keterangan transaksi simpanan.
                                            </flux:text>
                                        </div>

                                        <flux:separator />

                                        {{-- Description --}}
                                        <div class="rounded-lg bg-zinc-50 p-4 dark:bg-zinc-800">

                                            <flux:text class="leading-relaxed">
                                                {{ $saving->description }}
                                            </flux:text>

                                        </div>

                                        {{-- Footer --}}
                                        <div class="flex justify-end">

                                            <flux:modal.close>

                                                <flux:button variant="ghost">
                                                    Tutup
                                                </flux:button>

                                            </flux:modal.close>

                                        </div>

                                    </div>

                                </flux:modal>
                            @else
                                <span class="text-zinc-400">
                                    -
                                </span>
                            @endif

                        </flux:table.cell>

                        {{-- Aksi --}}
                        <flux:table.cell>

                            <div class="flex justify-end">

                                @if (in_array($saving->type, [\App\Enums\SavingType::Opening, \App\Enums\SavingType::Assistance], true))
                                    <div class="flex gap-1">

                                        <flux:button size="sm" variant="ghost" icon="pencil-square"
                                            wire:click="edit({{ $saving->id }})" tooltip="Edit simpanan" />

                                        <flux:button size="sm" variant="ghost" icon="trash"
                                            class="text-red-500 hover:text-red-600"
                                            wire:click="confirmDelete({{ $saving->id }})" tooltip="Hapus simpanan" />

                                    </div>
                                @else
                                    <flux:badge color="zinc" size="sm">
                                        Otomatis
                                    </flux:badge>
                                @endif

                        </flux:table.cell>

                    </flux:table.row>

                @empty

                    <flux:table.row>

                        <flux:table.cell colspan="11">

                            <div class="flex flex-col items-center justify-center py-12 text-center">

                                <flux:icon name="banknotes" class="size-10 text-zinc-400" />

                                <flux:heading size="sm" class="mt-3">
                                    Belum ada data simpanan
                                </flux:heading>

                                <flux:text class="mt-1">
                                    Belum terdapat transaksi simpanan.
                                </flux:text>

                                <flux:button class="mt-4" variant="primary" icon="plus" wire:click="create">
                                    Tambah Simpanan
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
        {{ $savings->links() }}
    </div>

    {{-- Form --}}
    <livewire:saving.form />

</div>
