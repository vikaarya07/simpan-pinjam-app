<flux:modal wire:model="showFormModal" class="md:w-3xl">

    <form wire:submit="save">

        <div class="space-y-5">

            {{-- Header --}}
            <div>
                <flux:heading size="lg">
                    {{ $isEdit ? 'Ubah Angsuran' : 'Bayar Angsuran' }}
                </flux:heading>

                <flux:text class="mt-1">
                    Pembayaran angsuran pinjaman
                </flux:text>
            </div>

            {{-- Informasi Pinjaman --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                <flux:input label="Pertemuan" :value="$meeting?->place" readonly />

                <flux:input label="Nomor Pinjaman" :value="$loan?->loan_number" readonly />

                <flux:input label="Nasabah" :value="$loan?->member?->name" readonly />

                <flux:input label="Pembayaran Ke"
                    :value="$isEdit? $payment?->payment_count: $loan?->next_payment_count"readonly />

                <flux:input label="Total Hutang" :value="$loan ? idr($loan->amount) : ''" readonly />

                <flux:input label="Sisa Hutang" :value="$loan ? idr($loan->remaining) : ''" readonly />

            </div>

            {{-- Pembayaran --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                <div>
                    <flux:input label="Jumlah Bayar" wire:model.live="amountFormatted" placeholder="0" />

                    @error('amount')
                        <flux:error name="amount">
                            {{ $message }}
                        </flux:error>
                    @enderror
                </div>

                <flux:input label="Tanggal Pembayaran" type="date" wire:model="payment_date" />

                <flux:select label="Metode Pembayaran" wire:model="method">

                    <option value="" selected disabled>-- Pilih Metode --</option>

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
