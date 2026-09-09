<div class="space-y-5">

    {{-- Header --}}
    <div>
        <flux:heading size="xl">
            {{ __('app.customer.title') }}
        </flux:heading>

        <flux:text class="mt-1">
            {{ __('app.customer.subtitle') }}
        </flux:text>
    </div>

    {{-- Search --}}
    <flux:card class="border-none! p-4">
        <div class="max-w-xl">
            <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass"
                :placeholder="__('app.customer.search')" />
        </div>
    </flux:card>

    {{-- Table --}}
    <flux:card class="overflow-hidden border-none!">
        <flux:table>

            <flux:table.columns>
                <flux:table.column class="w-12">#</flux:table.column>

                <flux:table.column class="cursor-pointer" wire:click="sortBy('npk')">
                    <div class="flex items-center gap-1">
                        {{ __('app.customer.npk') }}
                        @include('components.sort-icon', ['field' => 'npk'])
                    </div>
                </flux:table.column>

                <flux:table.column>
                    {{ __('app.customer.name') }}
                </flux:table.column>

                <flux:table.column>
                    {{ __('app.customer.phone') }}
                </flux:table.column>

                <flux:table.column class="text-center">
                    {{ __('app.customer.loan_count') }}
                </flux:table.column>

                <flux:table.column class="cursor-pointer" wire:click="sortBy('date_birth')">
                    <div class="flex items-center gap-1">
                        {{ __('app.customer.age') }}
                        @include('components.sort-icon', ['field' => 'date_birth'])
                    </div>
                </flux:table.column>

                <flux:table.column>
                    {{ __('app.customer.gender') }}
                </flux:table.column>

                <flux:table.column class="text-right">
                    {{ __('app.action') }}
                </flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($customers as $customer)
                    <flux:table.row wire:key="customer-{{ $customer->id }}"
                        class="transition hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                        <flux:table.cell class="text-zinc-500">
                            {{ $customers->firstItem() + $loop->index }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <span class="font-medium whitespace-nowrap">
                                {{ $customer->npk }}
                            </span>
                        </flux:table.cell>

                        <flux:table.cell>
                            <div class="flex items-center gap-3">
                                <flux:avatar size="sm" :name="$customer->name" :initials="$customer->initials()"
                                    circle color="auto" />

                                <span class="truncate font-medium">
                                    {{ $customer->name }}
                                </span>
                            </div>
                        </flux:table.cell>

                        <flux:table.cell>
                            @if ($customer->phone)
                                <div class="flex items-center gap-2 whitespace-nowrap">
                                    <flux:icon name="phone" class="size-4 text-zinc-500" />

                                    <span>{{ $customer->phone }}</span>
                                </div>
                            @else
                                <span class="text-zinc-400">-</span>
                            @endif
                        </flux:table.cell>

                        <flux:table.cell class="text-center">
                            <flux:badge color="zinc" size="sm">
                                {{ $customer->loans_count }}
                            </flux:badge>
                        </flux:table.cell>

                        <flux:table.cell>
                            <span class="whitespace-nowrap">
                                {{ $customer->age }} {{ __('app.customer.year') }}
                            </span>
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:badge :color="$customer->gender->color()" size="sm">
                                {{ $customer->gender->label() }}
                            </flux:badge>
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:button size="sm" variant="ghost" icon="eye"
                                :href="route('customer.show', $customer)">
                                {{ __('app.actions.view') }}
                            </flux:button>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="8">
                            <div class="flex flex-col items-center justify-center py-12 text-center">
                                <flux:icon name="users" class="size-10 text-zinc-400" />

                                <flux:heading size="sm" class="mt-3">
                                    {{ __('app.customer.empty') }}
                                </flux:heading>

                                <flux:text class="mt-1">
                                    {{ __('app.customer.empty_description') }}
                                </flux:text>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>

        </flux:table>
    </flux:card>

    {{-- Pagination --}}
    {{ $customers->links() }}

</div>
