<flux:modal wire:model="showFormModal" class="w-sm md:w-3xl" :dismissible="false">
    <form wire:submit="save" class="flex max-h-[85vh] flex-col">

        {{-- Header --}}
        <div class="shrink-0 pb-5">
            <flux:heading size="lg">
                {{ $isEdit ? 'Ubah Angsuran' : 'Bayar Angsuran' }}
            </flux:heading>

            <flux:text class="mt-1">
                Pembayaran angsuran pinjaman
            </flux:text>
        </div>

        {{-- CONTENT --}}
        <div class="min-h-0 flex-1 space-y-5 overflow-y-auto py-2 px-1">

            {{-- Informasi Pinjaman --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                <flux:input label="Pertemuan" :value="$meeting?->place" readonly />

                <flux:input label="Nomor Pinjaman" :value="$loan?->loan_number" readonly />

                <flux:input label="Nasabah" :value="$loan?->member?->name" readonly />

                <flux:input label="Pembayaran Ke" :value="$isEdit? $payment?->payment_count: $loan?->next_payment_count"
                    readonly />

                <flux:input label="Total Hutang" :value="$loan ? idr($loan->amount) : ''" readonly />

                <flux:input label="Sisa Hutang" :value="$loan ? idr($loan->remaining) : ''" readonly />

            </div>

            {{-- Pembayaran --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                <div>
                    <flux:input label="Jumlah Bayar" wire:model.live="amountFormatted" placeholder="0"
                        inputmode="numeric" />

                    @error('amount')
                        <flux:error name="amount">
                            {{ $message }}
                        </flux:error>
                    @enderror
                </div>

                <flux:input label="Tanggal Pembayaran" type="date" wire:model="payment_date" />

                <flux:select label="Metode Pembayaran" wire:model="method">
                    <option value="" disabled>
                        -- Pilih Metode --
                    </option>

                    @foreach (\App\Enums\PaymentMethod::cases() as $paymentMethod)
                        <option value="{{ $paymentMethod->value }}">
                            {{ $paymentMethod->label() }}
                        </option>
                    @endforeach
                </flux:select>

            </div>

            {{-- Catatan --}}
            <flux:field>
                <flux:textarea label="Catatan" wire:model="note" rows="auto" placeholder="Masukkan catatan..." />

                <flux:error name="note" />
            </flux:field>

        </div>

        {{-- FOOTER --}}
        <div class="shrink-0 pt-5">
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
