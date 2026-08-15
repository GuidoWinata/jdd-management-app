@extends('_admin._layout.app')

@section('title', 'Dashboard')

@section('content')
    @php
        $today = now();

        $greeting = match (true) {
            $today->hour < 11 => 'Selamat Pagi',
            $today->hour < 15 => 'Selamat Siang',
            $today->hour < 18 => 'Selamat Sore',
            default => 'Selamat Malam',
        };
    @endphp

    <div class="space-y-8">

        {{-- HERO --}}
        <section class="relative overflow-hidden rounded-[32px] bg-white dark:bg-neutral-900 border border-white/20 dark:border-white/5 shadow-[0_10px_60px_rgba(0,0,0,0.06)] mb-10">

            {{-- Background Decoration --}}
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-0 right-0 w-[420px] h-[420px] bg-blue-500/10 blur-3xl rounded-full"
                     style="animation: blob1 8s ease-in-out infinite;"></div>
                <div class="absolute bottom-0 left-0 w-[320px] h-[320px] bg-indigo-500/10 blur-3xl rounded-full"
                     style="animation: blob2 10s ease-in-out infinite;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[300px] h-[300px] bg-violet-500/5 blur-3xl rounded-full"
                     style="animation: blob3 14s ease-in-out infinite;"></div>
            </div>

            <div class="relative px-8 lg:px-10 py-10 lg:py-12">

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-10">

                    {{-- LEFT --}}
                    <div class="max-w-2xl">

                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-neutral-100 dark:bg-white/5 mb-5">
                            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>

                            <span class="text-xs font-medium text-neutral-500 dark:text-neutral-400">
                                {{ $today->translatedFormat('l, d F Y') }}
                            </span>
                        </div>

                        <h1 class="text-4xl lg:text-5xl font-semibold tracking-tight text-neutral-900 dark:text-white leading-tight">
                            {{ $greeting }},
                            <span class="bg-gradient-to-r from-blue-600 to-indigo-500 bg-clip-text text-transparent">
                                {{ Auth::user()->name }}
                            </span>
                        </h1>

                        <p class="mt-4 text-[15px] leading-7 text-neutral-500 dark:text-neutral-400 max-w-xl">
                            Selamat datang kembali di Aplikasi <strong>Jatim Developer Day</strong>
                        </p>

                    </div>

                    {{-- RIGHT --}}
                    <div class="flex flex-col items-start lg:items-end">

                        <div class="text-[72px] leading-none font-light tracking-[-4px] text-neutral-900 dark:text-white tabular-nums"
                             id="dashboard-clock">
                            {{ $today->format('H:i') }}
                        </div>

                    </div>

                </div>
            </div>
        </section>

        {{-- STATS SUMMARY --}}
        <section class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-10">

            {{-- SPEAKER STAT CARD --}}
            <a navigate href="{{ route('admin.event_speakers.index') }}"
               class="group relative overflow-hidden rounded-[28px] bg-white dark:bg-neutral-900 border border-neutral-200/70 dark:border-white/5 p-7 transition-all duration-500 hover:-translate-y-1 hover:shadow-lg shadow-black/5 hover:shadow-blue-500/10">
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-500 bg-gradient-to-br from-blue-500/10 via-blue-500/5 to-transparent"></div>
                <div class="relative flex items-center justify-between">
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Total Speaker</p>
                        <div class="flex items-baseline gap-2">
                            <span class="text-4xl lg:text-5xl font-bold tracking-tight text-neutral-900 dark:text-white tabular-nums">
                                {{ $stats['total_speakers'] ?? 0 }}
                            </span>
                            <span class="text-sm font-medium text-neutral-400">pembicara</span>
                        </div>
                        <p class="text-xs text-blue-600 dark:text-blue-400 font-medium pt-1 flex items-center gap-1 group-hover:translate-x-0.5 transition-transform">
                            Lihat semua speaker &rarr;
                        </p>
                    </div>
                    <div class="size-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 text-white flex items-center justify-center shadow-lg shadow-blue-500/25 ring-1 ring-white/20 ring-inset group-hover:scale-105 transition-transform duration-300 [&_svg]:size-8 shrink-0">
                        @include('_admin._layout.icons.sidebar.speaker')
                    </div>
                </div>
            </a>

            {{-- PARTNER STAT CARD --}}
            <a navigate href="{{ route('admin.event_partners.index') }}"
               class="group relative overflow-hidden rounded-[28px] bg-white dark:bg-neutral-900 border border-neutral-200/70 dark:border-white/5 p-7 transition-all duration-500 hover:-translate-y-1 hover:shadow-lg shadow-black/5 hover:shadow-emerald-500/10">
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-500 bg-gradient-to-br from-emerald-500/10 via-emerald-500/5 to-transparent"></div>
                <div class="relative flex items-center justify-between">
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Total Partner & Sponsor</p>
                        <div class="flex items-baseline gap-2">
                            <span class="text-4xl lg:text-5xl font-bold tracking-tight text-neutral-900 dark:text-white tabular-nums">
                                {{ $stats['total_partners'] ?? 0 }}
                            </span>
                            <span class="text-sm font-medium text-neutral-400">mitra</span>
                        </div>
                        <p class="text-xs text-emerald-600 dark:text-emerald-400 font-medium pt-1 flex items-center gap-1 group-hover:translate-x-0.5 transition-transform">
                            Lihat semua partner &rarr;
                        </p>
                    </div>
                    <div class="size-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 text-white flex items-center justify-center shadow-lg shadow-emerald-500/25 ring-1 ring-white/20 ring-inset group-hover:scale-105 transition-transform duration-300 [&_svg]:size-8 shrink-0">
                        @include('_admin._layout.icons.sidebar.hand-shake')
                    </div>
                </div>
            </a>

        </section>

    </div>

    @push('scripts')
        <style>
            @keyframes blob1 {
                0%   { transform: translateX(0px); }
                20%  { transform: translateX(60px); }
                45%  { transform: translateX(-30px); }
                65%  { transform: translateX(80px); }
                80%  { transform: translateX(-50px); }
                100% { transform: translateX(0px); }
            }
            @keyframes blob2 {
                0%   { transform: translateX(0px); }
                25%  { transform: translateX(-70px); }
                50%  { transform: translateX(40px); }
                70%  { transform: translateX(-55px); }
                90%  { transform: translateX(30px); }
                100% { transform: translateX(0px); }
            }
            @keyframes blob3 {
                0%   { transform: translate(-50%, -50%) translateX(0px); }
                30%  { transform: translate(-50%, -50%) translateX(50px); }
                55%  { transform: translate(-50%, -50%) translateX(-60px); }
                75%  { transform: translate(-50%, -50%) translateX(35px); }
                100% { transform: translate(-50%, -50%) translateX(0px); }
            }
        </style>
        <script>
            (() => {
                const clock = document.getElementById('dashboard-clock');

                if (!clock) return;

                setInterval(() => {
                    const now = new Date();

                    clock.textContent = now.toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                }, 1000);
            })();
        </script>
    @endpush

@endsection