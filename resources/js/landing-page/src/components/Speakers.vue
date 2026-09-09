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
    <div v-if="speakersData && speakersData.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <div
        v-for="(speaker, index) in speakersData"
        :key="speaker.id"
        :class="[
          'relative rounded-2xl overflow-hidden h-[420px] flex flex-col justify-between p-6 group transition-transform duration-300 hover:-translate-y-2 cursor-pointer shadow-lg',
          speaker.is_active ? 'bg-jd-cyan' : 'bg-[#22313b]',
        ]"
        :style="{ transitionDelay: `${(index % 3) * 0.1}s` }"
      >
        <!-- IMAGE AREA -->
        <div class="absolute inset-x-0 bottom-0 top-12 flex justify-center z-0 pointer-events-none">
          <div
            class="w-full h-full bg-center bg-cover bg-no-repeat opacity-90"
            :style="speakerPhoto(speaker.photo_path)
              ? { backgroundImage: `url('${speakerPhoto(speaker.photo_path)}')` }
              : {}"
          >
            <span
              v-if="!speakerPhoto(speaker.photo_path)"
              class="absolute inset-0 flex items-center justify-center text-xs font-medium opacity-50"
              :class="speaker.is_active ? 'text-black' : 'text-white'"
            >
              [Foto Grayscale]
            </span>
          </div>

          <div
            class="absolute inset-0 bg-gradient-to-t"
            :class="
              speaker.is_active
                ? 'from-jd-cyan/30 via-jd-cyan/5 to-transparent'
                : 'from-[#22313b]/30 via-[#22313b]/5 to-transparent'
            "
          ></div>
        </div>

        <!-- TOP LEFT: Category -->
        <div
          class="relative z-10 text-[10px] tracking-[0.2em] uppercase font-bold"
          :class="speaker.is_active ? 'text-white/80' : 'text-gray-400'"
        >
          {{ speaker.speaker_group || 'SPEAKER' }}
        </div>

        <!-- BOTTOM: Info & Logo -->
        <div class="relative z-10 flex justify-between items-end">
          <div>
            <h3 class="text-xl font-bold text-white mb-1">{{ speaker.name }}</h3>
            <p
              class="text-xs font-semibold"
              :class="speaker.is_active ? 'text-[#0b4251]' : 'text-jd-cyan'"
            >
              {{ speaker.job_title }}
            </p>
          </div>

          <div class="flex items-center justify-end opacity-70">
            <div class="w-2.5 h-2.5 bg-white mr-1.5 opacity-90"></div>
            <span class="text-[7px] tracking-[0.2em] text-white font-bold uppercase">{{ speaker.company }}</span>
          </div>
        </div>
      </div>

      <!-- PLACEHOLDER: Speaker TBA (Coming Soon) -->
      <div
        v-for="placeholder in upcomingSpeakers"
        :key="placeholder.id"
        class="relative rounded-2xl overflow-hidden h-105 flex flex-col border border-[#18BCBC] shadow-lg bg-[#1e2933] transition-transform duration-300 hover:-translate-y-2 cursor-pointer"
      >
        <!-- TOP SECTION (Dark Terminal) -->
        <div class="bg-[#1e2933] relative flex-1 flex flex-col items-center justify-center p-6">
          <!-- Corner Brackets -->
          <div class="absolute top-6 left-6 w-4 h-4 border-t border-l border-white"></div>
          <div class="absolute top-6 right-6 w-4 h-4 border-t border-r border-white"></div>
          <div class="absolute bottom-6 left-6 w-4 h-4 border-b border-l border-white"></div>
          <div class="absolute bottom-6 right-6 w-4 h-4 border-b border-r border-white"></div>

          <!-- Top Left Text -->
          <span class="absolute top-5 left-14 text-white text-xs tracking-[0.3em]">
            [ ? ? ? ]
          </span>

          <!-- Top Right Badge -->
          <div class="absolute top-4 right-14 border border-dashed border-[#284f58] rounded-full px-3 py-1 flex items-center gap-2 bg-[#1b2f38]">
            <div class="w-2 h-2 rounded-full bg-[#18BCBC]"></div>
            <span class="text-white text-[10px] tracking-[0.2em] uppercase">Slot Open</span>
          </div>

          <!-- Main Icon (Question Mark) -->
          <div class="text-[120px] md:text-[140px] leading-none text-[#b1b8be] font-light mt-4 select-none">
            ?
          </div>

          <!-- Sub-label -->
          <div class="mt-8 text-white text-sm font-bold tracking-[0.3em] uppercase">
            Identity Unknown
          </div>
        </div>

        <!-- BOTTOM SECTION (Light Content) -->
        <div class="bg-white p-6 flex flex-col justify-center">
          <h4 class="text-[#0a1824] text-lg font-bold tracking-wide mb-1">
            > SPEAKER_PENDING
          </h4>
          <span class="text-[#1e2933] text-xs tracking-[0.3em] uppercase">
            To be assigned
          </span>
        </div>
      </div>
    </div>

    <!-- CTA: More Speakers Coming + Become a Speaker -->
    <div class="flex flex-col items-center gap-6 mt-14">
      <p class="text-gray-400 text-sm tracking-wide text-center">
        <span class="inline-block w-2 h-2 rounded-full bg-jd-cyan mr-2 animate-pulse"></span>
        More speakers to be announced soon
      </p>
      <AppButton href="https://sessionize.com/jdd-2026" target="_blank" :glow="true">
        JADI SPEAKERS
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 19L20 5m0 0H9m11 0v11"></path>
        </svg>
      </AppButton>
    </div>
  </Section>
</template>

<script setup lang="ts">
import Section from './ui/Section.vue'
import SectionHeader from './ui/SectionHeader.vue'
import AppButton from './ui/AppButton.vue'
import { useSpeakers } from '../composables/useEventData'
import { useConfig } from '../config'

const speakersData = useSpeakers()
const { baseUrl } = useConfig()

// Placeholder untuk speaker yang belum diumumkan
const upcomingSpeakers = [
  { id: 'tba-1', name: 'Segera Diumumkan' },
  { id: 'tba-2', name: 'Segera Diumumkan' },
  { id: 'tba-3', name: 'Segera Diumumkan' },
]

function speakerPhoto(photoPath: string | null): string {
  if (!photoPath) return ''
  return photoPath.startsWith('http') ? photoPath : `${baseUrl}/storage/${photoPath}`
}
</script>