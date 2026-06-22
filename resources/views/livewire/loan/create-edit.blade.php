<flux:modal wire:model="showFormModal" class="md:w-3xl">

    <form wire:submit="save">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">
                    {{ $isEdit ? 'Edit Pinjaman' : 'Tambah Pinjaman' }}
                </flux:heading>
                <flux:text>
                    Lengkapi data pinjaman.
                </flux:text>
            </div>
            <div class="grid grid-cols-2 gap-4">

                <flux:select label="Anggota" wire:model.live="member_id">
                    <option value="">Pilih Anggota</option>
                    @foreach ($members as $member)
                        <option value="{{ $member->id }}">
                            {{ $member->npk }} - {{ $member->name }}
                        </option>
                    @endforeach
                </flux:select>

                <flux:input label="Nomor Pinjaman" wire:model="loan_number" readonly />

                <flux:select label="Jenis Pinjaman" wire:model.live="type">
                    <option value="" disabled>-- Pilih --</option>
                    <option value="loan">Pinjaman</option>
                    <option value="loan_overdue">Telat</option>
                </flux:select>

                <flux:input type="date" label="Tanggal Pinjaman" wire:model="loan_date" />

                <flux:input label="Pokok Pinjaman" wire:model.live="principal" />

                <flux:input label="Jasa" :value="$interest_percent.
                '%'" readonly />

                <flux:input label="Nominal Jasa" wire:model="interest_amount" readonly />

                <flux:input label="Total Pinjaman" wire:model="amount" readonly />
            </div>
            @if ($previousLoan)
                <flux:card>
                    <div class="space-y-2">

                        <div class="flex justify-between">
                            <span>Pinjaman Sebelumnya</span>
                            <span>{{ $previousLoan->loan_number }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span>Sisa Hutang</span>
                            <span>{{ idr($previousLoan->remaining) }}</span>
                        </div>

                        <div class="flex justify-between font-semibold">
                            <span>Dana Dicairkan</span>
                            <span>{{ idr($disbursement) }}</span>
                        </div>

                    </div>
                </flux:card>
            @endif
            <div class="flex justify-end gap-2">
                <flux:button variant="ghost" wire:click="closeModal">
                    Batal
                </flux:button>
                <flux:button type="submit" variant="primary">
                    {{ $isEdit ? 'Update' : 'Simpan' }}
                </flux:button>
            </div>
        </div>
    </form>

</flux:modal>
