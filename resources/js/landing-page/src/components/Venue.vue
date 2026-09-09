<template>
  <Section id="venue" border-top variant="base">
    <SectionHeader
      number="02"
      label="Location & Venue"
      :description="subtitle"
      headline-class="font-montserrat text-4xl md:text-5xl lg:text-[3.5rem] font-black uppercase leading-[1.1] tracking-tight max-w-4xl"
      description-class="text-gray-300 text-base md:text-lg font-medium max-w-3xl leading-relaxed"
    >
      JDD 2026 LANDS IN <span class="text-jd-cyan">PASURUAN</span>
    </SectionHeader>

    <!-- VENUE CONTENT GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-stretch mt-4">
      <!-- LEFT COLUMN: Location Details & CTA -->
      <div
        class="lg:col-span-5 bg-[#0B1519] border border-gray-800 hover:border-jd-cyan/40 rounded-3xl p-6 sm:p-8 md:p-10 transition-all duration-300 shadow-2xl relative overflow-hidden flex flex-col justify-between reveal-left group"
      >
        <!-- Background Ambient Glow -->
        <div
          class="absolute -top-24 -left-24 w-72 h-72 bg-jd-cyan/10 rounded-full blur-3xl pointer-events-none"
        ></div>

        <!-- Corner Tech Brackets -->
        <div class="absolute top-6 right-6 w-3 h-3 border-t-2 border-r-2 border-jd-cyan/40"></div>
        <div class="absolute bottom-6 left-6 w-3 h-3 border-b-2 border-l-2 border-jd-cyan/40"></div>

        <div>
          <!-- Tag Badge -->
          <div
            class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-jd-cyan/10 border border-jd-cyan/30 text-jd-cyan text-[11px] font-bold tracking-widest uppercase mb-5"
          >
            <span class="w-2 h-2 rounded-full bg-jd-cyan animate-pulse"></span>
            <span>Official Venue</span>
          </div>

          <!-- Venue Title -->
          <h3
            class="text-2xl sm:text-3xl font-black text-white tracking-wide uppercase mb-3 font-montserrat"
          >
            {{ locationName }}
          </h3>

          <p class="text-gray-400 text-sm leading-relaxed mb-6 font-medium">
            Pusat perhelatan utama Jatim Developer Day 2026. Menghadirkan panggung konferensi, ruang workshop kolaboratif, dan ekosistem networking yang nyaman bagi para penggiat teknologi.
          </p>

          <!-- Address Box -->
          <div
            class="bg-[#031118]/80 border border-gray-800/90 rounded-2xl p-4 sm:p-5 mb-6 backdrop-blur-sm relative z-10"
          >
            <div class="flex items-start gap-3.5">
              <div
                class="w-10 h-10 rounded-xl bg-jd-cyan/10 border border-jd-cyan/30 flex items-center justify-center text-jd-cyan flex-shrink-0 mt-0.5"
              >
                <!-- Location Pin Icon -->
                <svg
                  class="w-5 h-5"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.8"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                  />
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.8"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                  />
                </svg>
              </div>

              <div>
                <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 block mb-1">
                  Alamat Lengkap
                </span>
                <p class="text-sm font-semibold text-gray-200 leading-snug">
                  {{ address }}
                </p>
              </div>
            </div>
          </div>

          <!-- Highlight Highlights -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 mb-8">
            <div
              class="flex items-center gap-2.5 p-2.5 rounded-xl bg-gray-900/50 border border-gray-800/80 text-xs text-gray-300 font-medium"
            >
              <span class="text-jd-cyan text-sm">🚆</span>
              <span>±5 Menit dari Stasiun Bangil</span>
            </div>
            <div
              class="flex items-center gap-2.5 p-2.5 rounded-xl bg-gray-900/50 border border-gray-800/80 text-xs text-gray-300 font-medium"
            >
              <span class="text-jd-cyan text-sm">🏛️</span>
              <span>Auditorium & Ruang Paralel</span>
            </div>
            <div
              class="flex items-center gap-2.5 p-2.5 rounded-xl bg-gray-900/50 border border-gray-800/80 text-xs text-gray-300 font-medium"
            >
              <span class="text-jd-cyan text-sm">🚗</span>
              <span>±10 Menit dari Exit Tol Bangil</span>
            </div>
            <div
              class="flex items-center gap-2.5 p-2.5 rounded-xl bg-gray-900/50 border border-gray-800/80 text-xs text-gray-300 font-medium"
            >
              <span class="text-jd-cyan text-sm">⚡</span>
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
            <svg
              class="w-4 h-4 text-black"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
              />
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
              />
            </svg>
            <span>Buka di Google Maps</span>
            <svg
              class="w-4 h-4 text-black"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
              />
            </svg>
          </AppButton>
        </div>
      </div>

      <!-- RIGHT COLUMN: Venue Photo Showcase -->
      <div
        class="lg:col-span-7 relative rounded-3xl overflow-hidden border border-gray-800 bg-[#071922] shadow-2xl group min-h-[380px] sm:min-h-[460px] md:min-h-[520px] flex flex-col justify-between p-6 sm:p-8 reveal-right"
      >
        <!-- Photo with Zoom & Grayscale hover -->
        <img
          :src="photoUrl"
          :alt="locationName"
          class="absolute inset-0 w-full h-full object-cover md:grayscale transition-all duration-700 group-hover:grayscale-0 group-hover:scale-105"
          loading="lazy"
        />

        <!-- Gradient Overlays for Readability & Seamless Theme Integration -->
        <div
          class="absolute inset-0 bg-gradient-to-t from-[#031118] via-[#031118]/40 to-transparent pointer-events-none"
        ></div>
        <div
          class="absolute inset-0 bg-gradient-to-b from-[#031118]/60 via-transparent to-transparent pointer-events-none"
        ></div>

        <!-- Tech Corner Accents -->
        <div class="absolute top-6 left-6 w-4 h-4 border-t-2 border-l-2 border-white/60 pointer-events-none z-10"></div>
        <div class="absolute top-6 right-6 w-4 h-4 border-t-2 border-r-2 border-white/60 pointer-events-none z-10"></div>
        <div class="absolute bottom-6 left-6 w-4 h-4 border-b-2 border-l-2 border-white/60 pointer-events-none z-10"></div>
        <div class="absolute bottom-6 right-6 w-4 h-4 border-b-2 border-r-2 border-white/60 pointer-events-none z-10"></div>

        <!-- Top Row Tags -->
        <div class="relative z-10 flex items-center justify-between">
          <span
            class="text-[11px] font-mono tracking-[0.2em] uppercase text-white/80 bg-black/40 backdrop-blur-md px-3.5 py-1.5 rounded-full border border-white/10"
          >
            [ HOST_LOCATION // 2026 ]
          </span>

          <div
            class="bg-black/50 backdrop-blur-md border border-white/20 px-3.5 py-1.5 rounded-full flex items-center gap-2"
          >
            <span class="w-2 h-2 rounded-full bg-jd-cyan"></span>
            <span class="text-white text-xs font-semibold tracking-wider uppercase">
              Pasuruan, ID
            </span>
          </div>
        </div>

        <!-- Bottom Glassmorphism Overlay Card -->
        <div
          class="relative z-10 bg-[#031118]/85 backdrop-blur-md border border-white/10 rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 mt-auto"
        >
          <div>
            <h4 class="text-white text-lg font-bold tracking-wide mb-0.5">
              {{ locationName }}
            </h4>
            <span class="text-xs text-gray-400 font-medium tracking-wide">
              Kec. Bangil, Kab. Pasuruan, Jawa Timur
            </span>
          </div>

          <a
            :href="mapsUrl"
            target="_blank"
            rel="noopener noreferrer"
            class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-jd-cyan hover:text-white transition-colors group/link self-start sm:self-auto"
          >
            <span>Petunjuk Arah</span>
            <svg
              class="w-3.5 h-3.5 transform group-hover/link:translate-x-0.5 group-hover/link:-translate-y-0.5 transition-transform"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
              />
            </svg>
          </a>
        </div>
      </div>
    </div>
  </Section>
</template>

<script setup lang="ts">
import Section from './ui/Section.vue'
import SectionHeader from './ui/SectionHeader.vue'
import AppButton from './ui/AppButton.vue'
import auditoriumImg from '../assets/auditorium-yadika.webp'

interface Props {
  title?: string
  subtitle?: string
  locationName?: string
  address?: string
  mapsUrl?: string
  photoUrl?: string
}

withDefaults(defineProps<Props>(), {
  title: 'JDD 2026 Lands in Pasuruan',
  subtitle:
    'Tahun ini, kita berkumpul di Pasuruan untuk berbagi insight, bertukar pengalaman, dan membuka koneksi baru di dunia teknologi.',
  locationName: 'ITB Yadika Pasuruan',
  address: 'Jl. Salem No.3, Kersikan, Kec. Bangil, Pasuruan, Jawa Timur 67153',
  mapsUrl: 'https://maps.app.goo.gl/CgoMiDGV3hHBSpwL7',
  photoUrl: auditoriumImg,
})
</script>
