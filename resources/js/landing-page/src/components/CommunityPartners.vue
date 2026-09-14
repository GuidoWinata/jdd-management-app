<template>
    <Section id="partners" variant="white" container="w-full">
        <div class="container mx-auto">
            <h2
                class="text-center text-gray-500 text-xs md:text-sm font-semibold tracking-[0.2em] uppercase mb-10 md:mb-16"
            >
                Community Partners
            </h2>

            <div
                class="flex flex-wrap justify-center gap-4 md:gap-6 items-center"   
            >
                <div
                    v-for="(partner, index) in communityLogos"
                    :key="index"
                    class="h-12 md:h-16 lg:h-24 w-24 md:w-32 lg:w-48 flex items-center justify-center hover:scale-105 transition-transform duration-300"
                >
                    <img
                        :src="partner.src"
                        :alt="partner.name"
                        class="max-h-full object-contain filter grayscale hover:grayscale-0 transition-all duration-300"
                        loading="lazy"
                    />
                </div>
            </div>
        </div>
    </Section>
</template>

<script setup>
import Section from './ui/Section.vue'
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
