<template>
  <!-- Container dengan border atas-bawah dan background terang -->
  <div class="w-full overflow-hidden border-t-[3px] border-b-[3px] border-[#0c2f3c] py-4 flex items-center select-none">
    <!-- Track Animasi: durasi dikontrol props 'speed' -->
    <div class="flex w-max animate-text-marquee items-center" :style="{ animationDuration: speed }">
      <!-- Render 2 set text untuk infinite loop tanpa putus -->
      <div v-for="set in 2" :key="set" class="flex items-center">
        <div v-for="(item, index) in items" :key="`${set}-${index}`" class="flex items-center">
          <span class="text-[#629d9e] font-bold text-sm md:text-base tracking-[0.2em] uppercase whitespace-nowrap px-6 md:px-10">
            {{ item }}
          </span>

          <!-- Pemisah: Ikon Belah Ketupat -->
          <div class="w-2.5 h-2.5 bg-jd-cyan transform rotate-45 flex-shrink-0"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  items: {
    type: Array,
    default: () => [
      'JDD 2026',
      '25 OCTOBER · PASURUAN',
      'EAST JAVA DEVELOPER DAY',
      '1,000+ DEVELOPERS',
      '20+ SPEAKERS',
      'EXCLUSIVE CONFERENCE',
    ],
  },
  speed: {
    type: String,
    default: '25s',
  },
})
</script>

<style scoped>
/* Loop dari 0 ke -50% karena kita me-render persis 2 set data. */
.animate-text-marquee {
  animation: text-marquee linear infinite;
}

@keyframes text-marquee {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(-50%);
  }
}
</style>