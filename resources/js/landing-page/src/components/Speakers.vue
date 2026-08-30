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
            class="w-full h-full bg-center bg-cover bg-no-repeat opacity-60"
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
                ? 'from-jd-cyan via-jd-cyan/30 to-transparent'
                : 'from-[#22313b] via-[#22313b]/30 to-transparent'
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
    </div>
  </Section>
</template>

<script setup lang="ts">
import Section from './ui/Section.vue'
import SectionHeader from './ui/SectionHeader.vue'
import { useSpeakers } from '../composables/useEventData'
import { useConfig } from '../config'

const speakersData = useSpeakers()
const { baseUrl } = useConfig()

function speakerPhoto(photoPath: string | null): string {
  if (!photoPath) return ''
  return photoPath.startsWith('http') ? photoPath : `${baseUrl}/storage/${photoPath}`
}
</script>