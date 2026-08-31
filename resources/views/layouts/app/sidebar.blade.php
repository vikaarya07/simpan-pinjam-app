<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-slate-50 text-slate-600 dark:bg-zinc-800">

    {{-- SIDEBAR --}}
    <flux:sidebar sticky persist="false" collapsible
        class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">

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
                wire:navigate>
                {{ __('Overview') }}
            </flux:sidebar.item>

        </flux:sidebar.nav>

        {{-- MEETING --}}
        <flux:sidebar.nav class="mt-4">

            {{-- Section Label --}}
            <div
                class="px-3 pb-1 text-[11px] font-semibold uppercase tracking-wider
                       text-zinc-400 dark:text-zinc-500
                       in-data-flux-sidebar-collapsed-desktop:hidden">
                Meeting
            </div>

            {{-- Meeting --}}
            <flux:sidebar.item icon="calendar-days" :href="route('meeting.index')"
                :current="request()->routeIs('meeting.*')" wire:navigate>
                {{ __('Pertemuan') }}

                <flux:badge size="sm" color="pink" class="shrink-0 px-1.5! py-0.5!">
                    Admin
                </flux:badge>
            </flux:sidebar.item>

        </flux:sidebar.nav>

        {{-- DATA MASTER --}}
        <flux:sidebar.nav class="mt-4">

            {{-- Section Label --}}
            <div
                class="px-3 pb-1 text-[11px] font-semibold uppercase tracking-wider
                       text-zinc-400 dark:text-zinc-500
                       in-data-flux-sidebar-collapsed-desktop:hidden">
                Data Master
            </div>

            {{-- Data Anggota --}}
            <flux:sidebar.item icon="users" :href="route('member.index')"
                :current="request()->routeIs('member.index')" wire:navigate>
                <span class="flex min-w-0 items-center gap-2">

                    <span class="truncate">
                        {{ __('Data Anggota') }}
                    </span>

                    <flux:badge size="sm" color="pink" class="shrink-0 px-1.5! py-0.5!">
                        Admin
                    </flux:badge>

                </span>
            </flux:sidebar.item>

            {{-- Data Nasabah --}}
            <flux:sidebar.item icon="user-group" :href="route('customer.index')"
                :current="request()->routeIs('customer.*')" wire:navigate>
                {{ __('Data Nasabah') }}
            </flux:sidebar.item>

        </flux:sidebar.nav>

        {{-- TRANSAKSI --}}
        <flux:sidebar.nav class="mt-4">

            {{-- Section Label --}}
            <div
                class="px-3 pb-1 text-[11px] font-semibold uppercase tracking-wider
                       text-zinc-400 dark:text-zinc-500
                       in-data-flux-sidebar-collapsed-desktop:hidden">
                Transaksi
            </div>

            {{-- Simpanan --}}
            <flux:sidebar.item icon="wallet" :href="route('saving.index')"
                :current="request()->routeIs('saving.index')" wire:navigate>
                {{ __('Simpanan') }}
            </flux:sidebar.item>

            {{-- Pinjaman --}}
            <flux:sidebar.item icon="banknotes" :href="route('loan.index')"
                :current="request()->routeIs('loan.index')" wire:navigate>
                {{ __('Pinjaman') }}
            </flux:sidebar.item>

            {{-- Angsuran --}}
            <flux:sidebar.item icon="receipt-percent" :href="route('payment.index')"
                :current="request()->routeIs('payment.*')" wire:navigate>
                {{ __('Angsuran') }}
            </flux:sidebar.item>

        </flux:sidebar.nav>

        {{-- LAPORAN --}}
        <flux:sidebar.nav class="mt-4">

            {{-- Section Label --}}
            <div
                class="px-3 pb-1 text-[11px] font-semibold uppercase tracking-wider
                       text-zinc-400 dark:text-zinc-500
                       in-data-flux-sidebar-collapsed-desktop:hidden">
                Laporan
            </div>

            {{-- Laporan Bulanan --}}
            <flux:sidebar.item icon="chart-bar" :href="route('report.monthly')"
                :current="request()->routeIs('report.monthly*')" wire:navigate>
                {{ __('Laporan Bulanan') }}
            </flux:sidebar.item>

            {{-- Laporan Nasabah --}}
            <flux:sidebar.item icon="document-chart-bar" :href="route('report.customer')"
                :current="request()->routeIs('report.customer*')" wire:navigate>
                {{ __('Laporan Nasabah') }}
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
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        {{-- Mobile User Menu --}}
        <flux:dropdown position="top" align="end">

            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>

                {{-- User Information --}}
                <flux:menu.radio.group>

                    <div class="p-0 text-sm font-normal">

                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">

                            <flux:avatar :name="auth()->user()->name" :initials="auth()->user()->initials()" />

                            <div class="grid flex-1 text-start text-sm leading-tight">

                                <flux:heading class="truncate">
                                    {{ auth()->user()->name }}
                                </flux:heading>

                                <flux:text class="truncate">
                                    {{ auth()->user()->email }}
                                </flux:text>

                            </div>

                        </div>

                    </div>

                </flux:menu.radio.group>

                <flux:menu.separator />

                {{-- Settings --}}
                <flux:menu.radio.group>

                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                        {{ __('Settings') }}
                    </flux:menu.item>

                </flux:menu.radio.group>

                <flux:menu.separator />

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf

                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                        class="w-full cursor-pointer" data-test="logout-button">
                        {{ __('Log out') }}
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
