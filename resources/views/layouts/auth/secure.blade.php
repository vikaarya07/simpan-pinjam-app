<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark w-full overflow-hidden">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-zinc-100 antialiased dark:bg-zinc-950">

    <div class="flex min-h-svh items-center justify-center p-4">

        <main
            class="relative flex min-h-170 w-full max-w-115 flex-col
                   overflow-hidden rounded-4xl
                   border border-zinc-200/80
                   bg-white shadow-2xl shadow-zinc-300/30
                   dark:border-zinc-800 dark:bg-zinc-900
                   dark:shadow-black/30">

            {{-- Top Gradient --}}
            <div
                class="absolute inset-x-0 top-0 h-32
                       bg-linear-to-b from-zinc-100 to-transparent
                       dark:from-zinc-800/60 dark:to-transparent">
            </div>

            {{-- Header --}}
            <header class="relative flex items-center justify-between px-7 pt-7">

                <a href="{{ route('overview') }}" wire:navigate class="flex items-center gap-3">

                    <span
                        class="p-1 flex size-10 items-center justify-center
                               rounded-xl shadow">
                        <x-app-logo-icon />
                    </span>

                    <span
                        class="text-sm font-semibold tracking-tight
                               text-zinc-900 dark:text-white">
                        {{ config('app.name', 'Laravel') }}
                    </span>

                </a>

                <span
                    class="rounded-full border border-zinc-200
                           bg-white/80 px-3 py-1 text-[11px] font-medium
                           text-zinc-500
                           dark:border-zinc-700 dark:bg-zinc-800
                           dark:text-zinc-400">
                    {{ __('app.auth.layout.secure') }}
                </span>

            </header>

            {{-- Main Content --}}
            <div class="relative flex flex-1 flex-col justify-center p-7 sm:px-10">
                {{ $slot }}
            </div>

            {{-- Bottom Information --}}
            <footer
                class="border-t border-zinc-100 bg-zinc-50/80
                       px-7 py-5
                       dark:border-zinc-800 dark:bg-zinc-950/40">

                <div class="flex items-center justify-between gap-4">

                    <div>

                        <p class="text-xs font-medium text-zinc-700 dark:text-zinc-300">
                            {{ config('app.name', 'Laravel') }}
                        </p>

                        <p class="mt-0.5 text-[11px] text-zinc-400 dark:text-zinc-500">
                            {{ __('app.auth.layout.secure_account_access') }}
                        </p>

                    </div>

                    <div class="flex items-center gap-1.5 text-[11px] text-zinc-400">

                        <span class="size-1.5 rounded-full bg-emerald-500"></span>

                        {{ __('app.auth.layout.secure') }}

                    </div>

                </div>

            </footer>

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
