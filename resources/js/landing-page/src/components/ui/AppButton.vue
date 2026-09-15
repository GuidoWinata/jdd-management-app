<template>
    <component
        :is="href ? 'a' : 'button'"
        :href="href"
        :class="[
            'w-full sm:w-auto px-8 py-3.5 rounded-full font-semibold text-xs md:text-sm tracking-widest uppercase transition-all duration-300 flex items-center justify-center gap-2',
            variant === 'primary'
                ? 'bg-jd-cyan hover:bg-jd-cyan-dark text-jd-on-cyan'
                : 'bg-white/5 backdrop-blur-sm hover:bg-white/30 text-white',
        ]"
    >
        <slot />

        <!-- Ikon panah (opsional, tampil jika prop showArrow = true) -->
        <span
            v-if="showArrow"
            class="text-lg leading-none transform -translate-y-[1px]"
        >
            ↗
        </span>
    </component>
</template>

<script setup>
defineProps({
    href: {
        type: String,
        default: null,
    },
    variant: {
        type: String,
        default: "primary", // Pilihan: 'primary' atau 'glass'
    },
    showArrow: {
        type: Boolean,
        default: false,
    },
});
</script>
