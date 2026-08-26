    <flux:modal wire:model="showFormModal" class="md:w-3xl">

        <form wire:submit="save">

            <div class="space-y-6">
                <div>

                    <flux:heading size="lg">
                        {{ $isEdit ? 'Edit Rapat' : 'Tambah Rapat' }}
                    </flux:heading>

                    <flux:text>
                        Lengkapi data tempat rapat.
                    </flux:text>

                </div>

                <div class="grid grid-cols-2 gap-4">

                    <flux:input label="Tempat" wire:model="place" />

                    <flux:input type="date" label="Waktu" wire:model="meeting_date" />

                </div>

                <div class="flex justify-end gap-2">

                    <flux:button variant="ghost" wire:click="$set('showFormModal', false)">
                        Batal
                    </flux:button>

                    <flux:button type="submit" variant="primary">
                        Simpan
                    </flux:button>
                    
                </div>
            </div>

        </form>

    </flux:modal>
