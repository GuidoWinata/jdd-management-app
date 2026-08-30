<template>
  <Section id="sponsorship">
    <SectionHeader number="06" label="Partners & Sponsors">
      PARTNERED WITH <span class="text-jd-cyan">LEADERS</span> IN INNOVATION
    </SectionHeader>

    <!-- GOLD SPONSORS -->
    <div class="mb-14 reveal">
      <h3 class="text-[#FFD700] text-xs font-bold tracking-widest uppercase mb-6">
        Gold Sponsors
      </h3>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div
          v-for="(sponsor, index) in sponsors.gold"
          :key="sponsor.id"
          class="h-32 bg-[#050e12] border border-gray-800 border-b-2 border-b-[#FFD700] rounded-xl flex items-center justify-center transition-transform duration-300 hover:-translate-y-1 cursor-pointer group reveal-scale"
          :style="{ transitionDelay: `${(index % 3) * 0.1}s` }"
        >
          <span class="text-gray-600 text-xs font-bold uppercase tracking-widest group-hover:text-gray-400 transition-colors">
            {{ sponsor.name }}
          </span>
        </div>
      </div>
    </div>

    <!-- SILVER SPONSORS -->
    <div class="mb-14 reveal">
      <h3 class="text-[#8FB7C2] text-xs font-bold tracking-widest uppercase mb-6">
        Silver Sponsors
      </h3>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div
          v-for="(sponsor, index) in sponsors.silver"
          :key="sponsor.id"
          class="h-32 bg-[#050e12] border border-gray-800 border-b-2 border-b-[#8FB7C2] rounded-xl flex items-center justify-center transition-transform duration-300 hover:-translate-y-1 cursor-pointer group reveal-scale"
          :style="{ transitionDelay: `${(index % 3) * 0.1}s` }"
        >
          <span class="text-gray-600 text-xs font-bold uppercase tracking-widest group-hover:text-gray-400 transition-colors">
            {{ sponsor.name }}
          </span>
        </div>
      </div>
    </div>

    <!-- BRONZE SPONSORS & CTA -->
    <div class="reveal">
      <h3 class="text-[#C08A62] text-xs font-bold tracking-widest uppercase mb-6">
        Bronze Sponsors
      </h3>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div
          v-for="(sponsor, index) in sponsors.bronze"
          :key="sponsor.id"
          class="h-32 bg-[#050e12] border border-gray-800 border-b-2 border-b-[#C08A62] rounded-xl flex items-center justify-center transition-transform duration-300 hover:-translate-y-1 cursor-pointer group reveal-scale"
          :style="{ transitionDelay: `${(index % 3) * 0.1}s` }"
        >
          <span class="text-gray-600 text-xs font-bold uppercase tracking-widest group-hover:text-gray-400 transition-colors">
            {{ sponsor.name }}
          </span>
        </div>

        <a
          href="#sponsorship"
          class="h-32 bg-jd-cyan hover:bg-jd-cyan-dark rounded-xl flex items-center justify-center gap-3 transition-colors duration-300 shadow-[0_0_20px_rgba(24,188,188,0.2)]"
        >
          <svg class="w-6 h-6 text-[#050e12]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
          </svg>
          <span class="text-[#050e12] text-lg font-medium tracking-wide">
            become our sponsor
          </span>
        </a>
      </div>
    </div>
  </Section>
</template>

<script setup>
import Section from './ui/Section.vue'
import SectionHeader from './ui/SectionHeader.vue'
import { sponsors } from '../data/content'
</script>