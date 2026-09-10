@props([
    'title' => null,
])

<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="w-full overflow-hidden">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        {{ $title ? $title . ' - ' . config('app.name') : config('app.name') }}
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @fluxAppearance
</head>

<body class="min-h-screen bg-slate-100 text-slate-900 antialiased
           dark:bg-slate-950 dark:text-slate-100">
    <div class="flex min-h-screen items-center justify-center p-4">

        <div
            class="grid w-full max-w-5xl overflow-hidden rounded-2xl border
                   border-slate-200 bg-white shadow-xl shadow-slate-900/5
                   dark:border-slate-800 dark:bg-slate-900
                   lg:min-h-170 lg:grid-cols-2">

            {{-- LEFT : ILLUSTRATION --}}
            <section class="relative hidden overflow-hidden bg-emerald-950 lg:flex lg:flex-col">

                {{-- Illustration --}}
                <div class="absolute inset-0 overflow-hidden">

                    {{-- Background --}}
                    <div class="absolute inset-0 bg-emerald-950"></div>

                    {{-- Illustration --}}
                    <div class="absolute inset-0 flex items-center justify-center">
                        <img src="{{ asset('storage/login.png') }}" :alt="__('app.auth.layout.logo')"
                            class="h-auto w-auto max-h-[55%] -translate-y-28 object-contain" />
                    </div>

                    {{-- Overlay --}}
                    <div
                        class="pointer-events-none absolute inset-0
                               bg-linear-to-br from-emerald-950/70
                               via-emerald-900/30 to-slate-950/60">
                    </div>

                </div>

                {{-- Decorative blur --}}
                <div
                    class="absolute -left-24 -top-24 size-72 rounded-full
                           bg-emerald-400/20 blur-3xl">
                </div>

                <div
                    class="absolute -bottom-32 -right-20 size-80 rounded-full
                           bg-emerald-300/20 blur-3xl">
                </div>

                {{-- Content --}}
                <div class="relative z-10 flex h-full min-h-170 flex-col p-7">

                    {{-- Logo --}}
                    <a href="{{ url('/') }}" class="flex w-fit items-center gap-3">
                        <div
                            class="flex size-12 items-center justify-center rounded-xl
                                   border border-white/20 bg-white/10 text-white
                                   backdrop-blur-sm">
                            <img src="{{ asset('storage/logo.png') }}" :alt="__('app.auth.layout.logo')"
                                class="size-9 object-contain">
                        </div>

                        <div>
                            <div class="text-lg font-bold tracking-wider text-white">
                                SATYA MUDA GETAS
                            </div>

                            <div class="text-xs font-medium tracking-wide text-emerald-100/60">
                                {{ __('app.auth.layout.savings') }}
                            </div>
                        </div>
                    </a>

                    {{-- Hero --}}
                    <div class="mt-auto">

                        {{-- Status --}}
                        <div
                            class="mb-3 inline-flex items-center gap-2 rounded-full
                                   border border-white/15 bg-white/10 px-3 py-1.5
                                   text-[11px] font-medium text-emerald-50
                                   backdrop-blur-sm">
                            <span class="size-1.5 rounded-full bg-emerald-300"></span>

                            {{ __('app.auth.layout.secure_simple_management') }}
                        </div>

                        {{-- Heading --}}
                        <h1
                            class="max-w-md text-3xl font-bold tracking-tight text-white
                                   xl:text-4xl">
                            {{ __('app.auth.layout.welcome_back') }}
                        </h1>

                        <p class="mt-2 max-w-md text-sm leading-6 text-emerald-50/75">
                            {{ __('app.auth.layout.management_description') }}
                        </p>

                        {{-- Features --}}
                        <div class="mt-4 grid grid-cols-3 gap-2.5">

                            {{-- Saving --}}
                            <div
                                class="flex items-start justify-between rounded-xl
                                       border border-white/10 bg-white/10 p-3
                                       backdrop-blur-sm">
                                <div class="space-y-0">
                                    <div class="text-xs font-semibold text-white">
                                        {{ __('app.auth.layout.savings') }}
                                    </div>

                                    <p class="text-[10px] leading-4 text-emerald-50/50">
                                        {{ __('app.auth.layout.manage_savings') }}
                                    </p>
                                </div>

                                <div
                                    class="flex size-8 items-center justify-center rounded-lg
                                           bg-emerald-400/15 text-emerald-300">
                                    <flux:icon.wallet class="size-4" />
                                </div>
                            </div>

                            {{-- Loan --}}
                            <div
                                class="flex items-start justify-between rounded-xl
                                       border border-white/10 bg-white/10 p-3
                                       backdrop-blur-sm">
                                <div class="space-y-0">
                                    <div class="text-xs font-semibold text-white">
                                        {{ __('app.auth.layout.loan') }}
                                    </div>

                                    <p class="text-[10px] leading-4 text-emerald-50/50">
                                        {{ __('app.auth.layout.manage_loans') }}
                                    </p>
                                </div>

                                <div
                                    class="flex size-8 items-center justify-center rounded-lg
                                           bg-emerald-400/15 text-emerald-300">
                                    <flux:icon.banknotes class="size-4" />
                                </div>
                            </div>

                            {{-- Payment --}}
                            <div
                                class="flex items-start justify-between rounded-xl
                                       border border-white/10 bg-white/10 p-3
                                       backdrop-blur-sm">
                                <div class="space-y-0">
                                    <div class="text-xs font-semibold text-white">
                                        {{ __('app.auth.layout.payment') }}
                                    </div>

                                    <p class="text-[10px] leading-4 text-emerald-50/50">
                                        {{ __('app.auth.layout.track_payments') }}
                                    </p>
                                </div>

                                <div
                                    class="flex size-8 items-center justify-center rounded-lg
                                           bg-emerald-400/15 text-emerald-300">
                                    <flux:icon.credit-card class="size-4" />
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Copyright --}}
                    <div class="mt-7 text-[11px] text-emerald-100/45">
                        © {{ date('Y') }} {{ config('app.name') }}.
                    </div>

                </div>
            </section>


            {{-- RIGHT : AUTH --}}
            <main class="flex items-center justify-center bg-white p-7
                       dark:bg-slate-900">
                <div class="w-full max-w-md">

                    {{-- Mobile Logo --}}
                    <div class="mb-8 flex justify-center lg:hidden">
                        <a href="{{ url('/') }}" class="flex items-center gap-3">
                            <div
                                class="flex size-10 items-center justify-center rounded-xl
                                       bg-emerald-50 text-emerald-600
                                       dark:bg-emerald-500/10 dark:text-emerald-400">
                                <flux:icon.shield-check class="size-5" />
                            </div>

                            <span class="font-bold tracking-tight">
                                {{ config('app.name') }}
                            </span>
                        </a>
                    </div>

                    {{-- Auth Content --}}
                    {{ $slot }}

                    {{-- Footer --}}
                    <div
                        class="mt-8 border-t border-slate-100 pt-5 text-center
                               dark:border-slate-800">
                        <p class="text-[11px] text-slate-400 dark:text-slate-500">
                            © {{ date('Y') }} {{ config('app.name') }}.
                            {{ __('app.auth.layout.all_rights_reserved') }}
                        </p>
                    </div>

                </div>
            </main>

        </div>
    </div>

    @fluxScripts
</body>

</html>
