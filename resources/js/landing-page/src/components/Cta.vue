<template>
    <div class="relative w-full overflow-hidden bg-jd-bg-deep">
        <DotCanvas class="absolute inset-0" />

        <Section
            variant="deep"
            size="lg"
            border-top
            container="max-w-7xl"
            class="relative z-10 pointer-events-none !bg-transparent"
        >
            <div class="flex flex-col items-center text-center">
                <span
                    class="text-jd-cyan text-sm font-bold tracking-[0.2em] uppercase mb-8 block reveal"
                    style="transition-delay: 0.1s"
                >
                    Limited Seats Available
                </span>

                <h2
                    class="text-5xl md:text-7xl font-montserrat font-black uppercase tracking-tight mb-8 leading-tight reveal"
                    style="transition-delay: 0.2s"
                >
                    BE PART OF THE <span class="text-jd-cyan">MOMENT</span>
                </h2>

                <p
                    class="text-jd-subtitle text-lg md:text-xl font-medium leading-relaxed max-w-3xl mb-12 reveal"
                    style="transition-delay: 0.3s"
                >
                    Bergabunglah bersama 500+ developer dan tech leader Jawa
                    Timur dalam acara yang mendefinisikan ulang masa depan
                    teknologi.
                </p>

                <div
                    class="flex flex-col sm:flex-row items-center justify-center gap-6 w-full sm:w-auto reveal pointer-events-auto"
                    style="transition-delay: 0.4s"
                >
                    <AppButton
                        :glow="true"
                        :href="primaryHref"
                        class="w-full sm:w-auto"
                    >
                        {{ primaryLabel }}
                        <span class="text-lg leading-none">&rarr;</span>
                    </AppButton>

                    <AppButton
                        variant="outline"
                        :href="secondaryHref"
                        class="w-full sm:w-auto"
                    >
                        {{ secondaryLabel }}
                        <span class="text-lg leading-none">&rarr;</span>
                    </AppButton>
                </div>
            </div>
        </Section>
    </div>
</template>

<script setup>
import Section from "./ui/Section.vue";
import AppButton from "./ui/AppButton.vue";
import DotCanvas from "./ui/DotCanvas.vue";
import { URLS } from "../constants";

defineProps({
    primaryLabel: { type: String, default: "JADI MEDIA PARTNER" },
    primaryHref: { type: String, default: URLS.PARTNERSHIP },
    secondaryLabel: { type: String, default: "JADI SPONSOR" },
    secondaryHref: { type: String, default: URLS.SPONSORSHIP },
});
</script>
