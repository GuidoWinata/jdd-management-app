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
                >
                    <!-- Tekstur Stardust -->
                    <div
                        class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')]"
                    ></div>
                </div>

                <!-- Konten Timer -->
                <div class="relative z-10">
                    <h3
                        class="text-white text-[10px] md:text-sm font-semibold tracking-[0.3em] uppercase mb-8"
                    >
                        Counting Down To Launch
                    </h3>

                    <!-- Timer Grid -->
                    <div
                        class="flex items-center justify-center gap-4 md:gap-5"
                    >
                        <!-- Days -->
                        <div class="flex flex-col items-center w-16 md:w-24">
                            <span
                                class="text-4xl md:text-5xl lg:text-6xl font-light text-white mb-2 tracking-tight"
                                >{{ timer.days }}</span
                            >
                            <span
                                class="text-jd-cyan text-sm font-semibold tracking-widest uppercase"
                                >Days</span
                            >
                        </div>

                        <span
                            class="text-2xl md:text-4xl font-light text-gray-500/50 mb-6"
                            >:</span
                        >

                        <!-- Hours -->
                        <div class="flex flex-col items-center w-16 md:w-24">
                            <span
                                class="text-4xl md:text-5xl lg:text-6xl font-light text-white mb-2 tracking-tight"
                                >{{ timer.hours }}</span
                            >
                            <span
                                class="text-jd-cyan text-sm font-semibold tracking-widest uppercase"
                                >Hours</span
                            >
                        </div>

                        <span
                            class="text-2xl md:text-4xl font-light text-gray-500/50 mb-6"
                            >:</span
                        >

                        <!-- Minutes -->
                        <div class="flex flex-col items-center w-16 md:w-24">
                            <span
                                class="text-4xl md:text-5xl lg:text-6xl font-light text-white mb-2 tracking-tight"
                                >{{ timer.minutes }}</span
                            >
                            <span
                                class="text-jd-cyan text-sm font-semibold tracking-widest uppercase"
                                >Mins</span
                            >
                        </div>

                        <span
                            class="text-2xl md:text-4xl font-light text-gray-500/50 mb-6"
                            >:</span
                        >

                        <!-- Seconds -->
                        <div class="flex flex-col items-center w-16 md:w-24">
                            <span
                                class="text-4xl md:text-5xl lg:text-6xl font-light text-white mb-2 tracking-tight"
                                >{{ timer.seconds }}</span
                            >
                            <span
                                class="text-jd-cyan text-sm font-semibold tracking-widest uppercase"
                                >Secs</span
                            >
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div
                class="flex flex-col sm:flex-row items-center justify-center gap-4"
            >
                <!-- Primary Button -->
                <AppButton
                    href="https://avora.id/jatimdeveloperday/jatim-developer-day-2026"
                    variant="primary"
                >
                    Beli Tiket Pre-Sale 2
                </AppButton>

                <!-- Secondary Button (Glassmorphism) -->
                <AppButton
                    href="https://s.id/sponsorshipjdd2026"
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
import { ref, onMounted, onUnmounted } from "vue";
import heroImg from "../assets/background-img.png";
import mascotWow from "../assets/mascot-wow.png";
import mascotThumbUp from "../assets/mascot-thumb-up.png";
import AppButton from "./ui/AppButton.vue";

const timer = ref({
    days: "00",
    hours: "00",
    minutes: "00",
    seconds: "00",
});

let countdownInterval;

const startCountdown = () => {
    const targetDate = new Date("October 25, 2026 08:00:00").getTime();

    countdownInterval = setInterval(() => {
        const now = new Date().getTime();
        const distance = targetDate - now;

        if (distance < 0) {
            clearInterval(countdownInterval);
            return;
        }

        const d = Math.floor(distance / (1000 * 60 * 60 * 24));
        const h = Math.floor(
            (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60),
        );
        const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const s = Math.floor((distance % (1000 * 60)) / 1000);

        timer.value = {
            days: d.toString().padStart(2, "0"),
            hours: h.toString().padStart(2, "0"),
            minutes: m.toString().padStart(2, "0"),
            seconds: s.toString().padStart(2, "0"),
        };
    }, 1000);
};

onMounted(() => {
    startCountdown();
});

onUnmounted(() => {
    if (countdownInterval) clearInterval(countdownInterval);
});
</script>