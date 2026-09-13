{{-- Loan Form Modal --}}
<flux:modal wire:model="showFormModal" class="w-sm md:w-3xl" :dismissible="false">

    <form wire:submit="save">
        <div class="flex max-h-[85vh] flex-col">

            {{-- Header --}}
            <header class="shrink-0 border-b border-zinc-200 pb-4 dark:border-zinc-700">
                <flux:heading size="lg">
                    @if ($isEdit)
                        {{ __('app.actions.edit') }} {{ __('app.loan.singular') }}
                    @else
                        {{ __('app.actions.add') }} {{ __('app.loan.singular') }}
                    @endif
                </flux:heading>

                <flux:text class="mt-1">
                    {{ $isEdit ? __('app.loan.form_edit_description') : __('app.loan.form_create_description') }}
                </flux:text>
            </header>

            {{-- Content --}}
            <div class="min-h-0 flex-1 overflow-y-auto px-1 py-5">
                <div class="space-y-6">

                    {{-- Loan Information --}}
                    <section class="space-y-4">
                        <div>
                            <flux:heading size="sm">
                                {{ __('app.loan.information') }}
                            </flux:heading>

                            <flux:text size="sm" class="mt-1">
                                {{ __('app.loan.information_description') }}
                            </flux:text>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                            <flux:field>
                                <flux:select :label="__('app.loan.name')" wire:model.live="member_id"
                                    :disabled="$isEdit">
                                    <option value="" selected disabled>
                                        -- {{ __('app.loan.form_select') }} --
                                    </option>

                                    @foreach ($members as $member)
                                        <option value="{{ $member->id }}">
                                            {{ $member->npk }} - {{ $member->name }}
                                        </option>
                                    @endforeach
                                </flux:select>
                            </flux:field>

                            <flux:field>
                                <flux:input :label="__('app.loan.loan_number')" wire:model="loan_number" readonly />
                            </flux:field>

                            <flux:field>
                                <flux:select :label="__('app.loan.type_loan')" wire:model="type">
                                    @foreach (\App\Enums\LoanType::cases() as $typeOption)
                                        <option value="{{ $typeOption->value }}">
                                            {{ $typeOption->label() }}
                                        </option>
                                    @endforeach
                                </flux:select>
                            </flux:field>

                            <flux:field>
                                <flux:input type="date" :label="__('app.loan.date_loan')" wire:model="loan_date" />
                            </flux:field>

                        </div>
                    </section>

                    <flux:separator />

                    {{-- Loan Value --}}
                    <section class="space-y-4">
                        <div>
                            <flux:heading size="sm">
                                {{ __('app.loan.information_value') }}
                            </flux:heading>

                            <flux:text size="sm" class="mt-1">
                                {{ __('app.loan.information_value_description') }}
                            </flux:text>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                            <flux:field class="sm:col-span-2">
                                <flux:input :label="__('app.loan.principal')" wire:model.live="principalFormatted"
                                    inputmode="integer" placeholder="0" />
                                <flux:error name="principal" />
                            </flux:field>

                            <flux:input :label="__('app.loan.interest')"
                                :value="$interest_percent.
                                '%'" readonly />

                            <flux:input :label="__('app.loan.interest_amount')" :value="idr($interest_amount)"
                                readonly />

                            <div class="sm:col-span-2">
                                <flux:card class="bg-zinc-50 dark:bg-zinc-800/50">
                                    <div class="flex items-center justify-between gap-4">
                                        <div>
                                            <flux:text size="sm">
                                                {{ __('app.loan.amount') }}
                                            </flux:text>

                                            <flux:text size="xs" class="mt-1">
                                                {{ __('app.loan.principal') }}
                                                +
                                                {{ __('app.loan.interest') }}
                                            </flux:text>
                                        </div>

                                        <flux:heading size="lg" class="tabular-nums">
                                            {{ idr($amount) }}
                                        </flux:heading>
                                    </div>
                                </flux:card>
                            </div>

                        </div>
                    </section>

                    {{-- Previous Loan --}}
                    @if ($previousLoan)
                        <flux:separator />

                        <flux:card>
                            <section class="space-y-4">

                                <div>
                                    <flux:heading size="sm">
                                        {{ __('app.loan.previous_loan') }}
                                    </flux:heading>

                                    <flux:text size="sm" class="mt-1">
                                        {{ __('app.loan.previous_loan_description') }}
                                    </flux:text>
                                </div>

                                <div class="divide-y divide-zinc-200 dark:divide-zinc-700">

                                    <div class="flex items-center justify-between gap-4 py-3">
                                        <flux:text>
                                            {{ __('app.loan.loan_number') }}
                                        </flux:text>

                                        <flux:text class="font-medium">
                                            {{ $previousLoan->loan_number }}
                                        </flux:text>
                                    </div>

                                    <div class="flex items-center justify-between gap-4 py-3">
                                        <flux:text>
                                            {{ __('app.loan.remaining') }}
                                        </flux:text>

                                        <flux:text class="font-semibold tabular-nums text-red-600 dark:text-red-400">
                                            {{ idr($previousLoan->remaining) }}
                                        </flux:text>
                                    </div>

                                    <div class="flex items-center justify-between gap-4 py-3">
                                        <flux:text>
                                            {{ __('app.loan.previous_loan_disbursement') }}
                                        </flux:text>

                                        <flux:text class="font-bold tabular-nums text-green-600 dark:text-green-400">
                                            {{ idr($disbursement) }}
                                        </flux:text>
                                    </div>

                                </div>
                            </section>
                        </flux:card>
                    @endif

                </div>
            </div>

            {{-- Footer --}}
            <footer class="shrink-0 border-t border-zinc-200 pt-4 dark:border-zinc-700">
                <div class="flex justify-end gap-2">

                    <flux:button type="button" variant="ghost" wire:click="closeModal">
                        {{ __('app.actions.cancel') }}
                    </flux:button>

                    <flux:button type="submit" variant="primary">
                        {{ $isEdit ? __('app.actions.update') : __('app.actions.save') }}
                    </flux:button>

                </div>
            </footer>

        </div>
    </form>

</flux:modal>
