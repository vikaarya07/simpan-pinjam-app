<flux:modal wire:model="showFormModal" class="md:w-3xl">

    <form wire:submit="save">

        <div class="space-y-6">

            {{-- Header --}}
            <div>

                <flux:heading size="lg">
                    {{ $isEdit ? 'Edit Payment' : 'Tambah Payment' }}
                </flux:heading>

                <flux:text>
                    Catat pembayaran angsuran pinjaman.
                </flux:text>

            </div>

            {{-- Form --}}
            <div class="grid grid-cols-2 gap-4">

                {{-- Pertemuan --}}
                <flux:input label="Pertemuan" :value="$meeting?->place" readonly />

                {{-- Nomor Pinjaman --}}
                <flux:input label="Nomor Pinjaman" :value="$loan?->loan_number" readonly />

                {{-- Nama Nasabah --}}
                <flux:input label="Nasabah" :value="$loan?->member?->name" readonly />

                {{-- Pembayaran Ke --}} 
                <flux:input label="Pembayaran Ke" :value="$isEdit ? $payment?->payment_count : $loan?->next_payment_count"
                    readonly />

                {{-- Total Hutang --}}
                <flux:input label="Total Hutang" :value="$loan ? idr($loan->amount) : ''" readonly />

                {{-- Sisa Hutang --}}
                <flux:input label="Sisa Hutang" :value="$loan ? idr($loan->remaining) : ''" readonly />

                {{-- Jumlah Bayar --}}
                <flux:input label="Jumlah Bayar" type="number" wire:model.live="amount" />
                {{-- Tanggal Bayar --}}
                <flux:input label="Tanggal Pembayaran" type="date" wire:model="payment_date" />

                {{-- Metode --}}
                <flux:select label="Metode Pembayaran" wire:model="method">

                    <option value="cash">Cash</option>
                    <option value="transfer">Transfer</option>
                    <option value="qris">QRIS</option>

                </flux:select>

                {{-- Catatan --}}
                <flux:input label="Catatan" wire:model="note" placeholder="Opsional" />

            </div>

            {{-- Footer --}}
            <div class="flex justify-end gap-2">

                <flux:button variant="ghost" type="button" wire:click="closeModal">
                    Batal
                </flux:button>

                <flux:button variant="primary" type="submit">
                    {{ $isEdit ? 'Update' : 'Simpan' }}
                </flux:button>

            </div>

        </div>

    </form>

</flux:modal>
