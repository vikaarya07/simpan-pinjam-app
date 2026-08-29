<flux:modal wire:model="showFormModal" class="md:w-3xl">

    <form wire:submit="save">

        <div class="space-y-5">

            {{-- Header --}}
            <div>
                <flux:heading size="lg">
                    {{ $isEdit ? 'Edit Anggota' : 'Tambah Anggota' }}
                </flux:heading>

                <flux:text class="mt-1">
                    {{ $isEdit ? 'Perbarui informasi data anggota.' : 'Lengkapi data anggota untuk mendaftarkan anggota baru.' }}
                </flux:text>
            </div>


            {{-- Data Pribadi --}}
            <div class="space-y-4">

                <div>
                    <flux:heading size="sm">
                        Data Pribadi
                    </flux:heading>

                    <flux:text size="sm" class="mt-1">
                        Informasi dasar anggota.
                    </flux:text>
                </div>


                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                    {{-- Nama --}}
                    <flux:field>

                        <flux:input label="Nama" wire:model="name" placeholder="Nama lengkap" />

                        <flux:error name="name" />

                    </flux:field>


                    {{-- Email --}}
                    <flux:field>

                        <flux:input label="Email" type="email" wire:model="email" placeholder="nama@email.com" />

                        <flux:error name="email" />

                    </flux:field>


                    {{-- Phone --}}
                    <flux:field>

                        <flux:input label="No. HP" wire:model="phone" placeholder="08xxxxxxxxxx" />

                        <flux:error name="phone" />

                    </flux:field>


                    {{-- Gender --}}
                    <flux:field>

                        <flux:select label="Jenis Kelamin" wire:model="gender">

                            <option value="" selected disabled>-- Pilih Jenis Kelamin --</option>

                            @foreach (\App\Enums\Gender::cases() as $genderOption)
                                <option value="{{ $genderOption->value }}">
                                    {{ $genderOption->label() }}
                                </option>
                            @endforeach

                        </flux:select>

                        <flux:error name="gender" />

                    </flux:field>


                    {{-- Date Birth --}}
                    <flux:field>

                        <flux:input type="date" label="Tanggal Lahir" wire:model="date_birth" />

                        <flux:error name="date_birth" />

                    </flux:field>


                    {{-- Date Join --}}
                    <flux:field>

                        <flux:input type="date" label="Tanggal Bergabung" wire:model="date_join" />

                        <flux:error name="date_join" />

                    </flux:field>

                </div>

            </div>


            <flux:separator />


            {{-- Keanggotaan --}}
            <div class="space-y-4">

                <div>
                    <flux:heading size="sm">
                        Keanggotaan
                    </flux:heading>

                    <flux:text size="sm" class="mt-1">
                        Status keanggotaan anggota.
                    </flux:text>
                </div>


                <flux:field>

                    <flux:select label="Status" wire:model="status">

                        @foreach (\App\Enums\MemberStatus::cases() as $statusOption)
                            <option value="{{ $statusOption->value }}">
                                {{ $statusOption->label() }}
                            </option>
                        @endforeach

                    </flux:select>

                    <flux:error name="status" />

                </flux:field>

            </div>


            {{-- Footer --}}
            <div class="flex justify-end gap-2 pt-2">

                <flux:button type="button" variant="ghost" wire:click="$set('showFormModal', false)">
                    Batal
                </flux:button>

                <flux:button type="submit" variant="primary">
                    {{ $isEdit ? 'Update Anggota' : 'Simpan Anggota' }}
                </flux:button>

            </div>

        </div>

    </form>

</flux:modal>