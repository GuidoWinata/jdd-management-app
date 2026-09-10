<template>
  <Section id="sponsorship">
    <SectionHeader number="07" label="Partners & Sponsors">
      BECOME OUR <span class="text-jd-cyan">SPONSOR</span>
    </SectionHeader>

    <div class="flex justify-center reveal-scale">
      <a
        href="https://s.id/sponsorshipjdd2026"
        target="_blank"
        rel="noopener noreferrer"
        class="inline-flex items-center gap-3 bg-jd-cyan hover:bg-jd-cyan-dark text-[#050e12] font-bold text-sm tracking-[0.15em] uppercase px-10 py-4 rounded-full transition-colors duration-300 shadow-[0_0_30px_rgba(24,188,188,0.25)]"
      >
        <PhPlus :size="20" :weight="'bold'" />
        BECOME OUR SPONSOR
      </a>
    </div>
  </Section>
</template>

<script setup>
import Section from './ui/Section.vue'
import SectionHeader from './ui/SectionHeader.vue'
import { PhPlus } from '@phosphor-icons/vue'
</script>