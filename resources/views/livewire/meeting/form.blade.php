<flux:modal wire:model="showFormModal" class="w-sm md:w-3xl" :dismissible="false">

    <form wire:submit="save">

        <div class="space-y-5">

            {{-- Header --}}
            <div>
                <flux:heading size="lg">
                    {{ $isEdit ? __('app.actions.edit') . ' ' . __('app.meeting.singular') : __('app.actions.add') . ' ' . __('app.meeting.singular') }}
                </flux:heading>

                <flux:text class="mt-1">
                    {{ $isEdit ? __('app.meeting.form_edit_description') : __('app.meeting.form_create_description') }}
                </flux:text>
            </div>

            {{-- Informasi Rapat --}}
            <div class="space-y-4">

                <div>
                    <flux:heading size="sm">
                        {{ __('app.meeting.information') }}
                    </flux:heading>

                    <flux:text size="sm" class="mt-1">
                        {{ __('app.meeting.information_description') }}
                    </flux:text>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                    {{-- Tempat --}}
                    <flux:field>
                        <flux:input label="{{ __('app.meeting.place') }}" wire:model="place" placeholder="Contoh: Balai Desa" />
                        <flux:error name="place" />
                    </flux:field>

                    {{-- Waktu --}}
                    <flux:field>
                        <flux:input type="datetime-local" label="{{ __('app.meeting.date') . ' ' . __('app.meeting.singular') }}" wire:model="meeting_date" />
                        <flux:error name="meeting_date" />
                    </flux:field>

                </div>

            </div>

            <flux:separator />

            {{-- Footer --}}
            <div class="flex justify-end gap-2">

                <flux:button type="button" variant="ghost" wire:click="$set('showFormModal', false)">
                    {{ __('app.actions.cancel') }}
                </flux:button>

                <flux:button type="submit" variant="primary">
                    {{ $isEdit ? __('app.actions.update') . ' ' . __('app.meeting.singular') : __('app.actions.save') . ' ' . __('app.meeting.singular') }}
                </flux:button>

            </div>

        </div>

    </form>

</flux:modal>