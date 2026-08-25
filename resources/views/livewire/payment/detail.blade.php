<div class="space-y-6">

    <flux:heading size="xl">
        Detail Pinjaman
    </flux:heading>

    <flux:card>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <div class="text-sm text-gray-500 font-bold">No Pinjaman</div>
                <div class="font-medium">{{ $payment->loan->loan_number }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-500 font-bold">Waktu</div>
                <div>{{ $payment->waktu }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-500 font-bold">Nasabah</div>
                <div class="font-semibold">{{ $payment->loan->member->name }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-500 font-bold">Status</div>
                <flux:badge :color="$payment->status === 'clear' ? 'green' : 'red'">
                    {{ strtoupper($payment->status) }}
                </flux:badge>
            </div>

            <div>
                <div class="text-sm text-gray-500 font-bold">Pokok Pinjaman</div>
                <div>{{ idr($payment->loan->principal) }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-500 font-bold">Pembayaran ke-{{ $payment->payment_count }}</div>
                <div class="font-bold">
                    {{ idr($payment->amount) }}
                </div>
            </div>

            <div>
                <div class="text-sm text-gray-500 font-bold">Total</div>
                <div>{{ idr($payment->loan->amount) }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-500 font-bold">Sudah Dibayar</div>
                <div class="font-bold text-green-600">
                    {{ idr($this->totalPaid) }}
                </div>
            </div>

            <div>
                <div class="text-sm text-gray-500 font-bold">Sisa Hutang</div>
                <div class="font-bold text-red-600">
                    {{ idr($this->remaining) }}
                </div>
            </div>

            <div>
                <div class="text-sm text-gray-500 font-bold">Catatan</div>
                <div>{{ $payment?->note ?? '-' }}</div>
            </div>

        </div>

    </flux:card>

</div>
