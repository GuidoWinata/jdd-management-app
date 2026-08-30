<template>
  <Section id="speakers">
    <SectionHeader
      number="02"
      label="Meet Our Speakers"
      description="Para praktisi global yang telah menguji keahlian mereka di skala produksi industri teknologi terbesar."
    >
      MEET OUR <span class="text-jd-cyan">HEADLINERS</span>
    </SectionHeader>

    <!-- SPEAKERS GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <div
        v-for="(speaker, index) in speakers"
        :key="speaker.id"
        :class="[
          'relative rounded-2xl overflow-hidden h-[420px] flex flex-col justify-between p-6 group transition-transform duration-300 hover:-translate-y-2 cursor-pointer shadow-lg reveal-scale',
          speaker.highlighted ? 'bg-jd-cyan' : 'bg-[#22313b]',
        ]"
        :style="{ transitionDelay: `${(index % 3) * 0.1}s` }"
      >
        <!-- IMAGE AREA -->
        <div class="absolute inset-x-0 bottom-0 top-12 flex justify-center z-0 pointer-events-none">
          <div
            class="w-full h-full bg-center bg-cover bg-no-repeat opacity-60"
            style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 100 100\'><rect fill=\'%23ffffff\' fill-opacity=\'0.05\' width=\'100\' height=\'100\'/></svg>');"
          >
            <span
              class="absolute inset-0 flex items-center justify-center text-xs font-medium opacity-50"
              :class="speaker.highlighted ? 'text-black' : 'text-white'"
            >
              [Foto Grayscale]
            </span>
          </div>

          <div
            class="absolute inset-0 bg-gradient-to-t"
            :class="
              speaker.highlighted
                ? 'from-jd-cyan via-jd-cyan/30 to-transparent'
                : 'from-[#22313b] via-[#22313b]/30 to-transparent'
            "
          ></div>
        </div>

        <!-- TOP LEFT: Category -->
        <div
          class="relative z-10 text-[10px] tracking-[0.2em] uppercase font-bold"
          :class="speaker.highlighted ? 'text-white/80' : 'text-gray-400'"
        >
          {{ speaker.category }}
        </div>

        <!-- BOTTOM: Info & Logo -->
        <div class="relative z-10 flex justify-between items-end">
          <div>
            <h3 class="text-xl font-bold text-white mb-1">{{ speaker.name }}</h3>
            <p
              class="text-xs font-semibold"
              :class="speaker.highlighted ? 'text-[#0b4251]' : 'text-jd-cyan'"
            >
              {{ speaker.role }}
            </p>
          </div>

          <div class="flex items-center justify-end opacity-70">
            <div class="w-2.5 h-2.5 bg-white mr-1.5 opacity-90"></div>
            <span class="text-[7px] tracking-[0.2em] text-white font-bold uppercase">{{ speaker.company }}</span>
          </div>
        </div>
      </div>
    </div>
  </Section>
</template>

<script setup>
import Section from './ui/Section.vue'
import SectionHeader from './ui/SectionHeader.vue'
import { speakers } from '../data/content'
</script>