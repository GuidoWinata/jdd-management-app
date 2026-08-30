<template>
  <section
    id="home"
    class="relative bg-jd-bg text-white min-h-screen pt-32 pb-20 px-6 font-sans flex items-center overflow-hidden lg:pt-20"
  >
    <!-- Background Image -->
    <div
      class="absolute inset-0 bg-cover bg-center opacity-40"
      :style="{ backgroundImage: `url(${heroImg})` }"
    ></div>

    <div class="container mx-auto relative">
      <div class="flex flex-col lg:flex-row justify-between items-end">
        <!-- KIRI: Teks & Tombol -->
        <div class="w-full lg:w-3/5 z-10">
          <!-- Top Badge -->
          <div class="inline-flex items-center px-5 py-2 rounded-full bg-[#031c22] border border-jd-cyan/20 mb-8 reveal">
            <span class="w-2 h-2 rounded-full bg-jd-cyan mr-3"></span>
            <span class="text-jd-cyan text-xs font-bold tracking-[0.15em] uppercase">
              {{ badgeText }}
            </span>
          </div>

          <!-- Main Headline -->
          <h1
            class="font-montserrat text-5xl md:text-[5rem] lg:text-[5.5rem] font-black leading-[1.05] tracking-tight uppercase mb-8 reveal"
            style="transition-delay: 0.1s"
          >
            <span class="text-[#f0f6f9]">{{ titleLine1 }}</span>
            <br />
            <span class="text-[#f0f6f9]">{{ titleLine2 }}</span>
            <span class="text-jd-cyan">{{ titleAccent }}</span>
          </h1>

          <!-- Description -->
          <p
            class="text-gray-300 text-lg md:text-xl leading-relaxed max-w-2xl mb-12 font-medium reveal-right"
            style="transition-delay: 0.2s"
          >
            {{ description }}
          </p>

          <!-- Action Buttons -->
          <div class="flex flex-wrap items-center gap-6 reveal" style="transition-delay: 0.3s">
            <AppButton :glow="true" :href="primaryHref">
              {{ primaryLabel }}
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 19L20 5m0 0H9m11 0v11"></path>
              </svg>
            </AppButton>

            <AppButton variant="outline" :href="secondaryHref">
              {{ secondaryLabel }}
              <span class="text-lg leading-none">→</span>
            </AppButton>
          </div>
        </div>

        <!-- KANAN: Mascot & Countdown -->
        <div class="w-full lg:w-2/5 flex flex-col items-end relative z-10">
          <div class="relative w-[350px] h-[350px] mb-[-19px] z-20 flex justify-end mr-8 reveal-scale" style="transition-delay: 0.3s">
            <img
              :src="mascotImg"
              alt="Mascot"
              class="w-full h-full object-contain drop-shadow-[0_0_30px_rgba(24,188,188,0.35)]"
            />
          </div>

          <!-- Countdown Card -->
          <div
            class="w-full bg-gradient-to-br from-[#09222c] to-[#051116] border-4 border-jd-cyan/30 rounded-2xl p-8 lg:p-10 shadow-[0_0_40px_rgba(24,188,188,0.1)] relative z-10 reveal"
            style="transition-delay: 0.4s"
          >
            <p class="text-gray-300 text-center text-xs tracking-[0.2em] uppercase font-semibold mb-8">
              Counting down to launch
            </p>

            <div class="flex justify-between items-center px-2">
              <template v-for="(item, index) in countdown" :key="index">
                <div class="flex flex-col items-center flex-1">
                  <span class="text-5xl md:text-6xl font-light text-[#f0f6f9] tracking-tight">
                    {{ item.value }}
                  </span>
                  <span class="text-gray-500 text-[10px] md:text-xs tracking-[0.2em] uppercase mt-3 font-semibold">
                    {{ item.label }}
                  </span>
                </div>

                <div v-if="index < countdown.length - 1" class="text-jd-cyan text-3xl font-light pb-6 px-1 md:px-3">
                  :
                </div>
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import AppButton from './ui/AppButton.vue'
import heroImg from '../assets/hero-img.png'
import mascotImg from '../assets/mascot-double.png'

const props = defineProps({
  badgeText: {
    type: String,
    default: 'East Java Premier Tech Gathering · Oct 25, 2026',
  },
  titleLine1: { type: String, default: 'Jatim Tech Hub' },
  titleLine2: { type: String, default: 'Inclusive Tech ' },
  titleAccent: { type: String, default: 'Real Impact' },
  description: {
    type: String,
    default:
      'Konferensi eksklusif bagi para arsitek teknologi, developer, dan pemimpin industri Jawa Timur. Membangun masa depan digital dengan standar keunggulan kelas dunia.',
  },
  primaryLabel: { type: String, default: 'DAPATKAN TIKET' },
  primaryHref: { type: String, default: '#tickets' },
  secondaryLabel: { type: String, default: 'JADI MEDIA PARTNER' },
  secondaryHref: {
    type: String,
    default: import.meta.env.VITE_MEDIA_PARTNER_FORM_URL || '#',
  },
})

const eventDate = new Date(import.meta.env.VITE_EVENT_DATE).getTime()
const now = ref(Date.now())
let timer = null

const countdown = computed(() => {
  const diff = Math.max(0, eventDate - now.value)
  const days = Math.floor(diff / (1000 * 60 * 60 * 24))
  const hours = Math.floor((diff / (1000 * 60 * 60)) % 24)
  const mins = Math.floor((diff / (1000 * 60)) % 60)
  const secs = Math.floor((diff / 1000) % 60)
  return [
    { value: String(days).padStart(2, '0'), label: 'Days' },
    { value: String(hours).padStart(2, '0'), label: 'Hours' },
    { value: String(mins).padStart(2, '0'), label: 'Mins' },
    { value: String(secs).padStart(2, '0'), label: 'Secs' },
  ]
})

onMounted(() => {
  timer = setInterval(() => {
    now.value = Date.now()
  }, 1000)
})

onUnmounted(() => {
  clearInterval(timer)
})
</script>