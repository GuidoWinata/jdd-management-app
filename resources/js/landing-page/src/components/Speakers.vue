<template>
    <Section id="speakers">
        <SectionHeader
            number="03"
            label="Meet Our Speakers"
            headline-class="text-5xl md:text-6xl font-semibold leading-[1.1] max-w-5xl mx-auto"
            description-class="text-gray-600 text-sm md:text-base max-w-3xl mx-auto mb-12 mt-5 leading-relaxed"
            description="Para praktisi global yang telah menguji keahlian mereka di skala produksi industri teknologi terbesar."
        >
            Meet Our Headliners
        </SectionHeader>

        <!-- SPEAKERS GRID -->
        <div
            v-if="speakersData && speakersData.length"
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"
        >
            <!-- ACTIVE SPEAKER CARD -->
            <div
                v-for="(speaker, index) in speakersData"
                :key="speaker.id"
                class="rounded-3xl overflow-hidden flex flex-col shadow-lg transition-transform duration-300 hover:-translate-y-2 cursor-pointer group"
                :style="{ transitionDelay: `${(index % 3) * 0.1}s` }"
            >
                <!-- TOP SECTION (Dark Green & Photo) -->
                <div
                    class="relative bg-jd-dark h-72 md:h-80 flex items-end justify-center overflow-hidden"
                >
                    <!-- Top Right Badge -->
                    <div
                        class="absolute top-5 right-5 bg-jd-cyan text-jd-dark text-[10px] md:text-xs font-bold px-4 py-1.5 rounded-full tracking-wider uppercase z-10 shadow-sm"
                    >
                        {{ speaker.speaker_group || "KEYNOTE SPEAKER" }}
                    </div>

                    <!-- Speaker Photo -->
                    <img
                        v-if="speakerPhoto(speaker.photo_path)"
                        :src="speakerPhoto(speaker.photo_path)"
                        :alt="speaker.name"
                        loading="lazy"
                        class="w-[85%] h-auto max-h-full object-cover object-bottom grayscale transition-all duration-500 group-hover:grayscale-0 group-hover:scale-105 relative z-0"
                    />

                    <!-- Fallback Text -->
                    <span
                        v-else
                        class="text-white/30 text-sm mb-10 tracking-widest uppercase"
                    >
                        [No Photo]
                    </span>
                </div>

                <!-- BOTTOM SECTION (Neon Block) -->
                <div
                    class="bg-jd-cyan p-5 md:p-6 text-jd-dark flex flex-col justify-center relative z-10"
                >
                    <h3
                        class="text-xl uppercase font-semibold mb-1 leading-none tracking-wider"
                    >
                        {{ speaker.name }}
                    </h3>
                    <p
                        class="text-[10px] md:text-xs font-semibold uppercase tracking-[0.15em] opacity-80"
                    >
                        {{ speaker.job_title }}
                    </p>
                </div>
            </div>

            <!-- PLACEHOLDER: Speaker TBA (Pending Card) -->
            <div
                v-for="placeholder in upcomingSpeakers"
                :key="placeholder.id"
                class="rounded-3xl overflow-hidden flex flex-col shadow-lg transition-transform duration-300 hover:-translate-y-2 cursor-pointer border border-jd-cyan/20"
            >
                <!-- TOP SECTION (Dark Terminal) -->
                <div
                    class="bg-jd-card relative h-72 md:h-80 flex flex-col items-center justify-center p-6"
                >

                    <!-- Top Right Badge -->
                    <div
                        class="absolute top-5 right-5 bg-jd-cyan text-jd-dark text-[10px] md:text-xs font-bold px-4 py-1.5 rounded-full tracking-wider uppercase z-10"
                    >
                        SLOT OPEN
                    </div>

                    <!-- Main Icon (Question Mark) -->
                    <div
                        class="text-[100px] md:text-[120px] leading-none text-white font-light select-none mt-4"
                    >
                        ?
                    </div>

                    <!-- Sub-label -->
                    <div
                        class="mt-6 text-white text-[10px] font-bold tracking-[0.3em] uppercase"
                    >
                        Identity Unknown
                    </div>
                </div>

                <!-- BOTTOM SECTION (Neon Block) -->
                <div
                    class="bg-jd-cyan p-5 md:p-6 text-jd-dark flex flex-col justify-center"
                >
                    <h4
                        class="text-sm md:text-base font-semibold tracking-wider mb-1 uppercase font-mono"
                    >
                        > SPEAKER_PENDING
                    </h4>
                    <span
                        class="text-jd-dark/70 text-[10px] tracking-[0.2em] uppercase font-mono font-semibold"
                    >
                        To be assigned
                    </span>
                </div>
            </div>
        </div>

        <!-- CTA: More Speakers Coming + Become a Speaker -->
        <div class="flex flex-col items-center gap-6 mt-14">
            <p
                class="text-gray-400 text-sm tracking-wide text-center flex items-center justify-center"
            >
                <span
                    class="inline-block w-2 h-2 rounded-full bg-jd-cyan mr-3 animate-pulse"
                ></span>
                More speakers to be announced soon
            </p>
            <AppButton
                :href="URLS.SPEAKER_FORM"
                target="_blank"
                variant="primary"
            >
                JADI SPEAKERS
                <PhArrowUpRight :size="16" :weight="'bold'" />
            </AppButton>
        </div>
    </Section>
</template>

<script setup lang="ts">
import Section from "./ui/Section.vue";
import SectionHeader from "./ui/SectionHeader.vue";
import AppButton from "./ui/AppButton.vue";
import { PhArrowUpRight } from "@phosphor-icons/vue";
import { useSpeakers } from "../composables/useEventData";
import { useConfig } from "../config";
import { URLS } from "../constants";

const speakersData = useSpeakers();
const { baseUrl } = useConfig();

// Placeholder untuk speaker yang belum diumumkan
const upcomingSpeakers = [
    { id: "tba-1", name: "Segera Diumumkan" },
    { id: "tba-2", name: "Segera Diumumkan" },
    { id: "tba-3", name: "Segera Diumumkan" },
];

function speakerPhoto(photoPath: string | null): string {
    if (!photoPath) return "";
    return photoPath.startsWith("http")
        ? photoPath
        : `${baseUrl}/storage/${photoPath}`;
}
</script>
