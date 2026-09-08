<flux:modal wire:model="showFormModal" class="w-sm md:w-3xl" :dismissible="false">

    <form wire:submit="save">

        <div class="flex max-h-[85vh] flex-col">

            {{-- HEADER --}}
            <div class="shrink-0 border-b border-zinc-200 pb-4 dark:border-zinc-700">
                <flux:heading size="lg">
                    {{ $isEdit ? __('app.actions.edit') . ' ' . __('app.loan.singular') : __('app.actions.create') . ' ' . __('app.loan.singular') }}
                </flux:heading>

                <flux:text class="mt-1">
                    {{ $isEdit ? __('app.loan.form_edit_description') : __('app.loan.form_create_description') }}
                </flux:text>
            </div>

            {{-- CONTENT SCROLL --}}
            <div class="min-h-0 flex-1 overflow-y-auto py-5 px-1">

                <div class="space-y-5">

                    {{-- INFORMASI PINJAMAN --}}
                    <div class="space-y-4">

                        <div>
                            <flux:heading size="sm">
                                {{ __('app.loan.information') }}
                            </flux:heading>

                            <flux:text size="sm" class="mt-1">
                                {{ __('app.loan.information_description') }}
                            </flux:text>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                            {{-- Anggota --}}
                            <flux:field>
                                <flux:select label="{{ __('app.loan.name') }}" wire:model.live="member_id"
                                    :disabled="$isEdit">
                                    <option value="">-- {{ __('app.loan.form_select') }} --</option>

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
                                <flux:input label="{{ __('app.loan.loan_number') }}" wire:model="loan_number"
                                    readonly />

                                <flux:error name="loan_number" />
                            </flux:field>

                            {{-- Jenis Pinjaman --}}
                            <flux:field>
                                <flux:select label="{{ __('app.loan.type') . ' ' . __('app.loan.singular') }}"
                                    wire:model.live="type">
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
                                <flux:input type="date"
                                    label="{{ __('app.loan.date') . ' ' . __('app.loan.singular') }}"
                                    wire:model.live="loan_date" />

                                <flux:error name="loan_date" />
                            </flux:field>

                        </div>

                    </div>

                    <flux:separator />

                    {{-- NILAI PINJAMAN --}}
                    <div class="space-y-4">

                        <div>
                            <flux:heading size="sm">
                                {{ __('app.loan.information_value') }}
                            </flux:heading>

                            <flux:text size="sm" class="mt-1">
                                {{ __('app.loan.information_value_description') }}
                            </flux:text>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                            {{-- Pokok --}}
                            <flux:field class="sm:col-span-2">
                                <flux:input label="{{ __('app.loan.principal') }}" wire:model.live="principalFormatted"
                                    inputmode="numeric" placeholder="0" />
                            </flux:field>

                            {{-- Jasa --}}
                            <flux:input label="{{ __('app.loan.interest') }}"
                                :value="$interest_percent.
                                '%'" readonly />

                            {{-- Nominal Jasa --}}
                            <flux:input label="{{ __('app.loan.interest_amount') }}" :value="idr($interest_amount)"
                                readonly />

                            {{-- Total --}}
                            <div class="sm:col-span-2">
                                <flux:card class="bg-zinc-50 dark:bg-zinc-800/50">
                                    <div class="flex items-center justify-between gap-4">

                                        <div>
                                            <flux:text size="sm">
                                                {{ __('app.loan.amount') }}
                                            </flux:text>

                                            <flux:text size="xs" class="mt-1">
                                                {{ __('app.loan.principal') . ' + ' . __('app.loan.interest') }}
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
                                        {{ __('app.loan.previous_loan') }}
                                    </flux:heading>

                                    <flux:text size="sm" class="mt-1">
                                        {{ __('app.loan.previous_loan_description') }}
                                    </flux:text>
                                </div>

                                <div class="divide-y divide-zinc-200 dark:divide-zinc-700">

                                    {{-- Nomor --}}
                                    <div class="flex items-center justify-between gap-4 py-3">

                                        <flux:text>
                                            {{ __('app.loan.loan_number') }}
                                        </flux:text>

                                        <flux:text class="font-medium">
                                            {{ $previousLoan->loan_number }}
                                        </flux:text>

                                    </div>

                                    {{-- Sisa Hutang --}}
                                    <div class="flex items-center justify-between gap-4 py-3">

                                        <flux:text>
                                            {{ __('app.loan.remaining') }}
                                        </flux:text>

                                        <flux:text class="font-semibold tabular-nums text-red-600 dark:text-red-400">
                                            {{ idr($previousLoan->remaining) }}
                                        </flux:text>

                                    </div>

                                    {{-- Dana Dicairkan --}}
                                    <div class="flex items-center justify-between gap-4 py-3">

                                        <flux:text>
                                            {{ __('app.loan.previous_loan_disbursement') }}
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

            </div>

            {{-- FOOTER --}}
            <div class="shrink-0 border-t border-zinc-200 pt-4 dark:border-zinc-700">

                <div class="flex justify-end gap-2">

                    {{-- Batal --}}
                    <flux:button type="button" variant="ghost" wire:click="closeModal">
                        {{ __('app.actions.cancel') }}
                    </flux:button>

                    {{-- Simpan --}}
                    <flux:button type="submit" variant="primary">
                        {{ $isEdit ? __('app.actions.edit') . ' ' . __('app.loan.singular') : __('app.actions.create') . ' ' . __('app.loan.singular') }}
                    </flux:button>

                </div>

            </div>

        </div>

    </form>

</flux:modal>
