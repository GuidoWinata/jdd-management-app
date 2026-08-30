<template>
  <Section id="gallery">
    <SectionHeader
      number="05"
      label="Gallery"
      description="Momen-momen terbaik dari perjalanan Jatim Developer Day di tahun-tahun sebelumnya."
    >
      PREVIOUS <span class="text-jd-cyan">MOMENTS</span>
    </SectionHeader>

    <!-- GALLERY GRID (Edge-to-edge on large screens) -->
    <template #full>
      <div class="w-full bg-black grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-1 lg:auto-rows-[300px]">
        <div
          v-for="(item, index) in galleryItems"
          :key="item.id"
          :class="[
            'relative w-full h-full overflow-hidden group reveal-scale',
            item.gridClass,
          ]"
          :style="{ transitionDelay: `${(index % 4) * 0.08}s` }"
        >
          <div class="w-full h-full min-h-[250px] flex flex-col items-center justify-center border border-gray-800 bg-gray-900 transition-all duration-500 grayscale group-hover:grayscale-0">
            <svg class="w-10 h-10 text-gray-700 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>

            <span class="text-gray-500 text-xs tracking-widest font-bold uppercase">
              {{ item.label }}
            </span>
            <span class="text-gray-700 text-[10px] mt-1">
              {{ item.resolutionHint }}
            </span>
          </div>

          <div class="absolute inset-0 bg-jd-cyan/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
        </div>
      </div>
    </template>
  </Section>
</template>

<script setup>
import Section from './ui/Section.vue'
import SectionHeader from './ui/SectionHeader.vue'
import { galleryItems } from '../data/content'
</script>