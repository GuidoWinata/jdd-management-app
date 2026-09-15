<template>
    <section
        class="min-h-screen text-white pt-56 pb-16 px-6 font-sans flex flex-col items-center text-center overflow-hidden relative"
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
                class="absolute -bottom-10 -left-12 md:-left-24 lg:-left-32 w-40 md:w-52 lg:w-64 z-20 pointer-events-none hidden md:block drop-shadow-2xl"
            />

            <!-- Mascot Kanan (Thumb Up) -->
            <img
                :src="mascotThumbUp"
                alt="Mascot Thumb Up"
                class="absolute -bottom-10 -right-12 md:-right-24 lg:-right-32 w-40 md:w-52 lg:w-64 z-20 pointer-events-none hidden md:block drop-shadow-2xl"
            />

            <!-- Headline -->
            <h1
                class="text-5xl md:text-6xl lg:text-7xl font-semibold tracking-tight leading-[1.1] mb-6"
            >
                Jatim Tech Hub Inclusive <br />
                Tech <span class="text-jd-cyan">Real Impact</span>
            </h1>

            <!-- Subtitle -->
            <p
                class="text-gray-300 text-sm md:text-base max-w-3xl mx-auto mb-12 leading-relaxed"
            >
                Konferensi eksklusif bagi para arsitek teknologi, developer, dan
                pemimpin industri Jawa Timur. <br class="hidden md:block" />
                Membangun masa depan digital dengan standar keunggulan kelas
                dunia.
            </p>

            <!-- Countdown Banner -->
            <div class="relative w-full py-3 px-6 mb-12">
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
                    Beli Tiket Pre-Sale 2
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