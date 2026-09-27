<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-slate-100! text-slate-600! dark:bg-slate-950!">

    {{-- SIDEBAR --}}
    <flux:sidebar sticky persist="false" collapsible class="bg-white text-slate-600! dark:bg-slate-950">

        {{-- Header --}}
        <flux:sidebar.header class="mb-2">

            <x-app-logo :sidebar="true" href="{{ route('overview') }}" wire:navigate />

            <flux:sidebar.collapse
                class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />

        </flux:sidebar.header>

        {{-- OVERVIEW --}}
        <flux:sidebar.nav>

            {{-- Overview --}}
            <flux:sidebar.item icon="squares-2x2" :href="route('overview')" :current="request()->routeIs('overview')"
                wire:navigate
                class="
                    text-slate-600!
                    hover:bg-emerald-400!
                    hover:text-emerald-50!
                    data-current:bg-emerald-400!
                    data-current:text-emerald-50!
                    dark:text-slate-600!
                    dark:hover:bg-emerald-400!
                    dark:hover:text-emerald-50!
                    dark:data-current:bg-emerald-400!
                    dark:data-current:text-emerald-50!
                    dark:data-current:hover:bg-emerald-400!
                    dark:data-current:hover:text-emerald-50!
                ">
                {{ __('app.sidebar.overview') }}
            </flux:sidebar.item>

        </flux:sidebar.nav>

        {{-- MEETING --}}
        <flux:sidebar.nav class="mt-4">

            {{-- Section Label --}}
            <div
                class="px-3 pb-1 text-[11px] font-semibold uppercase tracking-wider
                       text-slate-400 dark:text-slate-500
                       in-data-flux-sidebar-collapsed-desktop:hidden">
                {{ __('app.sidebar.sections.meeting') }}
            </div>

            {{-- Meeting --}}
            <flux:sidebar.item icon="calendar-days" :href="route('meeting.index')"
                :current="request()->routeIs('meeting.*')" wire:navigate
                class="
                    text-slate-600!
                    hover:bg-emerald-400!
                    hover:text-emerald-50!
                    data-current:bg-emerald-400!
                    data-current:text-emerald-50!
                    dark:text-slate-600!
                    dark:hover:bg-emerald-400!
                    dark:hover:text-emerald-50!
                    dark:data-current:bg-emerald-400!
                    dark:data-current:text-emerald-50!
                    dark:data-current:hover:bg-emerald-400!
                    dark:data-current:hover:text-emerald-50!
                ">
                {{ __('app.sidebar.meeting') }}

                <flux:badge size="sm" color="pink" variant="solid" class="shrink-0 px-1.5! py-0.5!">
                    {{ __('app.sidebar.admin') }}
                </flux:badge>
            </flux:sidebar.item>

        </flux:sidebar.nav>

        {{-- DATA MASTER --}}
        <flux:sidebar.nav class="mt-4">

            {{-- Section Label --}}
            <div
                class="px-3 pb-1 text-[11px] font-semibold uppercase tracking-wider
                       text-slate-400 dark:text-slate-500
                       in-data-flux-sidebar-collapsed-desktop:hidden">
                {{ __('app.sidebar.sections.master_data') }}
            </div>

            {{-- Data Anggota --}}
            <flux:sidebar.item icon="users" :href="route('member.index')"
                :current="request()->routeIs('member.index')" wire:navigate
                class="
                    text-slate-600!
                    hover:bg-emerald-400!
                    hover:text-emerald-50!
                    data-current:bg-emerald-400!
                    data-current:text-emerald-50!
                    dark:text-slate-600!
                    dark:hover:bg-emerald-400!
                    dark:hover:text-emerald-50!
                    dark:data-current:bg-emerald-400!
                    dark:data-current:text-emerald-50!
                    dark:data-current:hover:bg-emerald-400!
                    dark:data-current:hover:text-emerald-50!
                ">
                {{ __('app.sidebar.members') }}

                <flux:badge size="sm" color="pink" variant="solid" class="shrink-0 px-1.5! py-0.5!">
                    {{ __('app.sidebar.admin') }}
                </flux:badge>
            </flux:sidebar.item>

            {{-- Data Nasabah --}}
            <flux:sidebar.item icon="user-group" :href="route('customer.index')"
                :current="request()->routeIs('customer.*')" wire:navigate
                class="
                    text-slate-600!
                    hover:bg-emerald-400!
                    hover:text-emerald-50!
                    data-current:bg-emerald-400!
                    data-current:text-emerald-50!
                    dark:text-slate-600!
                    dark:hover:bg-emerald-400!
                    dark:hover:text-emerald-50!
                    dark:data-current:bg-emerald-400!
                    dark:data-current:text-emerald-50!
                    dark:data-current:hover:bg-emerald-400!
                    dark:data-current:hover:text-emerald-50!
                ">
                {{ __('app.sidebar.customers') }}
            </flux:sidebar.item>

        </flux:sidebar.nav>

        {{-- TRANSAKSI --}}
        <flux:sidebar.nav class="mt-4">

            {{-- Section Label --}}
            <div
                class="px-3 pb-1 text-[11px] font-semibold uppercase tracking-wider
                       text-slate-400 dark:text-slate-500
                       in-data-flux-sidebar-collapsed-desktop:hidden">
                {{ __('app.sidebar.sections.transactions') }}
            </div>

            {{-- Simpanan --}}
            <flux:sidebar.item icon="wallet" :href="route('saving.index')"
                :current="request()->routeIs('saving.index')" wire:navigate
                class="
                    text-slate-600!
                    hover:bg-emerald-400!
                    hover:text-emerald-50!
                    data-current:bg-emerald-400!
                    data-current:text-emerald-50!
                    dark:text-slate-600!
                    dark:hover:bg-emerald-400!
                    dark:hover:text-emerald-50!
                    dark:data-current:bg-emerald-400!
                    dark:data-current:text-emerald-50!
                    dark:data-current:hover:bg-emerald-400!
                    dark:data-current:hover:text-emerald-50!
                ">
                {{ __('app.sidebar.savings') }}
            </flux:sidebar.item>

            {{-- Pinjaman --}}
            <flux:sidebar.item icon="banknotes" :href="route('loan.index')"
                :current="request()->routeIs('loan.index')" wire:navigate
                class="
                    text-slate-600!
                    hover:bg-emerald-400!
                    hover:text-emerald-50!
                    data-current:bg-emerald-400!
                    data-current:text-emerald-50!
                    dark:text-slate-600!
                    dark:hover:bg-emerald-400!
                    dark:hover:text-emerald-50!
                    dark:data-current:bg-emerald-400!
                    dark:data-current:text-emerald-50!
                    dark:data-current:hover:bg-emerald-400!
                    dark:data-current:hover:text-emerald-50!
                ">
                {{ __('app.sidebar.loans') }}
            </flux:sidebar.item>

            {{-- Angsuran --}}
            <flux:sidebar.item icon="receipt-percent" :href="route('payment.index')"
                :current="request()->routeIs('payment.*')" wire:navigate
                class="
                    text-slate-600!
                    hover:bg-emerald-400!
                    hover:text-emerald-50!
                    data-current:bg-emerald-400!
                    data-current:text-emerald-50!
                    dark:text-slate-600!
                    dark:hover:bg-emerald-400!
                    dark:hover:text-emerald-50!
                    dark:data-current:bg-emerald-400!
                    dark:data-current:text-emerald-50!
                    dark:data-current:hover:bg-emerald-400!
                    dark:data-current:hover:text-emerald-50!
                ">
                {{ __('app.sidebar.payments') }}
            </flux:sidebar.item>

        </flux:sidebar.nav>

        {{-- LAPORAN --}}
        <flux:sidebar.nav class="mt-4">

            {{-- Section Label --}}
            <div
                class="px-3 pb-1 text-[11px] font-semibold uppercase tracking-wider
                       text-slate-400 dark:text-slate-500
                       in-data-flux-sidebar-collapsed-desktop:hidden">
                {{ __('app.sidebar.sections.reports') }}
            </div>

            {{-- Laporan Bulanan --}}
            <flux:sidebar.item icon="chart-bar" :href="route('report.monthly')"
                :current="request()->routeIs('report.monthly*')" wire:navigate
                class="
                    text-slate-600!
                    hover:bg-emerald-400!
                    hover:text-emerald-50!
                    data-current:bg-emerald-400!
                    data-current:text-emerald-50!
                    dark:text-slate-600!
                    dark:hover:bg-emerald-400!
                    dark:hover:text-emerald-50!
                    dark:data-current:bg-emerald-400!
                    dark:data-current:text-emerald-50!
                    dark:data-current:hover:bg-emerald-400!
                    dark:data-current:hover:text-emerald-50!
                ">
                {{ __('app.sidebar.monthly_report') }}
            </flux:sidebar.item>

            {{-- Laporan Nasabah --}}
            <flux:sidebar.item icon="document-chart-bar" :href="route('report.customer')"
                :current="request()->routeIs('report.customer*')" wire:navigate
                class="
                    text-slate-600!
                    hover:bg-emerald-400!
                    hover:text-emerald-50!
                    data-current:bg-emerald-400!
                    data-current:text-emerald-50!
                    dark:text-slate-600!
                    dark:hover:bg-emerald-400!
                    dark:hover:text-emerald-50!
                    dark:data-current:bg-emerald-400!
                    dark:data-current:text-emerald-50!
                    dark:data-current:hover:bg-emerald-400!
                    dark:data-current:hover:text-emerald-50!
                ">
                {{ __('app.sidebar.customer_report') }}
            </flux:sidebar.item>

        </flux:sidebar.nav>

        {{-- Spacer --}}
        <flux:spacer />

        {{-- Desktop User Menu --}}
        <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />

    </flux:sidebar>

    {{-- MOBILE HEADER --}}
    <flux:header class="lg:hidden">

        {{-- Mobile Sidebar Toggle --}}
        <flux:sidebar.toggle class="lg:hidden" icon="bars-3-bottom-left" inset="left" />

        <flux:spacer />

        {{-- Mobile User Menu --}}
        <flux:dropdown position="top" align="end">

            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" avatar:color="auto"
                circle />

            <flux:menu>

                {{-- User Information --}}
                <flux:menu.radio.group>

                    <div class="p-0 text-sm font-normal">

                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">

                            <flux:avatar :name="auth()->user()->name" :initials="auth()->user()->initials()"
                                color="auto" circle badge badge:circle badge:color="green" />

                            <div class="min-w-0 flex-1">

                                <div
                                    class="truncate text-sm font-semibold
                                           text-slate-800 dark:text-slate-100">
                                    {{ auth()->user()->name }}
                                </div>

                                <div
                                    class="truncate text-xs
                                           text-slate-500 dark:text-slate-400">
                                    {{ auth()->user()->email }}
                                </div>

                            </div>

                        </div>

                    </div>

                </flux:menu.radio.group>

                <flux:menu.separator />

                {{-- Settings --}}
                <flux:menu.radio.group>

                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                        {{ __('app.sidebar.settings') }}
                    </flux:menu.item>

                </flux:menu.radio.group>

                <flux:menu.separator />

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf

                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                        class="w-full cursor-pointer" data-test="logout-button">
                        {{ __('app.sidebar.logout') }}
                    </flux:menu.item>

                </form>

            </flux:menu>

        </flux:dropdown>

    </flux:header>

    {{-- PAGE CONTENT --}}
    {{ $slot }}

    {{-- TOAST --}}
    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist

    @fluxScripts

</body>

</html>