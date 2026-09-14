<template>
  <Section id="gallery" variant="white">

    <!-- GALLERY GRID (Edge-to-edge on large screens) -->
    <template #full>
      <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-1 lg:auto-rows-[300px]">
        <div
          v-for="(item, index) in galleryItems"
          :key="item.id"
          :class="[
            'relative w-full h-full overflow-hidden group reveal-scale',
            item.gridClass,
          ]"
          :style="{ transitionDelay: `${(index % 4) * 0.08}s` }"
        >
          <div class="w-full h-full min-h-[250px] overflow-hidden">
            <img
              :src="item.image"
              :alt="item.label"
              class="w-full h-full object-cover hover-colorize"
            />
          </div>

          <div class="absolute inset-0 bg-jd-cyan/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
        </div>
      </div>
    </template>
  </Section>
</template>

<script setup>
import Section from './ui/Section.vue'
import { galleryItems } from '../data/content'
</script>