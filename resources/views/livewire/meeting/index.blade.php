<div class="space-y-5">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <flux:heading size="xl">
                {{ __('app.meeting.title') }}
            </flux:heading>

            <flux:text class="mt-1">
                {{ __('app.meeting.subtitle') }}
            </flux:text>
        </div>

        <flux:button variant="primary" icon="plus" wire:click="create">
            {{ __('app.actions.add') }} {{ __('app.meeting.singular') }}
        </flux:button>
    </div>

    {{-- Search --}}
    <flux:card class="border-none! p-4">
        <div class="max-w-xl">
            <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass"
                :placeholder="__('app.meeting.search')" />
        </div>
    </flux:card>

    {{-- Table --}}
    <flux:card class="overflow-hidden border-none!">
        <flux:table>

            <flux:table.columns>
                <flux:table.column class="w-12">
                    #
                </flux:table.column>

                <flux:table.column>
                    {{ __('app.meeting.place') }}
                </flux:table.column>

                <flux:table.column class="cursor-pointer" wire:click="sortBy('meeting_date')">
                    <div class="flex items-center gap-1">
                        {{ __('app.meeting.date') }}

                        @include('components.sort-icon', [
                            'field' => 'meeting_date',
                        ])
                    </div>
                </flux:table.column>

                <flux:table.column class="text-right">
                    {{ __('app.actions.action') }}
                </flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($meetings as $meeting)
                    <flux:table.row wire:key="meeting-{{ $meeting->id }}"
                        class="transition hover:bg-zinc-50 dark:hover:bg-zinc-800/50">

                        {{-- Number --}}
                        <flux:table.cell class="text-zinc-500">
                            {{ $meetings->firstItem() + $loop->index }}
                        </flux:table.cell>

                        {{-- Place --}}
                        <flux:table.cell>
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-zinc-100 dark:bg-zinc-800">
                                    <flux:icon name="map-pin" class="size-4 text-zinc-500" />
                                </div>

                                <span class="font-medium">
                                    {{ $meeting->place }}
                                </span>
                            </div>
                        </flux:table.cell>

                        {{-- Date --}}
                        <flux:table.cell>
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-zinc-100 dark:bg-zinc-800">
                                    <flux:icon name="calendar-days" class="size-4 text-zinc-500" />
                                </div>

                                <div>
                                    <div class="font-medium whitespace-nowrap">
                                        {{ $meeting->waktu }}
                                    </div>

                                    <div class="text-xs text-zinc-500">
                                        {{ $meeting->jam }}
                                    </div>
                                </div>
                            </div>
                        </flux:table.cell>

                        {{-- Actions --}}
                        <flux:table.cell>
                            <div class="flex gap-1">

                                <flux:button size="sm" variant="ghost" icon="pencil-square"
                                    wire:click="edit('{{ $meeting->id }}')"
                                    :tooltip="__('app.meeting.tooltip_edit', [
                                        'name' => __('app.meeting.singular'),
                                    ])" />

                                <flux:button size="sm" variant="ghost" icon="trash"
                                    class="text-red-500 hover:text-red-600"
                                    wire:click="confirmDelete('{{ $meeting->id }}')"
                                    :tooltip="__('app.meeting.tooltip_delete', [
                                        'name' => __('app.meeting.singular'),
                                    ])" />

                            </div>
                        </flux:table.cell>

                    </flux:table.row>

                @empty

                    <flux:table.row>
                        <flux:table.cell colspan="4">

                            <div class="flex flex-col items-center justify-center py-12 text-center">

                                <flux:icon name="calendar-days" class="size-10 text-zinc-400" />

                                <flux:heading size="sm" class="mt-3">
                                    {{ __('app.meeting.empty') }}
                                </flux:heading>

                                <flux:text class="mt-1">
                                    {{ __('app.meeting.empty_description') }}
                                </flux:text>

                                <flux:button class="mt-4" variant="primary" icon="plus" wire:click="create">
                                    {{ __('app.actions.create') }}
                                    {{ __('app.meeting.singular') }}
                                </flux:button>

                            </div>

                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>

        </flux:table>
    </flux:card>

    {{-- Pagination --}}
    {{ $meetings->links() }}

    {{-- Form --}}
    <livewire:meeting.form />

</div>
