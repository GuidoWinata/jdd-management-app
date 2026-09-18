<template>
    <div
        class="relative w-full h-full flex items-center justify-center overflow-hidden"
    >
        <!-- Tekstur Stardust -->
        <div
            class="absolute inset-0 opacity-10 bg-[url('@/assets/stardust.png')]"
        ></div>

        <!-- Konten Timer -->
        <div class="relative z-10">
            <h3
                class="text-white text-[10px] sm:text-[10px] md:text-sm font-semibold tracking-[0.3em] uppercase mb-6 sm:mb-8"
            >
                Counting Down To Launch
            </h3>

            <!-- Timer Grid -->
            <div class="flex items-center justify-center gap-2 sm:gap-4 md:gap-5">
                <!-- Days -->
                <div class="flex flex-col items-center w-14 sm:w-16 md:w-24">
                    <span
                        class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-light text-white mb-1 sm:mb-2 tracking-tight"
                        >{{ timer.days }}</span
                    >
                    <span
                        class="text-jd-cyan text-[10px] sm:text-xs md:text-sm font-semibold tracking-widest uppercase"
                        >Days</span
                    >
                </div>

                <span
                    class="text-xl sm:text-2xl md:text-4xl font-light text-gray-500/50 mb-6"
                    >:</span
                >

                <!-- Hours -->
                <div class="flex flex-col items-center w-14 sm:w-16 md:w-24">
                    <span
                        class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-light text-white mb-1 sm:mb-2 tracking-tight"
                        >{{ timer.hours }}</span
                    >
                    <span
                        class="text-jd-cyan text-[10px] sm:text-xs md:text-sm font-semibold tracking-widest uppercase"
                        >Hours</span
                    >
                </div>

                <span
                    class="text-xl sm:text-2xl md:text-4xl font-light text-gray-500/50 mb-6"
                    >:</span
                >

                <!-- Minutes -->
                <div class="flex flex-col items-center w-14 sm:w-16 md:w-24">
                    <span
                        class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-light text-white mb-1 sm:mb-2 tracking-tight"
                        >{{ timer.minutes }}</span
                    >
                    <span
                        class="text-jd-cyan text-[10px] sm:text-xs md:text-sm font-semibold tracking-widest uppercase"
                        >Mins</span
                    >
                </div>

                <span
                    class="text-xl sm:text-2xl md:text-4xl font-light text-gray-500/50 mb-6"
                    >:</span
                >

                <!-- Seconds -->
                <div class="flex flex-col items-center w-14 sm:w-16 md:w-24">
                    <span
                        class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-light text-white mb-1 sm:mb-2 tracking-tight"
                        >{{ timer.seconds }}</span
                    >
                    <span
                        class="text-jd-cyan text-[10px] sm:text-xs md:text-sm font-semibold tracking-widest uppercase"
                        >Secs</span
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue";

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
