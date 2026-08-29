<flux:modal wire:model="showFormModal" class="md:w-3xl">

    <form wire:submit="save">

        <div class="space-y-5">

            {{-- Header --}}
            <div>
                <flux:heading size="lg">
                    {{ $isEdit ? 'Edit Rapat' : 'Tambah Rapat' }}
                </flux:heading>

                <flux:text class="mt-1">
                    {{ $isEdit ? 'Perbarui informasi jadwal rapat.' : 'Lengkapi data tempat dan waktu rapat.' }}
                </flux:text>
            </div>

            {{-- Informasi Rapat --}}
            <div class="space-y-4">

                <div>
                    <flux:heading size="sm">
                        Informasi Rapat
                    </flux:heading>

                    <flux:text size="sm" class="mt-1">
                        Tentukan tempat dan waktu pelaksanaan rapat.
                    </flux:text>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                    {{-- Tempat --}}
                    <flux:field>
                        <flux:input label="Tempat" wire:model="place" placeholder="Contoh: Balai Desa" />
                        <flux:error name="place" />
                    </flux:field>

                    {{-- Waktu --}}
                    <flux:field>
                        <flux:input type="datetime-local" label="Waktu" wire:model="meeting_date" />
                        <flux:error name="meeting_date" />
                    </flux:field>

                </div>

            </div>

            <flux:separator />

            {{-- Footer --}}
            <div class="flex justify-end gap-2">

                <flux:button type="button" variant="ghost" wire:click="$set('showFormModal', false)">
                    Batal
                </flux:button>

                <flux:button type="submit" variant="primary">
                    {{ $isEdit ? 'Update Rapat' : 'Simpan Rapat' }}
                </flux:button>

            </div>

        </div>

    </form>

</flux:modal>