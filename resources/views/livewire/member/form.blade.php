<flux:modal wire:model="showFormModal" class="w-sm md:w-3xl" :dismissible="false">

    <form wire:submit="save">

        <div class="flex max-h-[85vh] flex-col">

            {{-- HEADER --}}
            <div class="shrink-0 border-b border-zinc-200 pb-4 dark:border-zinc-700">

                <flux:heading size="lg">
                    {{ $isEdit ? __('app.actions.edit') . ' ' . __('app.member.singular') : __('app.actions.add') . ' ' . __('app.member.singular') }}
                </flux:heading>

                <flux:text class="mt-1">
                    {{ $isEdit ? __('app.member.form_edit_description') : __('app.member.form_create_description') }}
                </flux:text>

            </div>

            {{-- CONTENT --}}
            <div class="min-h-0 flex-1 overflow-y-auto py-5 px-1">

                <div class="space-y-5">

                    {{-- Data Pribadi --}}
                    <div class="space-y-4">

                        <div>
                            <flux:heading size="sm">
                                {{ __('app.member.information') }}
                            </flux:heading>

                            <flux:text size="sm" class="mt-1">
                                {{ __('app.member.information_description') }}
                            </flux:text>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                            {{-- Nama --}}
                            <flux:field>

                                <flux:input label="{{ __('app.member.full_name') }}" wire:model="name"
                                    placeholder="{{ __('app.member.full_name') }}" />

                                <flux:error name="name" />

                            </flux:field>

                            {{-- Email --}}
                            <flux:field>

                                <flux:input label="{{ __('app.member.email') }}" type="email" wire:model="email"
                                    placeholder="email@katasama.or.id" />

                                <flux:error name="email" />

                            </flux:field>

                            {{-- Phone --}}
                            <flux:field>

                                <flux:input label="{{ __('app.member.phone') }}" wire:model="phone"
                                    placeholder="08xxxxxxxxxx" />

                                <flux:error name="phone" />

                            </flux:field>

                            {{-- Gender --}}
                            <flux:field>

                                <flux:select label="{{ __('app.member.gender') }}" wire:model="gender">

                                    <option value="" selected disabled>
                                        -- {{ __('app.member.form_select') }} --
                                    </option>

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

                                <flux:input type="date" label="{{ __('app.member.date_birth') }}"
                                    wire:model="date_birth" />

                                <flux:error name="date_birth" />

                            </flux:field>

                            {{-- Date Join --}}
                            <flux:field>

                                <flux:input type="date" label="{{ __('app.member.date_join') }}"
                                    wire:model="date_join" />

                                <flux:error name="date_join" />

                            </flux:field>

                        </div>

                    </div>

                    <flux:separator />

                    {{-- Keanggotaan --}}
                    <div class="space-y-4">

                        <div>
                            <flux:heading size="sm">
                                {{ __('app.member.information_status') }}
                            </flux:heading>

                            <flux:text size="sm" class="mt-1">
                                {{ __('app.member.information_status_description') }}
                            </flux:text>
                        </div>

                        <flux:field>

                            <flux:select label="{{ __('app.member.status') }}" wire:model="status">

                                @foreach (\App\Enums\MemberStatus::cases() as $statusOption)
                                    <option value="{{ $statusOption->value }}">
                                        {{ $statusOption->label() }}
                                    </option>
                                @endforeach

                            </flux:select>

                            <flux:error name="status" />

                        </flux:field>

                    </div>

                </div>

            </div>

            {{-- FOOTER --}}
            <div class="shrink-0 border-t border-zinc-200 pt-4 dark:border-zinc-700">

                <div class="flex justify-end gap-2">

                    {{-- Batal --}}
                    <flux:button type="button" variant="ghost" wire:click="closeModal">
                        {{ __('app.actions.cancel') }}
                    </flux:button>

                    {{-- Submit --}}
                    <flux:button type="submit" variant="primary">
                        {{ $isEdit ? __('app.actions.edit') . ' ' . __('app.member.singular') : __('app.actions.add') . ' ' . __('app.member.singular') }}
                    </flux:button>

                </div>

            </div>

        </div>

    </form>

</flux:modal>