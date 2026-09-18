<template>
    <Section id="venue" variant="white">
        <SectionHeader
            number="02"
            label="Location & Venue"
            :description="subtitle"
            headline-class="text-3xl sm:text-5xl md:text-6xl font-semibold leading-[1.1] max-w-5xl mx-auto"
            description-class="text-gray-600 text-sm md:text-base max-w-3xl mx-auto lg:mb-12 mt-5 leading-relaxed"
        >
            JDD 2026 Lands in Pasuruan
        </SectionHeader>

        <!-- VENUE CONTENT GRID -->
        <div
            class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-stretch mt-2 md:mt-4"
        >
            <!-- LEFT COLUMN: Location Details & CTA -->
            <div
                class="lg:col-span-5 bg-background border border-gray-300 rounded-3xl p-6 sm:p-8 md:p-10 transition-all duration-300 relative overflow-hidden flex flex-col justify-between reveal-left group"
            >
                <div>
                    <div class="mb-3">
                        <span
                            class="text-jd-dark text-[11px] font-bold tracking-widest uppercase"
                            >Official Venue</span
                        >
                    </div>

                    <!-- Venue Title -->
                    <h3
                        class="text-2xl sm:text-3xl font-semibold text-gray-900 tracking-wide mb-3"
                    >
                        {{ locationName }}
                    </h3>

                    <p class="text-gray-500 text-sm leading-relaxed mb-6">
                        Pusat perhelatan utama Jatim Developer Day 2026.
                        Menghadirkan panggung konferensi, ruang workshop
                        kolaboratif, dan ekosistem networking yang nyaman bagi
                        para penggiat teknologi.
                    </p>

                    <!-- Address Box -->
                    <div
                        class="bg-gray-50 border border-gray-200 rounded-2xl p-4 sm:p-5 mb-6 relative z-10"
                    >
                        <div class="flex items-start gap-3.5">
                            <div
                                class="w-10 h-10 rounded-xl bg-jd-dark flex items-center justify-center text-white flex-shrink-0 mt-0.5"
                            >
                                <PhMapPin :size="20" :weight="'bold'" />
                            </div>

                            <div>
                                <span
                                    class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-500 block mb-1"
                                >
                                    Alamat Lengkap
                                </span>
                                <p
                                    class="text-sm font-semibold text-gray-800 leading-snug"
                                >
                                    {{ address }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Highlight Highlights -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 mb-8">
                        <div
                            class="flex items-center gap-2.5 p-2.5 rounded-xl bg-gray-100 border border-gray-200 text-xs text-gray-700 font-medium"
                        >
                            <div
                                class="w-6 h-6 rounded-lg bg-jd-dark flex items-center justify-center text-white shrink-0"
                            >
                                <PhTrain :size="17" :weight="'regular'" />
                            </div>
                            <span>±5 Menit dari Stasiun Bangil</span>
                        </div>
                        <div
                            class="flex items-center gap-2.5 p-2.5 rounded-xl bg-gray-100 border border-gray-200 text-xs text-gray-700 font-medium"
                        >
                            <div
                                class="w-6 h-6 rounded-lg bg-jd-dark flex items-center justify-center text-white shrink-0"
                            >
                                <PhBuildings :size="17" :weight="'regular'" />
                            </div>
                            <span>Auditorium & Ruang Paralel</span>
                        </div>
                        <div
                            class="flex items-center gap-2.5 p-2.5 rounded-xl bg-gray-100 border border-gray-200 text-xs text-gray-700 font-medium"
                        >
                            <div
                                class="w-6 h-6 rounded-lg bg-jd-dark flex items-center justify-center text-white shrink-0"
                            >
                                <PhCar :size="17" :weight="'regular'" />
                            </div>
                            <span>±10 Menit dari Exit Tol Bangil</span>
                        </div>
                        <div
                            class="flex items-center gap-2.5 p-2.5 rounded-xl bg-gray-100 border border-gray-200 text-xs text-gray-700 font-medium"
                        >
                            <div
                                class="w-6 h-6 rounded-lg bg-jd-dark flex items-center justify-center text-white shrink-0"
                            >
                                <PhLightning :size="17" :weight="'regular'" />
                            </div>
                            <span>High-Speed Wi-Fi & Lounge</span>
                        </div>
                    </div>
                </div>

                <!-- Button to Google Maps -->
                <div class="pt-2">
                    <AppButton
                        :href="mapsUrl"
                        target="_blank"
                        rel="noopener noreferrer"
                        :glow="true"
                        class="w-full flex items-center justify-center gap-2"
                    >
                        <span>Buka di Google Maps</span>
                        <PhArrowSquareOut
                            :size="16"
                            :weight="'bold'"
                            class="text-black"
                        />
                    </AppButton>
                </div>
            </div>

            <!-- RIGHT COLUMN: Venue Photo Showcase -->
            <div
                class="lg:col-span-7 relative rounded-3xl overflow-hidden border border-gray-200 bg-gray-100 shadow-lg group min-h-[380px] sm:min-h-[460px] md:min-h-[520px] flex flex-col justify-between p-6 sm:p-8 reveal-right"
            >
                <!-- Photo with Zoom & Grayscale hover -->
                <img
                    :src="photoUrl"
                    :alt="locationName"
                    class="absolute inset-0 w-full h-full object-cover hover-colorize"
                    loading="lazy"
                />

                <!-- Gradient Overlays for Readability & Seamless Theme Integration -->
                <div
                    class="absolute inset-0 bg-gradient-to-t from-jd-cyan/40 via-jd-cyan/20 to-transparent pointer-events-none"
                ></div>

                <!-- Bottom Glassmorphism Overlay Card -->
                <div
                    class="relative z-10 bg-white/90 backdrop-blur-md border border-gray-300 rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 mt-auto"
                >
                    <div>
                        <h4
                            class="text-gray-900 text-lg font-bold tracking-wide mb-0.5"
                        >
                            {{ locationName }}
                        </h4>
                        <span
                            class="text-xs text-gray-600 font-medium tracking-wide"
                        >
                            Kec. Bangil, Kab. Pasuruan, Jawa Timur
                        </span>
                    </div>

                    <a
                        :href="mapsUrl"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-jd-cyan hover:text-gray-900 transition-colors group/link self-start sm:self-auto"
                    >
                        <span>Petunjuk Arah</span>
                        <PhArrowSquareOut
                            class="w-3.5 h-3.5 transform group-hover/link:translate-x-0.5 group-hover/link:-translate-y-0.5 transition-transform"
                            :size="14"
                            :weight="'bold'"
                        />
                    </a>
                </div>
            </div>
        </div>
    </Section>
</template>

<script setup lang="ts">
import Section from "./ui/Section.vue";
import SectionHeader from "./ui/SectionHeader.vue";
import AppButton from "./ui/AppButton.vue";
import {
    PhMapPin,
    PhArrowSquareOut,
    PhTrain,
    PhBuildings,
    PhCar,
    PhLightning,
} from "@phosphor-icons/vue";
import auditoriumImg from "../assets/auditorium-yadika.webp";
import { URLS } from "../constants";

interface Props {
    title?: string;
    subtitle?: string;
    locationName?: string;
    address?: string;
    mapsUrl?: string;
    photoUrl?: string;
}

withDefaults(defineProps<Props>(), {
    title: "JDD 2026 Lands in Pasuruan",
    subtitle:
        "Tahun ini, kita berkumpul di Pasuruan untuk berbagi insight, bertukar pengalaman, dan membuka koneksi baru di dunia teknologi.",
    locationName: "ITB Yadika Pasuruan",
    address:
        "Jl. Salem No.3, Kersikan, Kec. Bangil, Pasuruan, Jawa Timur 67153",
    mapsUrl: URLS.VENUE_MAP,
    photoUrl: auditoriumImg,
});
</script>
