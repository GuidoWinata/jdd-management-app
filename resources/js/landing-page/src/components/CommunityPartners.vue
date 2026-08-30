<template>
    <section
        id="partners"
        class="bg-jd-bg-deep py-12 border-t border-b border-gray-900 overflow-hidden"
    >
        <div class="container mx-auto px-6 mb-6">
            <h3
                class="text-center text-gray-500 text-xs font-bold tracking-[0.2em] uppercase"
            >
                Community Partners
            </h3>
        </div>

        <!-- Marquee Container dengan efek fade di ujung kiri dan kanan -->
        <div
            class="relative w-full overflow-hidden flex items-center"
            style="
                -webkit-mask-image: linear-gradient(
                    to right,
                    transparent,
                    black 10%,
                    black 90%,
                    transparent
                );
                mask-image: linear-gradient(
                    to right,
                    transparent,
                    black 10%,
                    black 90%,
                    transparent
                );
            "
        >
            <!-- Track Animasi: 2 set logo persis sama untuk infinite loop -->
            <div class="flex w-max animate-marquee pause-on-hover items-center">
                <div
                    v-for="set in 1"
                    :key="set"
                    class="flex items-center gap-8 md:gap-10 px-8 md:px-12"
                >
                    <div
                        v-for="(partner, index) in communityLogos"
                        :key="`${set}-${index}`"
                        class=" shrink-0 w-24 h-16 md:w-32 md:h-20 flex items-center justify-center opacity-70 hover:opacity-100 transition-opacity duration-300 grayscale hover:grayscale-0 cursor-pointer"
                    >
                        <img
                            :src="partner.src"
                            :alt="partner.name"
                            class="max-h-full object-contain"
                            loading="lazy"
                        />
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import bangkalanDev from "../assets/Logo Komunitas/Fix Join/BangkalanDev.png";
import pasuruanDev from "../assets/Logo Komunitas/Fix Join/PasuruanDev.png";
import sidoarjoDev from "../assets/Logo Komunitas/Fix Join/SidoarjoDev.png";
import gresikDev from "../assets/Logo Komunitas/Fix Join/GresikDev.png";
import jemberDev from "../assets/Logo Komunitas/JemberDev.jpeg";
import ngawiDev from "../assets/Logo Komunitas/NgawiDev.jpg";
import banyuwangiDev from "../assets/Logo Komunitas/BanyuwangiDev.jpg";
import mojokertoDev from "../assets/Logo Komunitas/Fix Join/MojokertoDev.png";
import lamonganDev from "../assets/Logo Komunitas/Fix Join/LamonganDev.png";
import probolinggoDev from "../assets/Logo Komunitas/Fix Join/Probolinggodev.png";
import pacitanDev from "../assets/Logo Komunitas/Fix Join/PacitanDev.png";
import jombangDev from "../assets/Logo Komunitas/Fix Join/JombangDev.png";
import maduraDev from "../assets/Logo Komunitas/Fix Join/MADURADEV.png";
import surabayaDev from "../assets/Logo Komunitas/Fix Join/SurabayaDev.png";
import surabayaJs from "../assets/Logo Komunitas/Fix Join/Surabaya JS.png";
import surabayaPy from "../assets/Logo Komunitas/Fix Join/Surabaya Py.png";
import gdgSurabaya from "../assets/Logo Komunitas/Fix Join/GDG Surabaya.png";
import dsi from "../assets/Logo Komunitas/Fix Join/Data Science Indonesia.png";
import klas from "../assets/Logo Komunitas/Fix Join/KLAS (Kelompok Linux Arek Suroboyo) - NEW.png";
import androidDev from "../assets/Logo Komunitas/Fix Join/AndroidDev Surabaya.png";
import isqa from "../assets/Logo Komunitas/Fix Join/ISQA Surabaya.png";
import gatherloop from "../assets/Logo Komunitas/gatherloop-logo-dark.svg";

const communityLogos = [
    { name: "BangkalanDev", src: bangkalanDev },
    { name: "PasuruanDev", src: pasuruanDev },
    { name: "SidoarjoDev", src: sidoarjoDev },
    { name: "GresikDev", src: gresikDev },
    { name: "JemberDev", src: jemberDev },
    { name: "NgawiDev", src: ngawiDev },
    { name: "BanyuwangiDev", src: banyuwangiDev },
    { name: "MojokertoDev", src: mojokertoDev },
    { name: "LamonganDev", src: lamonganDev },
    { name: "ProbolinggoDev", src: probolinggoDev },
    { name: "PacitanDev", src: pacitanDev },
    { name: "JombangDev", src: jombangDev },
    { name: "MaduraDev", src: maduraDev },
    { name: "SurabayaDev", src: surabayaDev },
    { name: "Surabaya JS", src: surabayaJs },
    { name: "Surabaya Py", src: surabayaPy },
    { name: "GDG Surabaya", src: gdgSurabaya },
    { name: "Data Science Indonesia", src: dsi },
    { name: "KLAS", src: klas },
    { name: "AndroidDev Surabaya", src: androidDev },
    { name: "ISQA Surabaya", src: isqa },
    { name: "Gatherloop", src: gatherloop },
];
</script>

<style scoped>
/*
  Translasi dari 0 ke -50% bekerja karena kita merender persis 2 set logo
  dalam satu flex container. Saat set pertama bergeser penuh ke kiri, set
  kedua berada persis di posisi awal set pertama -> ilusi loop tanpa batas.
*/
.animate-marquee {
    animation: marquee 30s linear infinite;
}

@keyframes marquee {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}

.pause-on-hover:hover {
    animation-play-state: paused;
}
</style>
