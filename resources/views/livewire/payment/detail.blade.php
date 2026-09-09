<div class="space-y-5">

    {{-- Header --}}
    <div>
        <flux:heading size="xl">
            {{ __('app.payment.detail.title') }}
        </flux:heading>

        <flux:text class="mt-1">
            {{ __('app.payment.detail.subtitle') }}
        </flux:text>
    </div>

    {{-- Loan Information --}}
    <flux:card class="border-none!">

        <div class="space-y-6">

            {{-- Header Card --}}
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <flux:text size="sm" class="font-medium">
                        {{ __('app.payment.detail.loan_number') }}
                    </flux:text>

                    <flux:heading size="lg" class="mt-1">
                        {{ $payment->loan->loan_number }}
                    </flux:heading>
                </div>

                <flux:badge :color="$payment->status->color()" size="sm">
                    {{ $payment->status->label() }}
                </flux:badge>

            </div>

            <flux:separator />

            {{-- Basic Information --}}
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">

                {{-- Nasabah --}}
                <div class="flex items-center gap-3">

                    <flux:avatar size="sm" :name="$payment->loan->member->name"
                        :initials="$payment->loan->member->initials()" circle color="auto" />

                    <div>
                        <flux:text size="sm" class="font-medium">
                            {{ __('app.payment.detail.name') }}
                        </flux:text>

                        <div class="mt-1 font-semibold">
                            {{ $payment->loan->member->name }}
                        </div>
                    </div>

                </div>

                {{-- Waktu --}}
                <div class="flex items-center gap-3">

                    <flux:icon name="calendar-days" class="mt-0.5 size-7 text-slate-500" />

                    <div>
                        <flux:text size="sm" class="font-medium">
                            {{ __('app.payment.detail.date') }}
                        </flux:text>

                        <div class="mt-1 font-medium">
                            {{ $payment->waktu }}
                        </div>
                    </div>

                </div>

                {{-- Pokok --}}
                <div class="flex items-center gap-3">

                    <flux:icon name="banknotes" class="mt-0.5 size-7 text-slate-500" />

                    <div>
                        <flux:text size="sm" class="font-medium">
                            {{ __('app.payment.detail.principal') }}
                        </flux:text>

                        <div class="mt-1 font-semibold">
                            {{ idr($payment->loan->principal) }}
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </flux:card>

    {{-- Payment Summary --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

        {{-- Total --}}
        <flux:card class="border-none!">

            <div class="flex items-start justify-between gap-3">

                <div>
                    <flux:text size="sm" class="font-medium">
                        {{ __('app.payment.detail.amount') }}
                    </flux:text>

                    <flux:heading size="lg" class="mt-2">
                        {{ idr($payment->loan->amount) }}
                    </flux:heading>
                </div>

                <flux:icon name="receipt-percent" class="size-7 text-zinc-500" />

            </div>

        </flux:card>

        {{-- Payment --}}
        <flux:card class="border-none!">

            <div class="flex items-start justify-between gap-3">

                <div>
                    <flux:text size="sm" class="font-medium">
                        {{ __('app.payment.detail.singular') . ' ' . __('app.payment.detail.to') }}-
                        {{ $payment->payment_count }}
                    </flux:text>

                    <flux:heading size="lg" class="mt-2">
                        {{ idr($payment->amount) }}
                    </flux:heading>
                </div>

                <flux:icon name="arrow-down-circle" class="size-7 text-zinc-500" />

            </div>

        </flux:card>

        {{-- Paid --}}
        <flux:card class="border-none!">

            <div class="flex items-start justify-between gap-3">

                <div>
                    <flux:text size="sm" class="font-medium">
                        {{ __('app.payment.detail.paid') }}
                    </flux:text>

                    <flux:heading size="lg" class="mt-2 text-green-600">
                        {{ idr($this->totalPaid) }}
                    </flux:heading>
                </div>

                <flux:icon name="check-circle" class="size-7 text-green-600" />

            </div>

        </flux:card>

    </div>

    {{-- Remaining --}}
    <flux:card class="border-none!">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <flux:text size="sm" class="font-medium">
                    {{ __('app.payment.detail.remaining') }}
                </flux:text>

                <flux:heading size="xl" class="mt-1 text-red-600">
                    {{ idr($payment->remaining_after_payment) }}
                </flux:heading>
            </div>

            <flux:icon name="exclamation-circle" class="hidden size-12 text-red-500 sm:block" />

        </div>

    </flux:card>

    {{-- Note --}}
    <flux:card class="border-none!">

        <div class="space-y-2">

            <div class="flex items-center gap-2">

                <flux:icon name="chat-bubble-left" class="size-5 text-zinc-400" />

                <flux:text size="sm" class="font-semibold">
                    {{ __('app.payment.detail.note') }}
                </flux:text>

            </div>

            <flux:text class="leading-relaxed">
                {{ $payment?->note ?? '-' }}
            </flux:text>

        </div>

    </flux:card>

</div>
