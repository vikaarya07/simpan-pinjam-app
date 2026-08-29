<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between gap-4">

        <div>
            <flux:heading size="xl">
                Notification Customer
            </flux:heading>

            <flux:text class="mt-1">
                Riwayat informasi dan pemberitahuan untuk
                {{ $customer->name }}
            </flux:text>
        </div>

        <flux:button variant="outline" icon="arrow-left" :href="route('customer.index')">
            Kembali
        </flux:button>

    </div>


    {{-- Filter --}}
    <div class="flex flex-col gap-3 sm:flex-row">

        <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass" placeholder="Cari notification..." />

        <flux:select wire:model.live="type">
            <option value="">Semua Notification</option>

            @foreach ($types as $notificationType)
                <option value="{{ $notificationType->value }}">
                    {{ $notificationType->label() }}
                </option>
            @endforeach
        </flux:select>

    </div>


    {{-- Notification List --}}
    <div class="space-y-3">

        @forelse ($this->notifications as $notification)
            <div class="rounded-xl border bg-white p-5 shadow-sm">

                <div class="flex items-start gap-4">

                    {{-- Icon --}}
                    <div class="flex size-10 shrink-0 items-center justify-center rounded-full bg-gray-100">
                        <flux:icon :name="$notification->type->icon()" class="size-5" />
                    </div>


                    {{-- Content --}}
                    <div class="min-w-0 flex-1">

                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                            <div class="flex items-center gap-2">

                                <flux:badge :color="$notification->type->color()">
                                    {{ $notification->type->label() }}
                                </flux:badge>

                                @if ($notification->sent_at)
                                    <flux:badge color="green">
                                        Terkirim
                                    </flux:badge>
                                @else
                                    <flux:badge color="zinc">
                                        Belum Dikirim
                                    </flux:badge>
                                @endif

                            </div>

                            <flux:text size="sm" class="text-gray-500">
                                {{ $notification->created_at->format('d M Y H:i') }}
                            </flux:text>

                        </div>


                        {{-- Loan --}}
                        @if ($notification->loan)
                            <div class="mt-3 text-sm text-gray-500">
                                Pinjaman:
                                <span class="font-medium text-gray-800">
                                    {{ $notification->loan->loan_number }}
                                </span>
                            </div>
                        @endif


                        {{-- Message Preview --}}
                        <div class="mt-3 rounded-lg bg-gray-50 p-4">
                            <div class="whitespace-pre-line text-sm leading-relaxed text-gray-700">
                                {{ $notification->message }}
                            </div>
                        </div>


                        {{-- Action --}}
                        <div class="mt-4 flex justify-end gap-2">

                            <flux:button size="sm" variant="outline" icon="eye"
                                wire:click="$dispatch('show-customer-notification', { id: {{ $notification->id }} })">
                                Detail
                            </flux:button>

                            @if (!$notification->sent_at)
                                <flux:button size="sm" variant="primary" icon="paper-airplane" disabled>
                                    Kirim
                                </flux:button>
                            @endif

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="rounded-xl border border-dashed p-12 text-center">

                <flux:icon name="bell-slash" class="mx-auto size-10 text-gray-400" />

                <flux:heading size="lg" class="mt-4">
                    Belum ada notification
                </flux:heading>

                <flux:text class="mt-1">
                    Notification customer akan muncul setelah
                    transaksi atau reminder dibuat.
                </flux:text>

            </div>
        @endforelse

    </div>


    {{-- Pagination --}}
    <div>
        {{ $this->notifications->links() }}
    </div>

</div>
