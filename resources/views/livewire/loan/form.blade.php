<flux:modal wire:model="showFormModal" class="w-sm md:w-3xl" :dismissible="false">
    <div class="flex max-h-[85vh] flex-col">

        {{-- HEADER --}}
        <div class="shrink-0 border-b border-zinc-200 pb-4 dark:border-zinc-700">
            <flux:heading size="lg">
                {{ $isEdit ? 'Edit Pinjaman' : 'Buat Pinjaman Baru' }}
            </flux:heading>

            <flux:text class="mt-1">
                {{ $isEdit ? 'Perbarui informasi pinjaman anggota.' : 'Lengkapi data untuk membuat pinjaman baru.' }}
            </flux:text>
        </div>

        {{-- CONTENT SCROLL --}}
        <div class="min-h-0 flex-1 overflow-y-auto">
            <form id="loan-form" wire:submit="save" class="px-1 py-5">
                <div class="space-y-5">

                    {{-- INFORMASI PINJAMAN --}}
                    <div class="space-y-4">

                        <div>
                            <flux:heading size="sm">
                                Informasi Pinjaman
                            </flux:heading>

                            <flux:text size="sm" class="mt-1">
                                Tentukan anggota, jenis, tanggal, dan pokok pinjaman.
                            </flux:text>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                            {{-- Anggota --}}
                            <flux:field>
                                <flux:select label="Anggota" wire:model.live="member_id" :disabled="$isEdit">
                                    <option value="">-- Pilih Anggota --</option>

                                    @foreach ($members as $member)
                                        <option value="{{ $member->id }}">
                                            {{ $member->npk }} - {{ $member->name }}
                                        </option>
                                    @endforeach
                                </flux:select>

                                <flux:error name="member_id" />
                            </flux:field>

                            {{-- Nomor Pinjaman --}}
                            <flux:field>
                                <flux:input label="Nomor Pinjaman" wire:model="loan_number" readonly />

                                <flux:error name="loan_number" />
                            </flux:field>

                            {{-- Jenis Pinjaman --}}
                            <flux:field>
                                <flux:select label="Jenis Pinjaman" wire:model.live="type">
                                    @foreach (\App\Enums\LoanType::cases() as $typeOption)
                                        <option value="{{ $typeOption->value }}">
                                            {{ $typeOption->label() }}
                                        </option>
                                    @endforeach
                                </flux:select>

                                <flux:error name="type" />
                            </flux:field>

                            {{-- Tanggal Pinjaman --}}
                            <flux:field>
                                <flux:input type="date" label="Tanggal Pinjaman" wire:model.live="loan_date" />

                                <flux:error name="loan_date" />
                            </flux:field>

                        </div>
                    </div>

                    <flux:separator />

                    {{-- NILAI PINJAMAN --}}
                    <div class="space-y-4">

                        <div>
                            <flux:heading size="sm">
                                Nilai Pinjaman
                            </flux:heading>

                            <flux:text size="sm" class="mt-1">
                                Masukkan pokok pinjaman. Jasa dan total dihitung otomatis.
                            </flux:text>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                            {{-- Pokok --}}
                            <flux:field class="sm:col-span-2">
                                <flux:input label="Pokok Pinjaman" wire:model.live="principalFormatted"
                                    inputmode="numeric" placeholder="0" />

                                <flux:error name="principal" />
                                <flux:error name="principalFormatted" />
                            </flux:field>

                            {{-- Jasa --}}
                            <flux:input label="Jasa" :value="$interest_percent.
                            '%'"
                                readonly />

                            {{-- Nominal Jasa --}}
                            <flux:input label="Nominal Jasa" :value="idr($interest_amount)" readonly />

                            {{-- Total --}}
                            <div class="sm:col-span-2">
                                <flux:card class="bg-zinc-50 dark:bg-zinc-800/50">
                                    <div class="flex items-center justify-between gap-4">

                                        <div>
                                            <flux:text size="sm">
                                                Total Pinjaman
                                            </flux:text>

                                            <flux:text size="xs" class="mt-1">
                                                Pokok + jasa
                                            </flux:text>
                                        </div>

                                        <flux:heading size="lg" class="tabular-nums">
                                            {{ idr($amount) }}
                                        </flux:heading>

                                    </div>
                                </flux:card>
                            </div>

                        </div>
                    </div>

                    {{-- PINJAMAN SEBELUMNYA --}}
                    @if ($previousLoan)
                        <flux:separator />

                        <flux:card>
                            <div class="space-y-4">

                                <div>
                                    <flux:heading size="sm">
                                        Pinjaman Sebelumnya
                                    </flux:heading>

                                    <flux:text size="sm" class="mt-1">
                                        Ringkasan pinjaman anggota sebelumnya.
                                    </flux:text>
                                </div>

                                <div class="divide-y divide-zinc-200 dark:divide-zinc-700">

                                    {{-- Nomor --}}
                                    <div class="flex items-center justify-between gap-4 py-3">

                                        <flux:text>
                                            Nomor Pinjaman
                                        </flux:text>

                                        <flux:text class="font-medium">
                                            {{ $previousLoan->loan_number }}
                                        </flux:text>

                                    </div>

                                    {{-- Sisa Hutang --}}
                                    <div class="flex items-center justify-between gap-4 py-3">

                                        <flux:text>
                                            Sisa Hutang
                                        </flux:text>

                                        <flux:text class="font-semibold tabular-nums text-red-600 dark:text-red-400">
                                            {{ idr($previousLoan->remaining) }}
                                        </flux:text>

                                    </div>

                                    {{-- Dana Dicairkan --}}
                                    <div class="flex items-center justify-between gap-4 py-3">

                                        <flux:text>
                                            Dana Dicairkan
                                        </flux:text>

                                        <flux:text class="font-bold tabular-nums text-green-600 dark:text-green-400">
                                            {{ idr($disbursement) }}
                                        </flux:text>

                                    </div>

                                </div>

                            </div>
                        </flux:card>
                    @endif

                </div>
            </form>
        </div>

        {{-- FOOTER --}}
        <div class="shrink-0 border-t border-zinc-200 pt-4 dark:border-zinc-700">

            <div class="flex justify-end gap-2">

                {{-- Batal --}}
                <flux:button type="button" variant="ghost" wire:click="closeModal">
                    Batal
                </flux:button>

                {{-- Simpan --}}
                <flux:button type="submit" form="loan-form" variant="primary">
                    {{ $isEdit ? 'Update Pinjaman' : 'Simpan Pinjaman' }}
                </flux:button>

            </div>

        </div>

    </div>
</flux:modal>
