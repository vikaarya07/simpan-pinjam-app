<flux:modal wire:model="showFormModal" class="w-sm md:w-3xl" :dismissible="false">

    <form wire:submit="save">
        <div class="space-y-5">

            {{-- Header --}}
            <div>
                <flux:heading size="lg">
                    @if ($isEdit)
                        {{ __('app.actions.edit') }} {{ __('app.saving.singular') }}
                    @else
                        {{ __('app.actions.add') }} {{ __('app.saving.singular') }}
                    @endif
                </flux:heading>

                <flux:text class="mt-1">
                    {{ $isEdit ? __('app.saving.form_edit_description') : __('app.saving.form_create_description') }}
                </flux:text>
            </div>

            {{-- Informasi Transaksi --}}
            <div class="space-y-4">
                <div>
                    <flux:heading size="sm">
                        {{ __('app.saving.information') }}
                    </flux:heading>

                    <flux:text size="sm" class="mt-1">
                        {{ __('app.saving.information_description') }}
                    </flux:text>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                    {{-- Tanggal --}}
                    <flux:field>
                        <flux:input label="{{ __('app.saving.transaction_date') }}" type="date"
                            wire:model="transaction_date" />

                        <flux:error name="transaction_date" />
                    </flux:field>

                    {{-- Jenis --}}
                    <flux:field>
                        <flux:select label="{{ __('app.saving.type') }}" wire:model="type">
                            <option value="" selected disabled>
                                -- {{ __('app.saving.form_select') }} --
                            </option>

                            @foreach ([\App\Enums\SavingType::Opening, \App\Enums\SavingType::Assistance] as $typeOption)
                                <option value="{{ $typeOption->value }}">
                                    {{ $typeOption->label() }}
                                </option>
                            @endforeach
                        </flux:select>

                        <flux:error name="type" />
                    </flux:field>

                    {{-- Nominal --}}
                    <flux:field class="sm:col-span-2">
                        <flux:input label="{{ __('app.saving.amount_input') }}" wire:model.live="amountFormatted"
                            inputmode="numeric" placeholder="0" />

                        <flux:error name="amount" />
                    </flux:field>

                </div>
            </div>

            <flux:separator />

            {{-- Keterangan --}}
            <div class="space-y-4">
                <div>
                    <flux:heading size="sm">
                        {{ __('app.saving.description') }}
                    </flux:heading>

                    <flux:text size="sm" class="mt-1">
                        {{ __('app.saving.information_value_description') }}
                    </flux:text>
                </div>

                <flux:field>
                    <flux:textarea label="{{ __('app.saving.description') }}" wire:model="description" rows="auto"
                        placeholder="{{ __('app.saving.description_placeholder') }}" />

                    <flux:error name="description" />
                </flux:field>
            </div>

            {{-- Footer --}}
            <div class="flex justify-end gap-2 pt-2">
                <flux:button type="button" variant="ghost" wire:click="close">
                    {{ __('app.actions.cancel') }}
                </flux:button>

                <flux:button type="submit" variant="primary">
                    {{ $isEdit ? __('app.actions.update') : __('app.actions.save') }}
                </flux:button>
            </div>

        </div>
    </form>

</flux:modal>