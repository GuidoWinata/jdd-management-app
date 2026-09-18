<template>
    <section
        class="min-h-screen text-white pt-36 lg:pt-56 pb-16 px-6 font-sans flex flex-col items-center text-center overflow-hidden relative"
    >
        <!-- Background Image -->
        <div
            class="absolute inset-0 bg-cover bg-center bg-no-repeat z-0"
            :style="{ backgroundImage: `url(${heroImg})` }"
        ></div>

        <!-- Overlay gelap -->
        <div
            class="absolute inset-0 bg-jd-bg-deep/10 z-0 pointer-events-none"
        ></div>

        <div class="container mx-auto max-w-5xl relative z-10">
            
            <!-- Mascot Kiri (Wow) -->
            <img
                :src="mascotWow"
                alt="Mascot Wow"
                class="absolute -bottom-32 -left-6 sm:-bottom-12 sm:-left-12 md:-left-24 lg:-left-32 w-24 sm:w-40 md:w-52 lg:w-64 z-20 pointer-events-none drop-shadow-2xl"
            />

            <!-- Mascot Kanan (Thumb Up) -->
            <img
                :src="mascotThumbUp"
                alt="Mascot Thumb Up"
                class="absolute -bottom-32 -right-6 sm:-bottom-12 sm:-right-12 md:-right-24 lg:-right-32 w-24 sm:w-40 md:w-52 lg:w-64 z-20 pointer-events-none drop-shadow-2xl"
            />

            <!-- Headline -->
            <h1
                class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-semibold tracking-tight leading-[1.1] mb-6"
            >
                Jatim Developer Day 2026 <br />
                <span class="text-jd-cyan">Inclusive Tech, Real Impact</span>
            </h1>

            <!-- Subtitle -->
            <p
                class="text-gray-300 text-sm md:text-base max-w-3xl mx-auto mb-6 leading-relaxed"
            >
                An exclusive conference for tech architects, developers, and industry leaders in East Java.
                <br class="hidden md:block" />
                Building a digital future with world-class standards of excellence.
            </p>

            <!-- Event Location & Date -->
            <div
                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 backdrop-blur-sm text-sm md:text-base text-gray-200 mb-4 md:mb-10 shadow-sm"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4 md:w-4.5 md:h-4.5 text-jd-cyan shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                    <circle cx="12" cy="10" r="3" />
                </svg>
                <span class="font-medium tracking-wide">Pasuruan, November 7, 2026</span>
            </div>

            <!-- Countdown Banner -->
            <div class="relative w-full py-3 px-6 mb-6 md:mb-12">
                <!-- Latar Belakang Blur & Faded Edges -->
                <div
                    class="absolute inset-0 backdrop-blur-sm bg-white/5 pointer-events-none"
                    style="
                        -webkit-mask-image: linear-gradient(
                            to right,
                            transparent,
                            black 15%,
                            black 85%,
                            transparent
                        );
                        mask-image: linear-gradient(
                            to right,
                            transparent,
                            black 15%,
                            black 85%,
                            transparent
                        );
                    "
                ></div>

                <!-- Countdown Timer (Isolated Component) -->
                <div class="relative z-10">
                    <CountdownTimer />
                </div>
            </div>

            <!-- Action Buttons -->
            <div
                class="flex flex-col sm:flex-row items-center justify-center gap-4"
            >
                <!-- Primary Button -->
                <AppButton
                    :href="URLS.TICKET"
                    variant="primary"
                >
                    Beli Tiket
                </AppButton>

                <!-- Secondary Button (Glassmorphism) -->
                <AppButton
                    :href="URLS.SPONSORSHIP"
                    variant="glass"
                    :showArrow="true"
                >
                    Jadi Sponsorship
                </AppButton>
            </div>
        </div>
    </section>
</template>

<script setup>
import heroImg from "../assets/background-img.png";
import mascotWow from "../assets/mascot-wow.png";
import mascotThumbUp from "../assets/mascot-thumb-up.png";
import AppButton from "./ui/AppButton.vue";
import CountdownTimer from "./ui/CountdownTimer.vue";
import { URLS } from "../constants";
</script>