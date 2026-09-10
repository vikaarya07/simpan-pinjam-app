<div class="space-y-5">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <flux:heading size="xl">
                {{ __('app.overview.title') }}
            </flux:heading>

            <flux:text class="mt-1">
                {{ __('app.overview.subtitle') }}
            </flux:text>
        </div>

        <flux:badge color="slate">
            {{ now()->translatedFormat('l, d F Y') }}
        </flux:badge>
    </div>

    {{-- FINANCIAL OVERVIEW --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Pinjaman Aktif --}}
        <flux:card class="border-none! p-5">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <flux:text class="text-sm font-medium">
                        {{ __('app.overview.financial.active_loans') }}
                    </flux:text>

                    <flux:heading size="lg" class="mt-2">
                        {{ $this->overview['loans']['running_count'] }}
                    </flux:heading>
                </div>

                <div class="flex size-10 items-center justify-center rounded-xl bg-slate-100">
                    <flux:icon.shopping-cart class="size-5 text-slate-700" />
                </div>
            </div>

            <flux:text class="mt-2 text-xs">
                {{ idr($this->overview['loans']['running_amount']) }}
            </flux:text>
        </flux:card>

        {{-- Saldo --}}
        <flux:card class="border-none! p-5">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <flux:text class="text-sm font-medium">
                        {{ __('app.overview.financial.balance') }}
                    </flux:text>

                    <flux:heading size="lg" class="mt-2 text-emerald-600">
                        {{ idr($this->overview['financial']['balance']) }}
                    </flux:heading>
                </div>

                <div class="flex size-10 items-center justify-center rounded-xl bg-emerald-50">
                    <flux:icon.banknotes class="size-5 text-emerald-600" />
                </div>
            </div>

            <flux:text class="mt-2 text-xs">
                {{ __('app.overview.financial.available_funds') }}
            </flux:text>
        </flux:card>

        {{-- Piutang --}}
        <flux:card class="border-none! p-5">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <flux:text class="text-sm font-medium">
                        {{ __('app.overview.financial.receivable') }}
                    </flux:text>

                    <flux:heading size="lg" class="mt-2 text-amber-600">
                        {{ idr($this->overview['financial']['receivable']) }}
                    </flux:heading>
                </div>

                <div class="flex size-10 items-center justify-center rounded-xl bg-amber-50">
                    <flux:icon.receipt-percent class="size-5 text-amber-600" />
                </div>
            </div>

            <flux:text class="mt-2 text-xs">
                {{ __('app.overview.financial.borrowed_money') }}
            </flux:text>
        </flux:card>

        {{-- Total Keseluruhan --}}
        <flux:card class="border-none! p-5">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <flux:text class="text-sm font-medium">
                        {{ __('app.overview.financial.total') }}
                    </flux:text>

                    <flux:heading size="lg" class="mt-2 text-indigo-600">
                        {{ idr($this->overview['financial']['amount']) }}
                    </flux:heading>
                </div>

                <div class="flex size-10 items-center justify-center rounded-xl bg-indigo-50">
                    <flux:icon.calculator class="size-5 text-indigo-600" />
                </div>
            </div>

            <flux:text class="mt-2 text-xs">
                {{ __('app.overview.financial.balance_plus_receivable') }}
            </flux:text>
        </flux:card>

    </div>

    {{-- MONTHLY OVERVIEW --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">

        {{-- Pinjaman --}}
        <flux:card class="border-none! p-5">
            <div class="flex items-center justify-between">
                <div>
                    <flux:heading size="sm">
                        {{ __('app.overview.monthly.loan') }}
                    </flux:heading>

                    <flux:text class="mt-1 text-xs">
                        {{ __('app.overview.monthly.loan_description') }}
                    </flux:text>
                </div>

                <flux:icon.arrow-down-right class="size-5 text-rose-500" />
            </div>

            <div class="mt-5">
                <flux:heading size="xl" class="text-rose-600">
                    {{ idr($this->overview['monthly']['loan_amount']) }}
                </flux:heading>

                <flux:text class="mt-1 text-sm">
                    {{ __('app.overview.monthly.transaction_count', [
                        'count' => $this->overview['monthly']['loan_count'],
                    ]) }}
                </flux:text>
            </div>
        </flux:card>

        {{-- Pembayaran --}}
        <flux:card class="border-none! p-5">
            <div class="flex items-center justify-between">
                <div>
                    <flux:heading size="sm">
                        {{ __('app.overview.monthly.payment') }}
                    </flux:heading>

                    <flux:text class="mt-1 text-xs">
                        {{ __('app.overview.monthly.payment_description') }}
                    </flux:text>
                </div>

                <flux:icon.arrow-up-right class="size-5 text-emerald-500" />
            </div>

            <div class="mt-5">
                <flux:heading size="xl" class="text-emerald-600">
                    {{ idr($this->overview['monthly']['payment_amount']) }}
                </flux:heading>

                <flux:text class="mt-1 text-sm">
                    {{ __('app.overview.monthly.transaction_count', [
                        'count' => $this->overview['monthly']['payment_count'],
                    ]) }}
                </flux:text>
            </div>
        </flux:card>

        {{-- Nasabah --}}
        <flux:card class="border-none! p-5">
            <div class="flex items-center justify-between">
                <div>
                    <flux:heading size="sm">
                        {{ __('app.overview.monthly.customers') }}
                    </flux:heading>

                    <flux:text class="mt-1 text-xs">
                        {{ __('app.overview.monthly.membership_data') }}
                    </flux:text>
                </div>

                <flux:icon.users class="size-5 text-slate-600" />
            </div>

            <div class="mt-5 grid grid-cols-3 divide-x divide-y-0 divide-slate-200 gap-3">
                <div>
                    <flux:heading size="xl" class="mt-2">
                        {{ $this->overview['members']['total'] }}
                    </flux:heading>

                    <flux:text size="sm">
                        {{ __('app.overview.monthly.total_members') }}
                    </flux:text>
                </div>

                <div>
                    <flux:heading size="xl" class="mt-2">
                        {{ $this->overview['members']['customers'] }}
                    </flux:heading>

                    <flux:text size="sm">
                        {{ __('app.overview.monthly.customer_count') }}
                    </flux:text>
                </div>

                <div>
                    <flux:heading size="xl" class="mt-2">
                        {{ $this->overview['loans']['running_count'] }}
                    </flux:heading>

                    <flux:text size="sm">
                        {{ __('app.overview.monthly.active_loans') }}
                    </flux:text>
                </div>
            </div>
        </flux:card>

    </div>

    {{-- LOAN STATUS --}}
    <flux:card class="border-none! p-5">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <flux:heading size="lg">
                    {{ __('app.overview.loan_status.title') }}
                </flux:heading>

                <flux:text class="mt-1">
                    {{ __('app.overview.loan_status.description') }}
                </flux:text>
            </div>

            <flux:badge color="slate">
                {{ __('app.overview.loan_status.loan_count', [
                    'count' => $this->overview['loans']['total_count'],
                ]) }}
            </flux:badge>
        </div>

        <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-3">

            {{-- Running --}}
            <div class="rounded-xl border border-blue-200 bg-blue-50/60 p-4">
                <div class="flex items-center justify-between">
                    <flux:text class="font-medium text-blue-900">
                        {{ __('app.overview.loan_status.running') }}
                    </flux:text>

                    <flux:badge color="blue">
                        {{ $this->overview['loans']['running_count'] }}
                    </flux:badge>
                </div>

                <flux:heading size="lg" class="mt-3 text-blue-700">
                    {{ idr($this->overview['loans']['running_amount']) }}
                </flux:heading>
            </div>

            {{-- Finish --}}
            <div class="rounded-xl border border-green-200 bg-green-50/60 p-4">
                <div class="flex items-center justify-between">
                    <flux:text class="font-medium text-green-900">
                        {{ __('app.overview.loan_status.finished') }}
                    </flux:text>

                    <flux:badge color="green">
                        {{ $this->overview['loans']['finish_count'] }}
                    </flux:badge>
                </div>

                <flux:heading size="lg" class="mt-3 text-green-700">
                    {{ idr($this->overview['loans']['finish_amount']) }}
                </flux:heading>
            </div>

            {{-- Overdue --}}
            <div class="rounded-xl border border-red-200 bg-red-50/60 p-4">
                <div class="flex items-center justify-between">
                    <flux:text class="font-medium text-red-900">
                        {{ __('app.overview.loan_status.overdue') }}
                    </flux:text>

                    <flux:badge color="red">
                        {{ $this->overview['loans']['overdue_count'] }}
                    </flux:badge>
                </div>

                <flux:heading size="lg" class="mt-3 text-red-700">
                    {{ idr($this->overview['loans']['overdue_amount']) }}
                </flux:heading>
            </div>

        </div>
    </flux:card>

    {{-- PAYMENT PROGRESS --}}
    <flux:card class="border-none! p-5">
        <div>
            <flux:heading size="lg">
                {{ __('app.overview.payment_progress.title') }}
            </flux:heading>

            <flux:text class="mt-1">
                {{ __('app.overview.payment_progress.description') }}
            </flux:text>
        </div>

        <div class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6">
            @foreach ($this->overview['payments']['meetings'] as $meeting)
                <div class="rounded-xl border border-slate-300 p-4 text-center">

                    <flux:text class="text-xs font-medium">
                        {{ __('app.overview.payment_progress.payment_number', [
                            'number' => $meeting['number'],
                        ]) }}
                    </flux:text>

                    <flux:heading size="lg" class="mt-2">
                        {{ $meeting['clear'] }}
                    </flux:heading>

                    <flux:text class="mt-1 text-xs">
                        {{ __('app.overview.payment_progress.payment') }}
                    </flux:text>

                    <div class="mt-3 flex justify-center gap-1">
                        @if ($meeting['skip'] > 0)
                            <flux:badge size="sm" color="amber">
                                {{ __('app.overview.payment_progress.skip', [
                                    'count' => $meeting['skip'],
                                ]) }}
                            </flux:badge>
                        @endif

                        @if ($meeting['unpaid'] > 0)
                            <flux:badge size="sm" color="rose">
                                {{ __('app.overview.payment_progress.unpaid', [
                                    'count' => $meeting['unpaid'],
                                ]) }}
                            </flux:badge>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>
    </flux:card>

    {{-- RECENT ACTIVITY + QUICK ACTION --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">

        {{-- Recent Activity --}}
        <flux:card class="border-none! p-5 lg:col-span-2">
            <div class="flex items-center justify-between">
                <div>
                    <flux:heading size="lg">
                        {{ __('app.overview.activity.title') }}
                    </flux:heading>

                    <flux:text class="mt-1">
                        {{ __('app.overview.activity.description') }}
                    </flux:text>
                </div>

                <flux:select size="xs" wire:model.live="activitySort" class="w-auto">
                    <option value="date">
                        {{ __('app.overview.activity.sort_date') }}
                    </option>

                    <option value="created">
                        {{ __('app.overview.activity.sort_created') }}
                    </option>
                </flux:select>
            </div>

            <div class="mt-5 divide-y divide-slate-100">
                @forelse ($this->overview['activities'] as $activity)
                    <div class="flex items-center gap-3 py-3">

                        <div @class([
                            'flex size-9 shrink-0 items-center justify-center rounded-full',
                            'bg-indigo-50 text-indigo-600' => $activity['type'] === 'loan',
                            'bg-green-50 text-green-600' => $activity['type'] === 'payment',
                            'bg-slate-100 text-slate-600' => $activity['type'] === 'saving',
                        ])>
                            <flux:icon
                                :name="$activity['type'] === 'loan' ?
                                    'banknotes' :
                                    ($activity['type'] === 'payment' ?
                                        'arrow-up-right' :
                                        'wallet')"
                                class="size-4" />
                        </div>

                        <div class="min-w-0 flex-1">
                            <flux:text class="truncate font-medium">
                                {{ $activity['title'] }}
                            </flux:text>

                            <flux:text class="text-xs">
                                {{ $activity['description'] }}
                            </flux:text>
                        </div>

                        <div class="shrink-0 text-right">
                            <flux:text class="text-xs">
                                {{ $activity['time']->translatedFormat('l, d F Y') }}
                            </flux:text>

                            @if ($activity['amount'] > 0)
                                <flux:text class="text-sm font-semibold">
                                    {{ idr($activity['amount']) }}
                                </flux:text>
                            @else
                                <flux:text class="text-sm font-semibold">
                                    Rp 0
                                </flux:text>
                            @endif
                        </div>

                    </div>

                @empty
                    <div class="py-10 text-center">
                        <flux:icon.information-circle class="mx-auto size-8 text-slate-300" />

                        <flux:text class="mt-2">
                            {{ __('app.overview.activity.empty') }}
                        </flux:text>
                    </div>
                @endforelse
            </div>
        </flux:card>

        {{-- Quick Action --}}
        <flux:card class="border-none! p-5">
            <div>
                <flux:heading size="lg">
                    {{ __('app.overview.quick_action.title') }}
                </flux:heading>

                <flux:text class="mt-1">
                    {{ __('app.overview.quick_action.description') }}
                </flux:text>
            </div>

            <div class="mt-5 grid grid-cols-2 gap-3">
                <flux:button variant="outline" icon="banknotes" href="{{ route('loan.index') }}"
                    class="justify-start">
                    {{ __('app.overview.quick_action.loan') }}
                </flux:button>

                <flux:button variant="outline" icon="credit-card" href="{{ route('payment.index') }}"
                    class="justify-start">
                    {{ __('app.overview.quick_action.payment') }}
                </flux:button>
            </div>

            <div class="mt-3">
                <flux:button variant="outline" icon="wallet" href="{{ route('saving.index') }}"
                    class="w-full justify-start">
                    {{ __('app.overview.quick_action.saving') }}
                </flux:button>
            </div>

            <div class="mt-5 grid grid-cols-2 gap-3">
                <flux:button variant="outline" icon="document-chart-bar" href="{{ route('member.index') }}"
                    class="justify-start">
                    {{ __('app.overview.quick_action.monthly_report') }}
                </flux:button>

                <flux:button variant="outline" icon="clipboard-document-check" href="{{ route('loan.index') }}"
                    class="justify-start">
                    {{ __('app.overview.quick_action.customer_report') }}
                </flux:button>
            </div>
        </flux:card>

    </div>

</div>