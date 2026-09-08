<div class="space-y-5">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <flux:heading size="xl">
                {{ __('app.member.title') }}
            </flux:heading>

            <flux:text class="mt-1">
                {{ __('app.member.subtitle') }}
            </flux:text>
        </div>

        <flux:button variant="primary" icon="plus" wire:click="create">
            {{ __('app.actions.add') . ' ' . __('app.member.singular') }}
        </flux:button>

    </div>

    {{-- Search --}}
    <flux:card class="p-4 border-none!">

        <div class="max-w-xl">

            <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass"
                placeholder="{{ __('app.member.search') }}" />

        </div>

    </flux:card>

    {{-- Table --}}
    <flux:card class="overflow-hidden border-none!">

        <flux:table>

            <flux:table.columns>

                <flux:table.column class="w-12">#</flux:table.column>

                {{-- NPK --}}
                <flux:table.column class="cursor-pointer" wire:click="sortBy('npk')">
                    <div class="flex items-center gap-1">
                        {{ __('app.member.npk') }}
                        @include('components.sort-icon', ['field' => 'npk'])
                    </div>
                </flux:table.column>

                {{-- Name --}}
                <flux:table.column>{{ __('app.member.name') }}</flux:table.column>

                {{-- Email --}}
                <flux:table.column>{{ __('app.member.email') }}</flux:table.column>

                {{-- Phone --}}
                <flux:table.column>{{ __('app.member.phone') }}</flux:table.column>

                {{-- Age --}}
                <flux:table.column class="cursor-pointer" wire:click="sortBy('date_birth')">
                    <div class="flex items-center gap-1">
                        {{ __('app.member.age') }}
                        @include('components.sort-icon', ['field' => 'date_birth'])
                    </div>
                </flux:table.column>

                {{-- Gender --}}
                <flux:table.column>{{ __('app.member.gender') }}</flux:table.column>

                {{-- Status --}}
                <flux:table.column class="cursor-pointer" wire:click="sortBy('status')">
                    <div class="flex items-center gap-1">
                        {{ __('app.member.status') }}
                        @include('components.sort-icon', ['field' => 'status'])
                    </div>
                </flux:table.column>

                {{-- Action --}}
                <flux:table.column class="text-right">{{ __('app.action') }}</flux:table.column>

            </flux:table.columns>

            <flux:table.rows>

                @forelse($members as $member)
                    <flux:table.row wire:key="member-{{ $member->id }}"
                        class="transition hover:bg-zinc-50 dark:hover:bg-zinc-800/50">

                        {{-- No --}}
                        <flux:table.cell class="text-zinc-500">
                            {{ $loop->iteration }}
                        </flux:table.cell>

                        {{-- NPK --}}
                        <flux:table.cell>

                            <span class="font-medium">
                                {{ $member->npk }}
                            </span>

                        </flux:table.cell>

                        {{-- Name --}}
                        <flux:table.cell>

                            <div class="flex items-center gap-3">

                                <flux:avatar size="sm" :name="$member->name" :initials="$member->initials()"
                                    circle color="auto" />

                                <div class="min-w-0">

                                    <div class="truncate font-medium">
                                        {{ $member->name }}
                                    </div>

                                </div>

                            </div>

                        </flux:table.cell>

                        {{-- Email --}}
                        <flux:table.cell>

                            @if ($member->email)
                                <flux:text>
                                    {{ $member->email }}
                                </flux:text>
                            @else
                                <flux:text>
                                    -
                                </flux:text>
                            @endif

                        </flux:table.cell>

                        {{-- Phone --}}
                        <flux:table.cell>

                            @if ($member->phone)
                                <flux:text>
                                    {{ $member->phone }}
                                </flux:text>
                            @else
                                <flux:text>
                                    -
                                </flux:text>
                            @endif

                        </flux:table.cell>

                        {{-- Age --}}
                        <flux:table.cell>

                            <span class="tabular-nums">
                                {{ $member->age }}
                            </span>

                        </flux:table.cell>

                        {{-- Gender --}}
                        <flux:table.cell>

                            <flux:badge :color="$member->gender->color()" size="sm">
                                {{ $member->gender->label() }}
                            </flux:badge>

                        </flux:table.cell>

                        {{-- Status --}}
                        <flux:table.cell>

                            <flux:badge :color="$member->status->color()" size="sm">
                                {{ $member->status->label() }}
                            </flux:badge>

                        </flux:table.cell>

                        {{-- Actions --}}
                        <flux:table.cell>

                            <div class="flex justify-start gap-1">

                                <flux:button size="sm" variant="ghost" icon="pencil-square"
                                    wire:click="edit('{{ $member->id }}')" tooltip="{{ __('app.actions.edit') . ' ' . __('app.member.singular') }}" />

                                <flux:button size="sm" variant="ghost" icon="trash"
                                    class="text-red-500 hover:text-red-600"
                                    wire:click="confirmDelete('{{ $member->id }}')" tooltip="{{ __('app.actions.delete') . ' ' . __('app.member.singular') }}" />

                            </div>

                        </flux:table.cell>

                    </flux:table.row>

                @empty

                    <flux:table.row>

                        <flux:table.cell colspan="9">

                            <div class="flex flex-col items-center justify-center py-12 text-center">

                                <flux:icon name="users" class="size-10 text-zinc-400" />

                                <flux:heading size="sm" class="mt-3">
                                    {{ __('app.member.empty') }}
                                </flux:heading>

                                <flux:text class="mt-1">
                                    {{ __('app.member.empty_description') }}
                                </flux:text>

                                <flux:button class="mt-4" variant="primary" icon="plus" wire:click="create">
                                    {{ __('app.actions.add') . ' ' . __('app.member.singular') }}
                                </flux:button>

                            </div>

                        </flux:table.cell>

                    </flux:table.row>
                @endforelse

            </flux:table.rows>

        </flux:table>

    </flux:card>

    {{-- Pagination --}}
    <div>
        {{ $members->links() }}
    </div>

    {{-- Form --}}
    <livewire:member.form />

</div>
