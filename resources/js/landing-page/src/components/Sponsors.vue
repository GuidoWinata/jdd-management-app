<template>
  <div class="relative w-full overflow-hidden">
    <DotCanvas class="absolute inset-0" />
    <Section id="sponsorship" class="relative z-10 pointer-events-none !bg-transparent" size="lg" border-top container="max-w-7xl">
      <div class="flex flex-col items-center text-center">
        <SectionHeader
      number="06"
      label="Partners & Sponsors"
      headline-class="text-5xl md:text-6xl font-semibold leading-[1.1] max-w-5xl mx-auto"
    >
      Become Our Sponsors
    </SectionHeader>

        <div class="flex justify-center reveal-scale pointer-events-auto">
          <a
            :href="URLS.SPONSORSHIP"
            target="_blank"
            rel="noopener noreferrer"
            class="inline-flex items-center gap-3 bg-jd-cyan hover:bg-jd-cyan-dark text-jd-on-cyan font-bold text-sm tracking-[0.15em] uppercase px-10 py-4 rounded-full transition-colors duration-300 shadow-[0_0_30px_rgba(207,221,17,0.25)]"
          >
            <PhPlus :size="20" :weight="'bold'" />
            BECOME OUR SPONSOR
          </a>
        </div>
      </div>
    </Section>
  </div>
</template>

<script setup>
import Section from './ui/Section.vue'
import SectionHeader from './ui/SectionHeader.vue'
import DotCanvas from './ui/DotCanvas.vue'
import { PhPlus } from '@phosphor-icons/vue'
import { URLS } from '../constants'
</script>