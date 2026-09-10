<div class="space-y-5">

    {{-- Header --}}
    <div>
        <flux:heading size="xl">
            {{ __('app.customer.detail_title') }}
        </flux:heading>

        <flux:text class="mt-1">
            {{ __('app.customer.detail_subtitle') }}
        </flux:text>
    </div>

    {{-- Customer Information --}}
    <flux:card class="border-none!">
        <div class="space-y-5">

            <div>
                <flux:heading size="sm">
                    {{ __('app.customer.information') }}
                </flux:heading>

                <flux:text size="sm" class="mt-1">
                    {{ __('app.customer.information_description') }}
                </flux:text>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

                {{-- NPK --}}
                <div>
                    <flux:text size="sm">
                        {{ __('app.customer.npk') }}
                    </flux:text>

                    <div class="mt-1 font-semibold">
                        {{ $customer->npk }}
                    </div>
                </div>

                {{-- Name --}}
                <div>
                    <flux:text size="sm">
                        {{ __('app.customer.name') }}
                    </flux:text>

                    <div class="mt-1 font-semibold">
                        {{ $customer->name }}
                    </div>
                </div>

                {{-- Phone --}}
                <div>
                    <flux:text size="sm">
                        {{ __('app.customer.phone') }}
                    </flux:text>

                    <div class="mt-1 font-semibold">
                        {{ $customer->phone ?: '-' }}
                    </div>
                </div>

            </div>
        </div>
    </flux:card>

    {{-- Loan History --}}
    <section class="space-y-4">

        <div>
            <flux:heading size="lg">
                {{ __('app.customer.loan_history') }}
            </flux:heading>

            <flux:text class="mt-1">
                {{ __('app.customer.loan_history_description') }}
            </flux:text>
        </div>

        <x-loan-history :customer="$customer" :items="$customer->loans" />

    </section>

</div>
