<flux:modal wire:model="showFormModal" class="md:w-3xl">

    <form wire:submit="save">
        <div class="space-y-6">

            <div>
                <flux:heading size="lg">
                    {{ $isEdit ? 'Edit Transaksi' : 'Tambah Transaksi' }}
                </flux:heading>

                <flux:text>
                    {{ $isEdit ? 'Perbarui data transaksi kas.' : 'Masukkan transaksi kas baru.' }}
                </flux:text>
            </div>

            <div class="grid grid-cols-2 gap-4">

                {{-- Tanggal --}}
                <flux:field>
                    <flux:input label="Tanggal Transaksi" type="date" wire:model="transaction_date" />
                    <flux:error name="transaction_date" />
                </flux:field>


                {{-- Jenis --}}
                <flux:field>
                    <flux:select label="Jenis Transaksi" wire:model="type">
                        <option value="" selected disabled>-- Pilih Jenis Transaksi --</option>
                        <option value="Opening">Pembukaan</option>
                        <option value="Assistance">Bantuan</option>
                    </flux:select>
                    <flux:error name="type" />
                </flux:field>


                {{-- Nominal --}}
                <flux:field>
                    <flux:input label="Nominal" wire:model.live="amountFormatted" inputmode="numeric" placeholder="0" />
                    <flux:error name="amount" />
                </flux:field>

            </div>

            {{-- Keterangan --}}
            <flux:field>
                <flux:textarea label="Keterangan" wire:model="description" rows="3" class="resize-y"
                    placeholder="Masukkan keterangan..." />

                <flux:error name="description" />
            </flux:field>

            {{-- Button --}}
            <div class="flex justify-end gap-2">

                <flux:button type="button" variant="ghost" wire:click="close">
                    Batal
                </flux:button>

                <flux:button type="submit" variant="primary">
                    {{ $isEdit ? 'Perbarui' : 'Simpan' }}
                </flux:button>

            </div>

        </div>
    </form>

</flux:modal>
