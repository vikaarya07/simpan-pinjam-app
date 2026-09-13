<div class="space-y-5">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

        <div>
            <flux:heading size="xl">
                {{ __('app.customer_report.title') }}
            </flux:heading>

            <flux:text class="mt-1">
                {{ __('app.customer_report.subtitle') }}
            </flux:text>
        </div>

        @if ($report)
            <div class="flex gap-2">

                <flux:button variant="outline" icon="document-arrow-down" wire:click="downloadPdf">
                    {{ __('app.customer_report.action.pdf') }}
                </flux:button>

                <flux:button variant="outline" icon="paper-airplane" wire:click="sendWhatsApp">
                    {{ __('app.customer_report.action.send') }}
                </flux:button>

            </div>
        @endif

    </div>

    {{-- CUSTOMER SELECTOR --}}
    <flux:card class="border-none! p-4">

        <flux:select label="{{ __('app.customer_report.selector.label') }}" wire:model.live="customerId"
            placeholder="{{ __('app.customer_report.selector.placeholder') }}">
            @foreach ($customers as $customer)
                <flux:select.option value="{{ $customer->id }}">
                    {{ $customer->npk }} - {{ $customer->name }}
                </flux:select.option>
            @endforeach
        </flux:select>

    </flux:card>

    {{-- REPORT --}}
    @if ($report)

        @php
            $customer = $report['customer'];
            $summary = $report['summary'];
            $loans = $report['loans'];

            $hasRunningLoan = $loans->contains(
                fn($loan) => $loan->status?->value === \App\Enums\LoanStatus::Running->value,
            );
        @endphp

        {{-- CUSTOMER INFORMATION --}}
        <flux:card class="border-none! p-4">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                {{-- Identity --}}
                <div class="flex min-w-0 items-center gap-3">

                    <flux:avatar size="xl" :name="$customer->name" :initials="$customer->initials()" circle
                        color="auto" />

                    <div class="min-w-0">

                        <div class="flex flex-wrap items-center gap-2">

                            <flux:heading size="lg">
                                {{ $customer->name }}
                            </flux:heading>

                            <flux:badge :color="$customer->status?->color() ?? 'zinc'">
                                {{ $customer->status?->label() ?? '-' }}
                            </flux:badge>

                        </div>

                        <div class="mt-1 flex flex-wrap gap-x-4 gap-y-1">

                            <flux:text class="text-sm">
                                {{ __('app.customer_report.information.npk') }}:
                                {{ $customer->npk }}
                            </flux:text>

                            <flux:text class="text-sm">
                                {{ __('app.customer_report.information.phone') }}:
                                {{ $customer->phone ?? '-' }}
                            </flux:text>

                        </div>

                    </div>
                </div>

                {{-- Statistics --}}
                <div class="flex shrink-0 gap-2">

                    <flux:badge color="zinc">
                        {{ $summary['loan_count'] }}
                        {{ __('app.customer_report.information.loan_count') }}
                    </flux:badge>

                    <flux:badge color="zinc">
                        {{ $this->notificationCount }}
                        {{ __('app.customer_report.information.notification_count') }}
                    </flux:badge>

                </div>

            </div>
        </flux:card>

        {{-- TAB NAVIGATION --}}
        <div class="border-b border-zinc-200 dark:border-zinc-700">

            <nav class="flex gap-1 overflow-x-auto overflow-y-hidden">

                {{-- SUMMARY --}}
                <button type="button" wire:click="selectTab('summary')"
                    class="relative flex shrink-0 items-center gap-2 px-4 py-3 text-sm font-medium transition
                        {{ $tab === 'summary'
                            ? 'text-zinc-900 dark:text-white'
                            : 'text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white' }}">
                    <flux:icon name="chart-bar" class="size-4" />

                    <span>
                        {{ __('app.customer_report.tabs.summary') }}
                    </span>

                    @if ($tab === 'summary')
                        <span class="absolute inset-x-0 -bottom-px h-1 rounded-t-lg bg-zinc-700 dark:bg-white"></span>
                    @endif
                </button>

                {{-- LOANS --}}
                <button type="button" wire:click="selectTab('loans')"
                    class="relative flex shrink-0 items-center gap-2 px-4 py-3 text-sm font-medium transition
                        {{ $tab === 'loans'
                            ? 'text-zinc-900 dark:text-white'
                            : 'text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white' }}">
                    <flux:icon name="banknotes" class="size-4" />

                    <span>
                        {{ __('app.customer_report.tabs.loans') }}
                    </span>

                    <span
                        class="rounded-full bg-zinc-100 px-2 py-0.5 text-xs text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
                        {{ $summary['loan_count'] }}
                    </span>

                    @if ($tab === 'loans')
                        <span class="absolute inset-x-0 -bottom-px h-1 rounded-t-lg bg-zinc-700 dark:bg-white"></span>
                    @endif
                </button>

                {{-- NOTIFICATION --}}
                <button type="button" wire:click="selectTab('notification')"
                    class="relative flex shrink-0 items-center gap-2 px-4 py-3 text-sm font-medium transition
                        {{ $tab === 'notification'
                            ? 'text-zinc-900 dark:text-white'
                            : 'text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white' }}">
                    <flux:icon name="bell" class="size-4" />

                    <span>
                        {{ __('app.customer_report.tabs.notifications') }}
                    </span>

                    @if ($this->notificationCount)
                        <span
                            class="rounded-full bg-zinc-100 px-2 py-0.5 text-xs text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
                            {{ $this->notificationCount }}
                        </span>
                    @endif

                    @if ($this->unreadNotificationCount)
                        <span
                            class="rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-700 dark:bg-blue-950 dark:text-blue-300">
                            {{ $this->unreadNotificationCount }}
                            {{ __('app.customer_report.tabs.new') }}
                        </span>
                    @endif

                    @if ($tab === 'notification')
                        <span class="absolute inset-x-0 -bottom-px h-1 rounded-t-lg bg-zinc-700 dark:bg-white"></span>
                    @endif
                </button>

            </nav>
        </div>

        {{-- SUMMARY TAB --}}
        @if ($tab === 'summary')

            <div class="space-y-5">

                {{-- SUMMARY CARDS --}}
                <div class="grid grid-cols-2 gap-3 xl:grid-cols-4">

                    {{-- TOTAL LOAN --}}
                    <flux:card class="border-none! p-4">
                        <div class="flex items-start justify-between gap-3">

                            <div>
                                <flux:text class="text-sm">
                                    {{ __('app.customer_report.summary.total_loan') }}
                                </flux:text>

                                <flux:heading size="lg" class="mt-2">
                                    Rp {{ idr($summary['loan_amount']) }}
                                </flux:heading>

                                <flux:text class="mt-1 text-xs">
                                    {{ $summary['loan_count'] }}
                                    {{ __('app.customer_report.summary.transaction') }}
                                </flux:text>
                            </div>

                            <flux:icon name="banknotes" class="size-5 text-zinc-400" />

                        </div>
                    </flux:card>

                    {{-- PAYMENT --}}
                    <flux:card class="border-none! p-4">
                        <div class="flex items-start justify-between gap-3">

                            <div>
                                <flux:text class="text-sm">
                                    {{ __('app.customer_report.summary.total_paid') }}
                                </flux:text>

                                <flux:heading size="lg" class="mt-2">
                                    Rp {{ idr($summary['payment_amount']) }}
                                </flux:heading>

                                <flux:text class="mt-1 text-xs">
                                    {{ __('app.customer_report.summary.total_payment') }}
                                </flux:text>
                            </div>

                            <flux:icon name="arrow-trending-up" class="size-5 text-zinc-400" />

                        </div>
                    </flux:card>

                    {{-- REMAINING --}}
                    <flux:card class="border-none! p-4">
                        <div class="flex items-start justify-between gap-3">

                            <div>
                                <flux:text class="text-sm">
                                    {{ __('app.customer_report.summary.remaining') }}
                                </flux:text>

                                <flux:heading size="lg"
                                    class="mt-2 {{ $summary['remaining'] > 0 ? 'text-amber-600' : 'text-emerald-600' }}">
                                    Rp {{ idr($summary['remaining']) }}
                                </flux:heading>

                                <flux:text class="mt-1 text-xs">
                                    {{ __('app.customer_report.summary.outstanding') }}
                                </flux:text>
                            </div>

                            <flux:icon name="clock" class="size-5 text-zinc-400" />

                        </div>
                    </flux:card>

                    {{-- STATUS --}}
                    <flux:card class="border-none! p-4">
                        <div class="flex items-start justify-between gap-3">

                            <div>
                                <flux:text class="text-sm">
                                    {{ __('app.customer_report.summary.status') }}
                                </flux:text>

                                <div class="mt-2">

                                    @if ($hasRunningLoan)
                                        <flux:badge color="blue">
                                            {{ __('app.customer_report.summary.running') }}
                                        </flux:badge>
                                    @else
                                        <flux:badge color="green">
                                            {{ __('app.customer_report.summary.no_active_loan') }}
                                        </flux:badge>
                                    @endif

                                </div>

                                <flux:text class="mt-2 text-xs">
                                    {{ $summary['loan_count'] }}
                                    {{ __('app.customer_report.summary.transaction') }}
                                </flux:text>
                            </div>

                            <flux:icon name="chart-bar" class="size-5 text-zinc-400" />

                        </div>
                    </flux:card>

                </div>

                {{-- INFORMATION --}}
                <flux:card class="border-none! p-5">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <div>
                            <flux:heading size="sm">
                                {{ __('app.customer_report.summary.information_title') }}
                            </flux:heading>

                            <flux:text class="mt-1">
                                {{ __('app.customer_report.summary.information_description') }}
                            </flux:text>
                        </div>

                        <div class="flex flex-wrap gap-2">

                            <flux:badge color="zinc">
                                {{ $summary['loan_count'] }}
                                {{ __('app.customer_report.information.loan_count') }}
                            </flux:badge>

                            <flux:badge color="zinc">
                                {{ $this->notificationCount }}
                                {{ __('app.customer_report.information.notification_count') }}
                            </flux:badge>

                        </div>

                    </div>
                </flux:card>

            </div>

        @endif

        {{-- LOANS TAB --}}
        @if ($tab === 'loans')
            <div class="space-y-4">

                {{-- HEADER --}}
                <div class="flex items-center justify-between gap-3">

                    <div>
                        <flux:heading size="lg">
                            {{ __('app.customer_report.loans.title') }}
                        </flux:heading>

                        <flux:text class="mt-1">
                            {{ __('app.customer_report.loans.description') }}
                        </flux:text>
                    </div>

                    <flux:badge color="zinc">
                        {{ $summary['loan_count'] }}
                        {{ __('app.customer_report.loans.count') }}
                    </flux:badge>

                </div>

                {{-- LOAN LIST --}}
                <div class="space-y-3">
                    <x-loan-history :items="$loans" />
                </div>

            </div>
        @endif

        {{-- NOTIFICATION TAB --}}
        @if ($tab === 'notification')
            <div class="space-y-5">

                {{-- HEADER --}}
                <div class="flex flex-col gap-4">

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                        <div class="min-w-0">
                            <flux:heading size="lg">
                                {{ __('app.customer_report.notification.title') }}
                            </flux:heading>

                            <flux:text class="mt-1">
                                {{ __('app.customer_report.notification.description') }}
                            </flux:text>
                        </div>

                        <flux:badge color="zinc" class="shrink-0">
                            {{ $this->notificationCount }}
                            {{ __('app.customer_report.information.notification_count') }}
                        </flux:badge>
                    </div>


                    {{-- FILTER --}}
                    <div class="flex flex-col gap-3 sm:flex-row">

                        <div class="min-w-0 flex-1">
                            <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass"
                                placeholder="{{ __('app.customer_report.notification.search_placeholder') }}" />
                        </div>

                        <div class="sm:w-56">
                            <flux:select wire:model.live="type">
                                <flux:select.option value="">
                                    {{ __('app.customer_report.notification.all_types') }}
                                </flux:select.option>

                                @foreach ($notificationTypes as $notificationType)
                                    <flux:select.option value="{{ $notificationType->value }}">
                                        {{ $notificationType->label() }}
                                    </flux:select.option>
                                @endforeach
                            </flux:select>
                        </div>

                    </div>
                </div>

                {{-- NOTIFICATION LIST --}}
                <div class="grid gap-3 md:grid-cols-2">

                    @forelse ($notifications as $notification)
                        @php
                            $isSent = filled($notification->sent_at);
                            $isRead = filled($notification->read_at);
                        @endphp

                        <div wire:key="notification-{{ $notification->id }}"
                            class="group overflow-hidden rounded-xl border border-zinc-200 bg-white
                                shadow-sm transition
                                hover:border-emerald-300 hover:shadow-md
                                dark:border-zinc-700 dark:bg-zinc-900
                                dark:hover:border-emerald-700">

                            {{-- MAIN CONTENT --}}
                            <div class="p-4">

                                <div class="flex items-start gap-3">

                                    {{-- ICON --}}
                                    <div
                                        class="flex size-10 shrink-0 items-center justify-center rounded-xl
                                            bg-zinc-100 text-zinc-500 transition
                                            group-hover:bg-emerald-50 group-hover:text-emerald-600
                                            dark:bg-zinc-800 dark:text-zinc-400
                                            dark:group-hover:bg-emerald-950/40
                                            dark:group-hover:text-emerald-400">
                                        <flux:icon :name="$notification->type?->icon() ?? 'bell'" class="size-5" />
                                    </div>


                                    {{-- CONTENT --}}
                                    <div class="min-w-0 flex-1">

                                        {{-- BADGES --}}
                                        <div class="flex flex-wrap items-center gap-1.5">

                                            @if ($notification->type)
                                                <flux:badge :color="$notification->type->color()" size="sm">
                                                    {{ $notification->type->label() }}
                                                </flux:badge>
                                            @endif

                                            @if (!$isRead)
                                                <flux:badge color="blue" size="sm">
                                                    {{ __('app.customer_report.notification.unread') }}
                                                </flux:badge>
                                            @endif

                                        </div>

                                        {{-- TITLE --}}
                                        <flux:text class="mt-1.5 font-semibold">
                                            {!! preg_replace('/\*(.*?)\*/', '<strong>$1</strong>', e($notification->title)) !!}
                                        </flux:text>

                                        {{-- META --}}
                                        <div class="mt-3 flex flex-wrap items-center gap-x-3 gap-y-1">

                                            <flux:text class="text-xs text-zinc-500 dark:text-zinc-500">
                                                <span class="inline-flex items-center gap-1">
                                                    <flux:icon name="clock" class="size-3.5" />
                                                    {{ $notification->created_at?->format('d M Y, H:i') ?? '-' }}
                                                </span>
                                            </flux:text>

                                            @if ($notification->payment)
                                                <flux:text class="text-xs text-zinc-500 dark:text-zinc-500">
                                                    <span class="inline-flex items-center gap-1">
                                                        <flux:icon name="credit-card" class="size-3.5" />
                                                        {{ __('app.customer_report.notification.payment_number', [
                                                            'count' => $notification->payment->payment_count ?? '-',
                                                        ]) }}
                                                    </span>
                                                </flux:text>
                                            @endif

                                        </div>

                                    </div>


                                    {{-- DETAIL --}}
                                    <div class="shrink-0">
                                        <flux:button size="sm" variant="ghost" icon="eye"
                                            wire:click="openNotification({{ $notification->id }})"
                                            title="{{ __('app.customer_report.notification.detail') }}">
                                            <span class="hidden sm:inline">
                                                {{ __('app.customer_report.notification.detail') }}
                                            </span>
                                        </flux:button>
                                    </div>

                                </div>

                            </div>


                            {{-- SEND FOOTER --}}
                            <div class="border-t border-zinc-200 px-4 py-2.5 dark:border-zinc-700">
                                <div class="flex items-center justify-between gap-3">

                                    @if ($isSent)
                                        <div class="flex min-w-0 items-center gap-2">
                                            <flux:icon name="check-circle" class="size-4 shrink-0 text-green-500" />

                                            <flux:text class="truncate text-xs text-zinc-500 dark:text-zinc-400">
                                                {{ __('app.customer_report.notification.sent') }}

                                                {{ $notification->sent_at?->format('d M Y, H:i') }}
                                            </flux:text>
                                        </div>
                                    @else
                                        <div class="flex min-w-0 items-center gap-2">
                                            <flux:icon name="clock" class="size-4 shrink-0 text-amber-500" />

                                            <flux:text class="truncate text-xs text-amber-600 dark:text-amber-400">
                                                {{ __('app.customer_report.notification.not_sent') }}
                                            </flux:text>
                                        </div>

                                        <flux:button size="sm" variant="primary" icon="paper-airplane"
                                            wire:click="sendNotification({{ $notification->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="sendNotification({{ $notification->id }})">
                                            <span wire:loading.remove
                                                wire:target="sendNotification({{ $notification->id }})">
                                                {{ __('app.customer_report.notification.send') }}
                                            </span>

                                            <span wire:loading
                                                wire:target="sendNotification({{ $notification->id }})">
                                                {{ __('app.customer_report.notification.sending') }}
                                            </span>
                                        </flux:button>
                                    @endif

                                </div>
                            </div>

                        </div>

                    @empty

                        {{-- EMPTY STATE --}}
                        <div class="md:col-span-2">
                            <flux:card class="p-10">
                                <div class="flex flex-col items-center text-center">

                                    <div
                                        class="flex size-12 items-center justify-center rounded-full
                                            bg-zinc-100 dark:bg-zinc-800">
                                        <flux:icon name="bell-slash" class="size-6 text-zinc-400" />
                                    </div>

                                    <flux:heading size="sm" class="mt-4">
                                        {{ __('app.customer_report.notification.empty_title') }}
                                    </flux:heading>

                                    <flux:text class="mt-1">
                                        {{ __('app.customer_report.notification.empty_description') }}
                                    </flux:text>

                                </div>
                            </flux:card>
                        </div>
                    @endforelse

                </div>

                {{-- PAGINATION --}}
                @if ($notifications->hasPages())
                    <div class="pt-2">
                        {{ $notifications->links() }}
                    </div>
                @endif

            </div>

            {{-- NOTIFICATION DETAIL MODAL --}}
            <x-notification-detail :notification="$selectedNotification" :message="$selectedNotificationMessage" />

        @endif

    @endif

</div>
