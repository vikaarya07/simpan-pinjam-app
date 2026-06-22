    <flux:modal wire:model="showFormModal" class="md:w-3xl">

        <form wire:submit="save">

            <div class="space-y-6">

                <div>

                    <flux:heading size="lg">

                        {{ $isEdit ? 'Edit Member' : 'Tambah Member' }}

                    </flux:heading>

                    <flux:text>
                        Lengkapi data anggota.
                    </flux:text>

                </div>

                <div class="grid grid-cols-2 gap-4">

                    <flux:input label="Nama" wire:model="name" />

                    <flux:input label="Email" type="email" wire:model="email" />

                    <flux:input label="No HP" wire:model="phone" />

                    <flux:select label="Jenis Kelamin" wire:model="gender">

                        <option value="">Pilih</option>
                        <option value="Male">Laki-laki</option>
                        <option value="Female">Perempuan</option>

                    </flux:select>

                    <flux:input type="date" label="Tanggal Lahir" wire:model="date_birth" />

                    <flux:input type="date" label="Tanggal Bergabung" wire:model="date_join" />

                    <flux:select label="Status" wire:model="status">
                        <option value="Active">Aktif</option>
                        <option value="Inactive">Nonaktif</option>
                    </flux:select>

                </div>

                <div class="flex justify-end gap-2">

                    <flux:button variant="ghost" wire:click="$set('showFormModal', false)">
                        Batal
                    </flux:button>

                    <flux:button type="submit" variant="primary">
                        {{ $isEdit ? 'Update' : 'Simpan' }}
                    </flux:button>

                </div>

            </div>

        </form>

    </flux:modal>
