<template>
  <section id="partners" class="bg-jd-bg-deep py-12 border-t border-b border-gray-900 overflow-hidden">
    <div class="container mx-auto px-6 mb-6">
      <h3 class="text-center text-gray-500 text-xs font-bold tracking-[0.2em] uppercase">
        Community Partners
      </h3>
    </div>

    <!-- Marquee Container dengan efek fade di ujung kiri dan kanan -->
    <div
      class="relative w-full overflow-hidden flex items-center"
      style="-webkit-mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent); mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);"
    >
      <!-- Track Animasi: 2 set logo persis sama untuk infinite loop -->
      <div class="flex w-max animate-marquee pause-on-hover items-center">
        <div v-for="set in 2" :key="set" class="flex items-center gap-16 md:gap-24 px-8 md:px-12">
          <div
            v-for="(partner, index) in communityPartners"
            :key="`${set}-${index}`"
            class="flex-shrink-0 flex items-center justify-center opacity-50 hover:opacity-100 transition-opacity duration-300 grayscale hover:grayscale-0 cursor-pointer"
          >
            <div v-if="partner.type === 'text-icon'" class="flex items-center gap-3 text-white">
              <div class="text-3xl font-light tracking-tighter text-gray-400">&lt;bd&gt;</div>
              <div class="flex flex-col leading-none">
                <span class="text-lg font-medium text-gray-400">{{ partner.nameLine1 }}</span>
                <span class="text-xl font-black">{{ partner.nameLine2 }}</span>
              </div>
            </div>

            <div v-else-if="partner.type === 'lion'" class="flex items-center gap-3 text-white">
              <svg class="w-12 h-12 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2L9 7l-5-2 2 5-4 3 5 1 1 5 4-3 4 3 1-5 5-1-4-3 2-5-5 2-3-5zm0 9c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
              </svg>
              <div class="flex flex-col leading-none">
                <span class="text-2xl font-black tracking-widest">{{ partner.nameLine1 }}</span>
                <span class="text-[10px] font-bold tracking-widest text-gray-400 mt-1">{{ partner.nameLine2 }}</span>
              </div>
            </div>

            <div v-else-if="partner.type === 'hexagon'" class="flex flex-col items-center gap-1 text-white">
              <div class="relative w-10 h-10 border-2 border-gray-400 flex items-center justify-center rotate-45">
                <span class="text-[10px] font-bold text-gray-400 -rotate-45">&lt;/&gt;</span>
              </div>
              <span class="text-sm font-bold text-gray-400 mt-2">{{ partner.nameLine1 }}</span>
            </div>

            <div v-else-if="partner.type === 'brackets'" class="flex flex-col items-center gap-1 text-white">
              <div class="text-4xl font-black text-gray-400">&lt; / &gt;</div>
              <span class="text-xs font-bold tracking-widest text-gray-400 uppercase mt-1">{{ partner.nameLine1 }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { communityPartners } from '../data/content'
</script>

<style scoped>
/*
  Translasi dari 0 ke -50% bekerja karena kita merender persis 2 set logo
  dalam satu flex container. Saat set pertama bergeser penuh ke kiri, set
  kedua berada persis di posisi awal set pertama -> ilusi loop tanpa batas.
*/
.animate-marquee {
  animation: marquee 25s linear infinite;
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