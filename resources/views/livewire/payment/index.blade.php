<div class="space-y-5">

    {{-- Header --}}
    <div>
        <flux:heading size="xl">
            {{ __('app.payment.index.title') }}
        </flux:heading>

        <flux:text class="mt-1">
            {{ __('app.payment.index.subtitle') }}
        </flux:text>
    </div>

    {{-- Search --}}
    <flux:card class="border-none! p-4">
        <div class="max-w-xl">
            <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass"
                :placeholder="__('app.payment.index.search')" clearable />
        </div>
    </flux:card>

    {{-- Table --}}
    <flux:card class="overflow-hidden border-none!">
        <flux:table>

            <flux:table.columns>
                <flux:table.column class="w-16">
                    #
                </flux:table.column>

                <flux:table.column>
                    {{ __('app.payment.index.place') }}
                </flux:table.column>

                <flux:table.column>
                    {{ __('app.payment.index.date') }}
                </flux:table.column>

                <flux:table.column>
                    {{ __('app.payment.index.status') }}
                </flux:table.column>

                <flux:table.column class="text-right">
                    {{ __('app.action') }}
                </flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($meetings as $meeting)
                    @php
                        $summary = $meeting->payment_summary;
                    @endphp

                    <flux:table.row wire:key="meeting-{{ $meeting->id }}"
                        class="transition hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                        {{-- No --}}
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
                                        {{ $meeting->tanggal }}
                                    </div>

                                    @if ($meeting->meeting_date)
                                        <div class="text-xs text-zinc-500">
                                            {{ $meeting->jam }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </flux:table.cell>

                        {{-- Payment Status --}}
                        <flux:table.cell>
                            <div class="flex items-center gap-2 whitespace-nowrap">

                                <flux:badge :color="$paymentStatus::Clear->color()"
                                    :icon="$paymentStatus::Clear->icon()" size="sm">
                                    {{ $summary['clear'] }}
                                </flux:badge>

                                <flux:badge :color="$paymentStatus::Skip->color()" :icon="$paymentStatus::Skip->icon()"
                                    size="sm">
                                    {{ $summary['skip'] }}
                                </flux:badge>

                                <flux:badge color="red" icon="x-circle" size="sm">
                                    {{ $summary['unpaid'] }}
                                </flux:badge>

                            </div>
                        </flux:table.cell>

                        {{-- Action --}}
                        <flux:table.cell>
                            <flux:button size="sm" variant="ghost" icon="eye"
                                :href="route('payment.show', $meeting)" wire:navigate>
                                {{ __('app.actions.view') }}
                            </flux:button>
                        </flux:table.cell>

                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="5">

                            <div class="flex flex-col items-center justify-center py-12 text-center">

                                <div
                                    class="flex size-14 items-center justify-center rounded-2xl bg-zinc-100 dark:bg-zinc-800">
                                    <flux:icon name="calendar-days" class="size-7 text-zinc-400" />
                                </div>

                                <flux:heading size="lg" class="mt-4">
                                    {{ __('app.payment.index.empty') }}
                                </flux:heading>

                                <flux:text class="mt-1 max-w-sm text-zinc-500">
                                    {{ __('app.payment.index.empty_description') }}
                                </flux:text>

                            </div>

                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>

        </flux:table>
    </flux:card>

    {{-- Pagination --}}
    @if ($meetings->hasPages())
        {{ $meetings->links() }}
    @endif

</div>
