{{-- Member Form --}}
<flux:modal wire:model="showFormModal" class="w-sm md:w-3xl" :dismissible="false">

    <form wire:submit="save">
        <div class="flex max-h-[85vh] flex-col">

            {{-- Header --}}
            <header class="shrink-0 border-b border-zinc-200 pb-4 dark:border-zinc-700">

                <flux:heading size="lg">
                    @if ($isEdit)
                        {{ __('app.actions.edit') }} {{ __('app.member.singular') }}
                    @else
                        {{ __('app.actions.add') }} {{ __('app.member.singular') }}
                    @endif
                </flux:heading>

                <flux:text class="mt-1">
                    {{ $isEdit ? __('app.member.form_edit_description') : __('app.member.form_create_description') }}
                </flux:text>

            </header>

            {{-- Content --}}
            <div class="min-h-0 flex-1 overflow-y-auto px-1 py-5">

                <div class="space-y-5">

                    {{-- Personal Information --}}
                    <section class="space-y-4">

                        <div>
                            <flux:heading size="sm">
                                {{ __('app.member.information') }}
                            </flux:heading>

                            <flux:text size="sm" class="mt-1">
                                {{ __('app.member.information_description') }}
                            </flux:text>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                            {{-- Name --}}
                            <flux:field>
                                <flux:input :label="__('app.member.full_name')" wire:model="name"
                                    :placeholder="__('app.member.full_name')" />
                            </flux:field>

                            {{-- Email --}}
                            <flux:field>
                                <flux:input type="email" :label="__('app.member.email')" wire:model="email"
                                    :placeholder="__('app.member.email_placeholder')" />
                            </flux:field>

                            {{-- Phone --}}
                            <flux:field>
                                <flux:input :label="__('app.member.phone')" wire:model="phone"
                                    :placeholder="__('app.member.phone_placeholder')" />
                            </flux:field>

                            {{-- Gender --}}
                            <flux:field>
                                <flux:select :label="__('app.member.gender')" wire:model="gender">
                                    <option value="">
                                        -- {{ __('app.member.form_select') }} --
                                    </option>

                                    @foreach (\App\Enums\Gender::cases() as $genderOption)
                                        <option value="{{ $genderOption->value }}">
                                            {{ $genderOption->label() }}
                                        </option>
                                    @endforeach
                                </flux:select>
                            </flux:field>

                            {{-- Date of Birth --}}
                            <flux:field>
                                <flux:input type="date" :label="__('app.member.date_birth')"
                                    wire:model="date_birth" />
                            </flux:field>

                            {{-- Date Joined --}}
                            <flux:field>
                                <flux:input type="date" :label="__('app.member.date_join')" wire:model="date_join" />
                            </flux:field>

                        </div>
                    </section>

                    <flux:separator />

                    {{-- Membership --}}
                    <section class="space-y-4">

                        <div>
                            <flux:heading size="sm">
                                {{ __('app.member.information_status') }}
                            </flux:heading>

                            <flux:text size="sm" class="mt-1">
                                {{ __('app.member.information_status_description') }}
                            </flux:text>
                        </div>

                        <flux:field>
                            <flux:select :label="__('app.member.status')" wire:model="status">
                                @foreach (\App\Enums\MemberStatus::cases() as $statusOption)
                                    <option value="{{ $statusOption->value }}">
                                        {{ $statusOption->label() }}
                                    </option>
                                @endforeach
                            </flux:select>
                        </flux:field>

                    </section>

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
