<flux:modal wire:model="showFormModal" class="w-sm md:w-3xl" :dismissible="false">
    <form wire:submit="save" class="flex max-h-[85vh] flex-col">

        {{-- Header --}}
        <div class="shrink-0 pb-5">
            <flux:heading size="lg">
                {{ $isEdit ? __('app.actions.edit') . ' ' . __('app.payment.show.singular') : __('app.actions.add') . ' ' . __('app.payment.show.singular') }}
            </flux:heading>

            <flux:text class="mt-1">
                {{ __('app.payment.show.form_description') }}
            </flux:text>
        </div>

        {{-- CONTENT --}}
        <div class="min-h-0 flex-1 space-y-5 overflow-y-auto py-2 px-1">

            {{-- Informasi Pinjaman --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                <flux:input label="{{ __('app.payment.show.meet') }}" :value="$meeting?->place" readonly />

                <flux:input label="{{ __('app.payment.show.loan_number') }}" :value="$loan?->loan_number" readonly />

                <flux:input label="{{ __('app.payment.show.name') }}" :value="$loan?->member?->name" readonly />

                <flux:input label="{{ __('app.payment.show.singular') . ' ' . __('app.payment.show.to') }}"
                    :value="$isEdit? $payment?->payment_count: $loan?->next_payment_count" readonly />

                <flux:input label="{{ __('app.payment.show.amount') }}" :value="$loan ? idr($loan->amount) : ''"
                    readonly />

                <flux:input label="{{ __('app.payment.show.remaining') }}" :value="$loan ? idr($loan->remaining) : ''"
                    readonly />

            </div>

            {{-- Pembayaran --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                <div>
                    <flux:input label="{{ __('app.payment.show.payment_amount') }}" wire:model.live="amountFormatted"
                        placeholder="0" inputmode="numeric" />

                    @error('amount')
                        <flux:error name="amount">
                            {{ $message }}
                        </flux:error>
                    @enderror
                </div>

                <flux:input label="{{ __('app.payment.show.date') }}" type="date" wire:model="payment_date" />

                @if ($amount > 0)
                    <flux:select label="{{ __('app.payment.show.method') }}" wire:model="method">
                        <option value="" disabled>
                            -- {{ __('app.payment.show.form_select') }} --
                        </option>

                        @foreach (\App\Enums\PaymentMethod::cases() as $paymentMethod)
                            <option value="{{ $paymentMethod->value }}">
                                {{ $paymentMethod->label() }}
                            </option>
                        @endforeach
                    </flux:select>
                @endif

            </div>

            {{-- Catatan --}}
            <flux:field>
                <flux:textarea label="{{ __('app.payment.show.note') }}" wire:model="note" rows="auto"
                    placeholder="{{ __('app.payment.show.note_value') }}" />

                <flux:error name="note" />
            </flux:field>

        </div>

        {{-- FOOTER --}}
        <div class="shrink-0 pt-5">
            <div class="flex justify-end gap-2">

                <flux:button variant="ghost" type="button" wire:click="closeModal">
                    {{ __('app.actions.cancel') }}
                </flux:button>

                <flux:button variant="primary" type="submit">
                    {{ $isEdit ? __('app.actions.update') : __('app.actions.save') }}
                </flux:button>

            </div>
        </div>

    </form>
</flux:modal>
