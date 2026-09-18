<template>
    <Section id="about" class="relative" variant="white">
        <SectionHeader
            number="01"
            label="The Vision"
            headline-class="text-3xl sm:text-5xl md:text-6xl font-semibold leading-[1.1] max-w-5xl mx-auto"
            description-class="text-gray-600 text-sm md:text-base max-w-3xl mx-auto mb-6 sm:mb-12 mt-5 leading-relaxed"
            description="Jatim Developer Day (JDD) 2026 bukan sekadar konferensi teknologi. Ini adalah ruang perjumpaan para inovator untuk merancang standar baru dalam arsitektur perangkat lunak, cloud scaling, dan kecerdasan buatan."
            class="relative z-30 text-center"
        >
            Menghidupkan Ekosistem
            <br class="hidden md:block" />
            Developer Jawa Timur.
        </SectionHeader>

        <!-- IMAGE COLLAGE SECTION -->
        <div
            class="relative mx-auto h-[280px] sm:h-[400px] md:h-[500px] lg:h-[550px] mt-2 sm:mt-16 md:mt-24"
        >
            <!-- TOP LEFT IMAGE (Mengapit teks di kiri) -->
            <div
                class="absolute -left-16 -top-32 md:-top-48 lg:-top-56 w-28 sm:w-40 md:w-48 lg:w-56 aspect-[3/4] z-0 hidden sm:block reveal-left group hover:z-40"
                style="transition-delay: 0.1s"
            >
                <div
                    class="w-full h-full bg-gray-900 rounded-2xl md:rounded-3xl overflow-hidden shadow-xl"
                >
                    <img
                        :src="img1"
                        alt="Kiri Atas"
                        loading="lazy"
                        class="w-full h-full object-cover hover-colorize"
                    />
                </div>
            </div>

            <!-- TOP RIGHT IMAGE (Mengapit teks di kanan) -->
            <div
                class="absolute -right-16 -top-40 md:-top-56 lg:-top-64 w-28 sm:w-40 md:w-48 lg:w-56 aspect-[3/4] z-0 hidden sm:block reveal-right group hover:z-40"
                style="transition-delay: 0.1s"
            >
                <div
                    class="w-full h-full bg-gray-900 rounded-2xl md:rounded-3xl overflow-hidden shadow-xl"
                >
                    <img
                        :src="img3"
                        alt="Kanan Atas"
                        loading="lazy"
                        class="w-full h-full object-cover object-top hover-colorize"
                    />
                </div>
            </div>

            <!-- CENTER MAIN IMAGE (Video Player Thumbnail) -->
            <!-- Posisinya persis di tengah bawah container -->
            <div
                class="absolute left-1/2 -translate-x-1/2 bottom-0 w-[90%] md:w-[75%] lg:w-[65%] h-full max-h-[250px] sm:max-h-[350px] md:max-h-[450px] lg:max-h-[500px] z-10 reveal-scale group"
            >
                <div
                    class="w-full h-full rounded-2xl md:rounded-3xl overflow-hidden relative shadow-2xl group"
                >
                    <img
                        :src="img5"
                        alt="Gambar Utama / Video"
                        loading="lazy"
                        class="w-full h-full object-cover hover-colorize"
                    />
                </div>
            </div>

            <!-- BOTTOM LEFT IMAGE (Menumpuk di ujung kiri bawah gambar utama) -->
            <div
                class="absolute left-4 sm:left-10 md:left-16 lg:left-0 bottom-[-10%] sm:bottom-[-5%] md:bottom-[-10%] w-32 sm:w-48 md:w-64 lg:w-72 aspect-video z-20 hidden sm:block reveal-left group hover:z-40"
                style="transition-delay: 0.2s"
            >
                <!-- Penambahan border agar terlihat terpisah dari gambar di belakangnya -->
                <div
                    class="w-full h-full bg-gray-900 rounded-xl md:rounded-2xl overflow-hidden shadow-2xl"
                >
                    <img
                        :src="img2"
                        alt="Kiri Bawah"
                        loading="lazy"
                        class="w-full h-full object-cover hover-colorize"
                    />
                </div>
            </div>

            <!-- MIDDLE RIGHT IMAGE (Menumpuk di sisi kanan atas gambar utama) -->
            <div
                class="absolute right-4 sm:right-8 md:right-12 lg:-right-8 top-[10%] sm:top-[20%] md:top-[25%] w-32 sm:w-48 md:w-60 lg:w-64 aspect-video z-20 hidden sm:block reveal-right group hover:z-40"
                style="transition-delay: 0.2s"
            >
                <div
                    class="w-full h-full rounded-xl md:rounded-2xl overflow-hidden shadow-2xl"
                >
                    <img
                        :src="img4"
                        alt="Kanan Tengah"
                        loading="lazy"
                        class="w-full h-full object-cover hover-colorize"
                    />
                </div>
            </div>
        </div>
    </Section>
</template>

<script setup>
import Section from "./ui/Section.vue";
import SectionHeader from "./ui/SectionHeader.vue";
import img1 from "../assets/img-1.webp";
import img2 from "../assets/img-2.webp";
import img3 from "../assets/img-3.webp";
import img4 from "../assets/img-4.webp";
import img5 from "../assets/img-5.webp";
</script>
