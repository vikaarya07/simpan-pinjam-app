<flux:modal wire:model="showFormModal" class="md:w-3xl">

    <form wire:submit="save">

        <div class="space-y-5">

            {{-- Header --}}
            <div>
                <flux:heading size="lg">
                    {{ $isEdit ? 'Edit Transaksi' : 'Tambah Transaksi' }}
                </flux:heading>

                <flux:text class="mt-1">
                    {{ $isEdit ? 'Perbarui data transaksi kas.' : 'Masukkan transaksi kas baru.' }}
                </flux:text>
            </div>

            {{-- Informasi Transaksi --}}
            <div class="space-y-4">

                <div>
                    <flux:heading size="sm">
                        Informasi Transaksi
                    </flux:heading>

                    <flux:text size="sm" class="mt-1">
                        Tentukan tanggal, jenis, dan nominal transaksi.
                    </flux:text>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                    {{-- Tanggal --}}
                    <flux:field>

                        <flux:input label="Tanggal Transaksi" type="date" wire:model="transaction_date" />

                        <flux:error name="transaction_date" />

                    </flux:field>

                    {{-- Jenis --}}
                    <flux:field>

                        <flux:select label="Jenis Transaksi" wire:model="type">

                            <option value="" selected disabled>-- Pilih Jenis Transaksi --</option>

                            @foreach ([\App\Enums\SavingType::Opening, \App\Enums\SavingType::Assistance] as $typeOption)
                                <option value="{{ $typeOption->value }}">
                                    {{ $typeOption->label() }}
                                </option>
                            @endforeach

                        </flux:select>

                        <flux:error name="type" />

                    </flux:field>

                    {{-- Nominal --}}
                    <flux:field class="sm:col-span-2">

                        <flux:input label="Nominal" wire:model.live="amountFormatted" inputmode="numeric"
                            placeholder="0" />

                        <flux:error name="amount" />

                    </flux:field>

                </div>

            </div>

            <flux:separator />

            {{-- Keterangan --}}
            <div class="space-y-4">

                <div>
                    <flux:heading size="sm">
                        Keterangan
                    </flux:heading>

                    <flux:text size="sm" class="mt-1">
                        Tambahkan catatan jika diperlukan.
                    </flux:text>
                </div>

                <flux:field>

                    <flux:textarea label="Keterangan" wire:model="description" rows="auto"
                        placeholder="Masukkan keterangan..." />

                    <flux:error name="description" />

                </flux:field>

            </div>

            {{-- Footer --}}
            <div class="flex justify-end gap-2 pt-2">

                <flux:button type="button" variant="ghost" wire:click="close">
                    Batal
                </flux:button>

                <flux:button type="submit" variant="primary">
                    {{ $isEdit ? 'Perbarui Transaksi' : 'Simpan Transaksi' }}
                </flux:button>

            </div>

        </div>

    </form>

</flux:modal>
