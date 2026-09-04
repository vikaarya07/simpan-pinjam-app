<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-zinc-100 antialiased dark:bg-zinc-950">

    <div class="flex min-h-svh items-center justify-center p-4">

        <main class="w-full max-w-lg">

            {{-- Brand Area --}}
            <div class="relative overflow-hidden rounded-t-4xl bg-zinc-900 px-7 pb-10 pt-7 sm:px-10 dark:bg-zinc-800">

                {{-- Decorative circles --}}
                <div class="pointer-events-none absolute -right-12 -top-16 size-40 rounded-full border border-white/10">
                </div>

                <div class="pointer-events-none absolute -bottom-24 -left-10 size-48 rounded-full border border-white/5">
                </div>

                <a href="{{ route('overview') }}" wire:navigate class="relative inline-flex items-center gap-3">
                    <span
                        class="flex size-10 items-center justify-center rounded-xl bg-white text-zinc-900">
                        <x-app-logo-icon class="size-6 fill-current" />
                    </span>

                    <span class="text-sm font-semibold text-white">
                        {{ config('app.name', 'Laravel') }}
                    </span>
                </a>

                <div class="relative mt-5">
                    <p class="text-xs font-medium uppercase tracking-[0.2em] text-white/50">
                        Welcome
                    </p>

                    <p class="mt-2 text-2xl font-semibold tracking-tight text-white">
                        Manage your account with ease.
                    </p>
                </div>

            </div>

            {{-- Form Area --}}
            <div
                class="relative -mt-6 rounded-4xl border border-zinc-200 bg-white px-7 py-8 shadow-xl shadow-zinc-300/30 sm:px-10 sm:py-9 dark:border-zinc-800 dark:bg-zinc-900 dark:shadow-black/30">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            <div class="px-6 py-5 text-center">
                <span class="text-[11px] text-zinc-400 dark:text-zinc-600">
                    © {{ date('Y') }} {{ config('app.name', 'Laravel') }}
                </span>
            </div>

        </main>

    </div>

    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist

    @fluxScripts

</body>

</html>
