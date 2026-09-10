<template>
  <header class="w-full py-16 md:py-24 px-6 bg-[#020b10] relative overflow-hidden font-sans">
    
    <!-- Latar Belakang Grid Pattern -->
    <div class="absolute inset-0 grid-pattern pointer-events-none"></div>

    <div class="container mx-auto max-w-6xl relative z-10">
      
      <!-- Headline Utama -->
      <h1 class="font-montserrat text-5xl md:text-7xl lg:text-[5.5rem] font-black uppercase tracking-tight leading-[1.1] mb-6">
        <!-- Teks Solid (Baris Pertama) -->
        <span class="block text-[#e0f0f1]">{{ titleSolid }}</span>
        <!-- Teks Outline (Baris Kedua) -->
        <span class="block text-jd-cyan">{{ titleOutline }}</span>
      </h1>

      <!-- Subtitle -->
      <p class="text-[#8ebdbd] text-base md:text-lg font-medium max-w-2xl">
        {{ subtitle }}
      </p>

    </div>
  </header>
</template>

<script setup>
import { defineProps } from 'vue';

defineProps({
  titleSolid: {
    type: String,
    default: 'KEBIJAKAN PENGEMBALIAN'
  },
  titleOutline: {
    type: String,
    default: 'DANA'
  },
  subtitle: {
    type: String,
    default: 'Harap baca kebijakan pengembalian dana dengan teliti sebelum melakukan pembelian tiket.'
  }
});
</script>

<style scoped>
.grid-pattern {
  background-size: 80px 80px;
  background-image:
    linear-gradient(to right, rgba(24, 188, 188, 0.05) 1px, transparent 1px),
    linear-gradient(to bottom, rgba(24, 188, 188, 0.05) 1px, transparent 1px);
}

.text-stroke-cyan {
  -webkit-text-stroke: 2px #18BCBC;
}

@media (max-width: 768px) {
  .text-stroke-cyan {
    -webkit-text-stroke: 1.5px #18BCBC;
  }
}
</style>
