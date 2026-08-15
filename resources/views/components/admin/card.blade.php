@props(['fit' => false])

@php
    $heightClass = $fit ? 'h-auto' : 'h-full';
@endphp

<div
    {{ $attributes->merge(['class' => "border border-gray-200/50 rounded-3xl overflow-hidden bg-gray-50 p-2.5 text-card-foreground shadow-xs dark:border-neutral-700/80 dark:bg-neutral-800 {$heightClass}"]) }}>
    <div
        class="rounded-2xl border border-gray-100 bg-white p-2.5 text-card-foreground shadow-2xl shadow-gray-500/10 dark:border-neutral-600/60 dark:bg-neutral-800 {$heightClass}">
        <div class="p-2">
            {{ $slot }}
        </div>
    </div>
</div>
