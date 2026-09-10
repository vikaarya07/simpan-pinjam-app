@if ($selectedNotification)

    <flux:modal wire:model="showNotificationModal" class="md:w-xl">

        <div class="space-y-5">

            {{-- HEADER --}}
            <div class="flex items-start gap-3">

                <div
                    class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-zinc-100 dark:bg-zinc-800">

                    <flux:icon :name="$selectedNotification->type?->icon() ?? 'bell'"
                        class="size-5 text-zinc-600 dark:text-zinc-300" />

                </div>

                <div class="min-w-0 flex-1">

                    <div class="flex flex-wrap items-center gap-2">

                        <flux:heading size="lg">
                            {{ $selectedNotification->type?->label() ?? '-' }}
                        </flux:heading>

                        @if ($selectedNotification->sent_at)
                            <flux:badge color="green" size="sm">
                                {{ __('app.customer_report.notification.sent') }}
                            </flux:badge>
                        @else
                            <flux:badge color="amber" size="sm">
                                {{ __('app.customer_report.notification.not_sent') }}
                            </flux:badge>
                        @endif

                        @if ($selectedNotification->read_at)
                            <flux:badge color="zinc" size="sm">
                                {{ __('app.customer_report.notification.read') }}
                            </flux:badge>
                        @else
                            <flux:badge color="blue" size="sm">
                                {{ __('app.customer_report.notification.unread') }}
                            </flux:badge>
                        @endif

                    </div>

                    <flux:text class="mt-1 text-sm">
                        {{ $selectedNotification->created_at?->format('d M Y, H:i') ?? '-' }}
                    </flux:text>

                </div>

            </div>

            {{-- RELATED DATA --}}
            <div class="grid gap-3 sm:grid-cols-2">

                @if ($selectedNotification->loan)
                    <flux:card class="bg-zinc-50 dark:bg-zinc-800">

                        <flux:text class="text-xs">
                            {{ __('app.customer_report.notification.loan') }}
                        </flux:text>

                        <flux:text class="mt-1 font-semibold">
                            {{ $selectedNotification->loan->loan_number }}
                        </flux:text>

                    </flux:card>
                @endif

                @if ($selectedNotification->payment)
                    <flux:card class="bg-zinc-50 dark:bg-zinc-800">

                        <flux:text class="text-xs">
                            {{ __('app.customer_report.notification.payment') }}
                        </flux:text>

                        <flux:text class="mt-1 font-semibold">
                            {{ __('app.loan_history.payment_number', [
                                'count' => $selectedNotification->payment->payment_count ?? '-',
                            ]) }}
                        </flux:text>

                        <flux:text class="mt-1 text-xs">
                            Rp {{ idr($selectedNotification->payment->amount ?? 0) }}
                        </flux:text>

                    </flux:card>
                @endif

                @if ($selectedNotification->meeting)
                    <flux:card class="bg-zinc-50 dark:bg-zinc-800">

                        <flux:text class="text-xs">
                            {{ __('app.customer_report.notification.meeting') }}
                        </flux:text>

                        <flux:text class="mt-1 font-semibold">
                            {{ $selectedNotification->meeting->meeting_date?->format('d M Y') ?? '-' }}
                        </flux:text>

                    </flux:card>
                @endif

            </div>

            {{-- MESSAGE --}}
            <div>

                <flux:text class="mb-2 text-sm font-medium">
                    {{ __('app.customer_report.notification.message') }}
                </flux:text>

                <flux:card class="bg-zinc-50 dark:bg-zinc-800">

                    <flux:text class="whitespace-pre-line leading-relaxed">
                        {{ $selectedNotification->message }}
                    </flux:text>

                </flux:card>

            </div>

            {{-- SENT INFORMATION --}}
            @if ($selectedNotification->sent_at)
                <div
                    class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 dark:border-green-900 dark:bg-green-950/30">

                    <div class="flex items-center gap-2">

                        <flux:icon name="check-circle" class="size-4 text-green-600" />

                        <flux:text class="text-sm text-green-700 dark:text-green-400">
                            {{ __('app.customer_report.notification.sent_information') }}
                            {{ $selectedNotification->sent_at->format('d M Y, H:i') }}
                        </flux:text>

                    </div>

                </div>
            @else
                <div
                    class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 dark:border-amber-900 dark:bg-amber-950/30">

                    <div class="flex items-center gap-2">

                        <flux:icon name="clock" class="size-4 text-amber-600" />

                        <flux:text class="text-sm text-amber-700 dark:text-amber-400">
                            {{ __('app.customer_report.notification.not_sent_information') }}
                        </flux:text>

                    </div>

                </div>
            @endif

            {{-- FOOTER --}}
            <div class="flex justify-end gap-2">

                @if (!$selectedNotification->sent_at)
                    <flux:button variant="primary" icon="paper-airplane"
                        wire:click="sendNotification({{ $selectedNotification->id }})">
                        {{ __('app.customer_report.notification.send') }}
                    </flux:button>
                @endif

                <flux:button variant="outline" wire:click="closeNotification">
                    {{ __('app.customer_report.action.close') }}
                </flux:button>

            </div>

        </div>

    </flux:modal>

@endif