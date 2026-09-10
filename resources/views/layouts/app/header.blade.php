```blade id="a8v2kc"
<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">

    <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">

        <flux:sidebar.toggle class="mr-2 lg:hidden" icon="bars-2" inset="left" />

        <x-app-logo href="{{ route('overview') }}" wire:navigate />

        <flux:navbar class="-mb-px max-lg:hidden">

            <flux:navbar.item icon="squares-2x2" :href="route('overview')" :current="request()->routeIs('overview')"
                wire:navigate>
                {{ __('app.sidebar.overview') }}
            </flux:navbar.item>

        </flux:navbar>

        <flux:spacer />

        <x-desktop-user-menu />

    </flux:header>

    {{-- Mobile Menu --}}
    <flux:sidebar collapsible="mobile" sticky
        class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 lg:hidden">

        <flux:sidebar.header>

            <x-app-logo :sidebar="true" href="{{ route('overview') }}" wire:navigate />

            <flux:sidebar.collapse
                class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />

        </flux:sidebar.header>

        <flux:sidebar.nav>

            <flux:sidebar.item icon="squares-2x2" :href="route('overview')" :current="request()->routeIs('overview')"
                wire:navigate>
                {{ __('app.sidebar.overview') }}
            </flux:sidebar.item>

        </flux:sidebar.nav>

        <flux:spacer />

    </flux:sidebar>

    {{ $slot }}

    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist

    @fluxScripts

</body>

</html>
```
