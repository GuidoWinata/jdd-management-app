<template>
  <Section id="about">
    <SectionHeader
      number="01"
      label="The Vision"
      headline-class="font-montserrat text-4xl md:text-5xl lg:text-[3.5rem] font-black uppercase leading-[1.1] tracking-tight max-w-4xl"
      description-class="text-gray-300 text-base md:text-lg font-medium max-w-4xl leading-relaxed"
      description="Jatim Developer Day (JDD) 2026 bukan sekadar konferensi teknologi. Ini adalah ruang perjumpaan para inovator untuk merancang standar baru dalam arsitektur perangkat lunak, kecerdasan buatan, hingga pengembangan karir."
      class="relative z-30"
    >
      MENGHIDUPKAN EKOSISTEM
      <br class="hidden md:block" />
      DEVELOPER <span class="text-jd-cyan">JAWA TIMUR.</span>
    </SectionHeader>

    <!-- IMAGE COLLAGE SECTION -->
    <div class="relative w-full max-w-5xl mx-auto h-[350px] md:h-[500px] lg:h-[600px] mt-10">
      <!-- CENTER MAIN IMAGE (Video Player Thumbnail) -->
      <div class="absolute inset-0 md:inset-x-16 md:inset-y-8 lg:inset-x-32 lg:inset-y-0 z-10 reveal-scale group">
        <div class="w-full h-full rounded-3xl overflow-hidden relative border border-gray-800 shadow-2xl group cursor-pointer">
          <img :src="img5" alt="Gambar Utama / Video" class="w-full h-full object-cover grayscale transition-all duration-500 group-hover:grayscale-0 group-hover:scale-110" />

          <!-- <div class="absolute inset-0 flex items-center justify-center bg-black/30">
            <div class="w-16 h-16 md:w-20 md:h-20 bg-white rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
              <svg class="w-8 h-8 md:w-10 md:h-10 text-black ml-1 md:ml-2" fill="currentColor" viewBox="0 0 24 24">
                <path d="M8 5v14l11-7z"/>
              </svg>
            </div>
          </div> -->
        </div>
      </div>

      <!-- TOP LEFT IMAGE -->
      <div class="absolute -left-4 md:-left-8 top-0 md:-top-4 w-48 md:w-80 lg:w-96 h-32 md:h-52 lg:h-60 z-0 hidden sm:block reveal-left group hover:z-30" style="transition-delay: 0.1s">
        <div class="w-full h-full bg-gray-900 rounded-3xl border border-gray-700 overflow-hidden shadow-xl">
          <img :src="img1" alt="Kiri Atas" class="w-full h-full object-cover grayscale transition-all duration-500 group-hover:grayscale-0 group-hover:scale-110" />
        </div>
      </div>

      <!-- BOTTOM LEFT IMAGE -->
      <div class="absolute left-0 md:-left-12 lg:-left-20 bottom-4 md:-bottom-8 lg:bottom-4 w-40 md:w-72 lg:w-80 h-28 md:h-44 lg:h-52 z-20 hidden sm:block reveal-left group hover:z-30" style="transition-delay: 0.2s">
        <div class="w-full h-full bg-gray-900 rounded-2xl md:rounded-3xl border border-gray-600 overflow-hidden shadow-2xl">
          <img :src="img2" alt="Kiri Bawah" class="w-full h-full object-cover grayscale transition-all duration-500 group-hover:grayscale-0 group-hover:scale-110" />
        </div>
      </div>

      <!-- TOP RIGHT IMAGE -->
      <div class="absolute -right-4 md:-right-8 top-8 md:top-4 lg:-top-12 w-52 md:w-80 lg:w-96 h-28 md:h-48 lg:h-56 z-0 hidden sm:block reveal-right group hover:z-30" style="transition-delay: 0.1s">
        <div class="w-full h-full bg-gray-900 rounded-3xl border border-gray-700 overflow-hidden shadow-xl">
          <img :src="img3" alt="Kanan Atas" class="w-full h-full object-cover grayscale transition-all duration-500 group-hover:grayscale-0 group-hover:scale-110" />
        </div>
      </div>

      <!-- BOTTOM RIGHT IMAGE -->
      <div class="absolute right-0 md:-right-10 lg:-right-16 bottom-12 md:bottom-4 lg:bottom-12 w-44 md:w-72 lg:w-80 h-24 md:h-40 lg:h-48 z-20 hidden sm:block reveal-right group hover:z-30" style="transition-delay: 0.2s">
        <div class="w-full h-full bg-gray-900 rounded-2xl md:rounded-3xl border border-gray-600 overflow-hidden shadow-2xl transform translate-y-4">
          <img :src="img4" alt="Kanan Bawah" class="w-full h-full object-cover grayscale transition-all duration-500 group-hover:grayscale-0 group-hover:scale-110" />
        </div>
      </div>
    </div>
  </Section>
</template>

<script setup>
import Section from './ui/Section.vue'
import SectionHeader from './ui/SectionHeader.vue'
import img1 from '../assets/img-1.webp'
import img2 from '../assets/img-2.webp'
import img3 from '../assets/img-3.webp'
import img4 from '../assets/img-4.webp'
import img5 from '../assets/img-5.webp'
</script>