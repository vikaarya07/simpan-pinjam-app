<x-layouts::auth.secure :title="__('auth.email_verification.title')">

    <div class="mx-auto w-full max-w-md">

        {{-- Email Icon --}}
        <div class="mb-5 flex justify-center">
            <div
                class="flex size-14 items-center justify-center rounded-2xl
                       border border-zinc-200 bg-zinc-50 shadow-sm
                       dark:border-white/10 dark:bg-white/5">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.7" class="size-7 text-zinc-700 dark:text-zinc-200">
                    <rect width="18" height="14" x="3" y="5" rx="2" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m3 7 7.94 5.293a1.9 1.9 0 0 0 2.12 0L21 7" />
                </svg>
            </div>
        </div>

        {{-- Header --}}
        <div class="mb-5 text-center">
            <flux:heading size="xl" class="font-semibold tracking-tight">
                {{ __('auth.email_verification.heading') }}
            </flux:heading>

            <flux:text class="mx-auto mt-2 max-w-sm text-pretty">
                {{ __('auth.email_verification.description') }}
            </flux:text>
        </div>

        {{-- Verification Sent Status --}}
        @if (session('status') == 'verification-link-sent')
            <div
                class="mb-5 flex items-start gap-3 rounded-xl border
                       border-green-200 bg-green-50 px-4 py-3
                       dark:border-green-500/20 dark:bg-green-500/10">
                <div class="mt-0.5 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" class="size-5 text-green-600 dark:text-green-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" />
                    </svg>
                </div>

                <flux:text class="text-sm text-green-700 dark:text-green-400">
                    {{ __('auth.email_verification.verification_link_sent') }}
                </flux:text>
            </div>
        @endif

        {{-- Actions --}}
        <div class="space-y-3">

            {{-- Resend --}}
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <flux:button type="submit" variant="primary" class="w-full">
                    {{ __('auth.email_verification.resend_verification') }}
                </flux:button>
            </form>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <flux:button variant="ghost" type="submit" class="w-full" data-test="logout-button">
                    {{ __('auth.email_verification.logout') }}
                </flux:button>
            </form>

        </div>

        {{-- Help Text --}}
        <div
            class="mt-5 rounded-xl border border-zinc-200/80 bg-zinc-50/70
                   px-4 py-3 text-center text-xs leading-relaxed text-zinc-500
                   dark:border-white/10 dark:bg-white/5 dark:text-zinc-400">
            {{ __('auth.email_verification.help') }}
        </div>

    </div>

</x-layouts::auth.secure>