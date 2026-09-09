{{-- Meeting Form --}}
<flux:modal wire:model="showFormModal" class="w-sm md:w-3xl" :dismissible="false">
    <form wire:submit="save">

        <div class="space-y-5">

            {{-- Header --}}
            <header>
                <flux:heading size="lg">
                    @if ($isEdit)
                        {{ __('app.actions.edit') }} {{ __('app.meeting.singular') }}
                    @else
                        {{ __('app.actions.add') }} {{ __('app.meeting.singular') }}
                    @endif
                </flux:heading>

                <flux:text class="mt-1">
                    {{ $isEdit ? __('app.meeting.form_edit_description') : __('app.meeting.form_create_description') }}
                </flux:text>
            </header>

            {{-- Information --}}
            <section class="space-y-4">
                <div>
                    <flux:heading size="sm">
                        {{ __('app.meeting.information') }}
                    </flux:heading>

                    <flux:text size="sm" class="mt-1">
                        {{ __('app.meeting.information_description') }}
                    </flux:text>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                    <flux:field>
                        <flux:input :label="__('app.meeting.place')" wire:model="place"
                            placeholder="Contoh: Balai Desa" />

                        <flux:error name="place" />
                    </flux:field>

                    <flux:field>
                        <flux:input type="datetime-local" :label="__('app.meeting.date')" wire:model="meeting_date" />

                        <flux:error name="meeting_date" />
                    </flux:field>

                </div>
            </section>

            <flux:separator />

            {{-- Footer --}}
            <footer class="flex justify-end gap-2">
                <flux:button type="button" variant="ghost" wire:click="$set('showFormModal', false)">
                    {{ __('app.actions.cancel') }}
                </flux:button>

                <flux:button type="submit" variant="primary">
                    @if ($isEdit)
                        {{ __('app.actions.update') }} {{ __('app.meeting.singular') }}
                    @else
                        {{ __('app.actions.save') }} {{ __('app.meeting.singular') }}
                    @endif
                </flux:button>
            </footer>

        </div>

    </form>
</flux:modal>