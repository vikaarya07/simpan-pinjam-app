@props([
    'notification' => null,
    'message' => null,
])

@if ($notification)
    <flux:modal wire:model="showNotificationModal" class="w-sm md:w-3xl" :dismissible="false">

        <div class="flex max-h-[85vh] flex-col">

            {{-- HEADER --}}
            <div class="shrink-0 border-b border-zinc-200 pb-4 dark:border-zinc-700">
                <div class="flex items-start gap-3">
                    <div
                        class="flex size-11 shrink-0 items-center justify-center rounded-xl
                        bg-emerald-50 text-emerald-600
                        dark:bg-emerald-950/40 dark:text-emerald-400">
                        <flux:icon :name="$notification->type?->icon() ?? 'bell'" class="size-5" />
                    </div>

                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            @if ($notification->type)
                                <flux:badge :color="$notification->type->color()" size="sm">
                                    {{ $notification->type->label() }}
                                </flux:badge>
                            @endif

                            @if ($notification->sent_at)
                                <flux:badge color="green" size="sm">
                                    {{ __('app.customer_report.notification.sent') }}
                                </flux:badge>
                            @else
                                <flux:badge color="amber" size="sm">
                                    {{ __('app.customer_report.notification.not_sent') }}
                                </flux:badge>
                            @endif
                        </div>

                        <flux:heading size="lg" class="mt-1">
                            {!! preg_replace('/\*(.*?)\*/', '<strong>$1</strong>', e($notification->title)) !!}
                        </flux:heading>

                        <flux:text class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $notification->created_at?->format('d M Y, H:i') ?? '-' }}
                        </flux:text>
                    </div>
                </div>
            </div>


            {{-- SCROLLABLE CONTENT --}}
            <div class="min-h-0 flex-1 overflow-y-auto py-5">

                {{-- MESSAGE PREVIEW --}}
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <flux:text class="text-sm font-medium">
                            {{ __('app.customer_report.notification.message') }}
                        </flux:text>

                        <flux:badge color="zinc" size="sm">
                            Preview
                        </flux:badge>
                    </div>

                    <div
                        class="overflow-hidden rounded-2xl border border-zinc-200
                        bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-950">

                        <div class="p-4 sm:p-5">
                            <div class="flex justify-start">
                                <div
                                    class="max-w-full wrap-break-words rounded-xl bg-white px-4 py-4
                                    shadow-sm dark:bg-zinc-800">

                                    <div
                                        class="whitespace-pre-line wrap-break-words text-sm leading-6
                                        text-zinc-700 dark:text-zinc-200">
                                        {{ $message }}
                                    </div>

                                    <div class="mt-2 flex justify-end">
                                        <flux:text class="text-[10px] text-zinc-400">
                                            {{ $notification->created_at?->format('H:i') ?? '-' }}
                                        </flux:text>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- RELATED DATA --}}
                @if ($notification->loan || $notification->payment || $notification->meeting)

                    <div class="mt-5 space-y-2">

                        <flux:text class="text-sm font-medium">
                            {{ __('app.customer_report.notification.related_data') }}
                        </flux:text>

                        <div
                            class="overflow-hidden rounded-xl border
                            border-zinc-200 dark:border-zinc-700">

                            {{-- LOAN --}}
                            @if ($notification->loan)
                                <div
                                    class="flex items-center gap-3 border-b
                                    border-zinc-200 px-4 py-3 dark:border-zinc-700">

                                    <div
                                        class="flex size-8 shrink-0 items-center justify-center
                                        rounded-lg bg-emerald-50 text-emerald-600
                                        dark:bg-emerald-950/40 dark:text-emerald-400">
                                        <flux:icon name="banknotes" class="size-4" />
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <flux:text class="text-xs text-zinc-500 dark:text-zinc-400">
                                            {{ __('app.customer_report.notification.loan') }}
                                        </flux:text>

                                        <flux:text class="truncate text-sm font-medium">
                                            {{ $notification->loan->loan_number }}
                                        </flux:text>
                                    </div>
                                </div>
                            @endif

                            {{-- PAYMENT --}}
                            @if ($notification->payment)
                                <div
                                    class="flex items-center gap-3 border-b
                                    border-zinc-200 px-4 py-3 dark:border-zinc-700">

                                    <div
                                        class="flex size-8 shrink-0 items-center justify-center
                                        rounded-lg bg-blue-50 text-blue-600
                                        dark:bg-blue-950/40 dark:text-blue-400">
                                        <flux:icon name="credit-card" class="size-4" />
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <flux:text class="text-xs text-zinc-500 dark:text-zinc-400">
                                            {{ __('app.customer_report.notification.payment') }}
                                        </flux:text>

                                        <flux:text class="text-sm font-medium">
                                            {{ __('app.customer_report.notification.payment_number', [
                                                'count' => $notification->payment->payment_count ?? '-',
                                            ]) }}
                                        </flux:text>
                                    </div>

                                    <flux:text class="shrink-0 text-sm font-semibold">
                                        Rp {{ idr($notification->payment->amount ?? 0) }}
                                    </flux:text>
                                </div>
                            @endif

                            {{-- MEETING --}}
                            @if ($notification->meeting)
                                <div class="flex items-center gap-3 px-4 py-3">

                                    <div
                                        class="flex size-8 shrink-0 items-center justify-center
                                        rounded-lg bg-violet-50 text-violet-600
                                        dark:bg-violet-950/40 dark:text-violet-400">
                                        <flux:icon name="calendar-days" class="size-4" />
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <flux:text class="text-xs text-zinc-500 dark:text-zinc-400">
                                            {{ __('app.customer_report.notification.meeting') }}
                                        </flux:text>

                                        <flux:text class="text-sm font-medium">
                                            {{ $notification->meeting->meeting_date?->format('d M Y') ?? '-' }}
                                        </flux:text>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>

                @endif


                {{-- DELIVERY STATUS --}}
                <div
                    class="mt-5 rounded-xl border px-4 py-3
                    {{ $notification->sent_at
                        ? 'border-green-200 bg-green-50 dark:border-green-900 dark:bg-green-950/30'
                        : 'border-amber-200 bg-amber-50 dark:border-amber-900 dark:bg-amber-950/30' }}">

                    <div class="flex items-center gap-3">

                        <div
                            class="flex size-8 shrink-0 items-center justify-center rounded-lg
                            {{ $notification->sent_at
                                ? 'bg-green-100 text-green-600 dark:bg-green-900/40 dark:text-green-400'
                                : 'bg-amber-100 text-amber-600 dark:bg-amber-900/40 dark:text-amber-400' }}">

                            <flux:icon :name="$notification->sent_at ? 'check-circle' : 'clock'" class="size-4" />
                        </div>

                        <div class="min-w-0 flex-1">
                            <flux:text class="text-sm font-medium">
                                {{ $notification->sent_at
                                    ? __('app.customer_report.notification.sent')
                                    : __('app.customer_report.notification.not_sent') }}
                            </flux:text>

                            <flux:text class="text-xs text-zinc-500 dark:text-zinc-400">
                                @if ($notification->sent_at)
                                    {{ $notification->sent_at->format('d M Y, H:i') }}
                                @else
                                    {{ __('app.customer_report.notification.not_sent_information') }}
                                @endif
                            </flux:text>
                        </div>

                    </div>
                </div>

            </div>


            {{-- FOOTER --}}
            <div
                class="shrink-0 flex flex-col-reverse gap-2 border-t
                border-zinc-200 pt-4 sm:flex-row sm:justify-end
                dark:border-zinc-700">

                <flux:button variant="outline" wire:click="closeNotification">
                    {{ __('app.customer_report.action.close') }}
                </flux:button>

                @if (!$notification->sent_at)
                    <flux:button variant="primary" icon="paper-airplane"
                        wire:click="sendNotification({{ $notification->id }})" wire:loading.attr="disabled"
                        wire:target="sendNotification({{ $notification->id }})">

                        <span wire:loading.remove wire:target="sendNotification({{ $notification->id }})">
                            {{ __('app.customer_report.notification.send') }}
                        </span>

                        <span wire:loading wire:target="sendNotification({{ $notification->id }})">
                            {{ __('app.customer_report.notification.sending') }}
                        </span>

                    </flux:button>
                @endif

            </div>

        </div>
    </flux:modal>
@endif
