<template>
  <Section id="how-it-works" variant="deep">
    <SectionHeader
      number="02"
      label="How It Works"
      description="Proses pendaftaran sederhana dan transparan — dari pengiriman proposal hingga naik panggung JDD 2026."
    >
      CARA <span class="text-jd-cyan">MENDAFTAR</span>
    </SectionHeader>

    <div class="relative flex flex-col lg:flex-row gap-10 lg:gap-0">
      <!-- Connecting line (desktop) -->
      <div
        class="hidden lg:block absolute top-10 left-[10%] right-[10%] h-px bg-gradient-to-r from-transparent via-gray-700 to-transparent"
      ></div>

      <div
        v-for="(step, index) in steps"
        :key="step.title"
        class="flex-1 relative flex flex-col items-center text-center px-6 reveal"
        :style="{ transitionDelay: `${index * 0.1}s` }"
      >
        <div
          class="relative w-20 h-20 rounded-full bg-[#0a1c26] border-2 border-jd-cyan/40 flex items-center justify-center text-jd-cyan mb-6 z-10"
        >
          <component :is="step.icon" :size="30" :stroke-width="1.5" />
          <span
            class="absolute -top-2 -right-2 w-7 h-7 rounded-full bg-jd-cyan text-black text-xs font-black flex items-center justify-center"
          >
            {{ index + 1 }}
          </span>
        </div>

        <h3 class="text-white font-bold text-base tracking-wide uppercase mb-3">
          {{ step.title }}
        </h3>
        <p class="text-gray-400 text-sm leading-relaxed max-w-xs">
          {{ step.description }}
        </p>
      </div>
    </div>

    <!-- CTA bawah -->
    <div class="mt-16 flex justify-center reveal-scale">
      <AppButton :glow="true" :href="formUrl" size="lg">
        KIRIM PROPOSAL SEKARANG
        <span class="text-lg leading-none">&rarr;</span>
      </AppButton>
    </div>
  </Section>
</template>

<script setup>
import { FileText, ClipboardCheck, CalendarClock, Rocket } from '@lucide/vue'
import Section from './ui/Section.vue'
import SectionHeader from './ui/SectionHeader.vue'
import AppButton from './ui/AppButton.vue'

const formUrl = import.meta.env.VITE_SPEAKER_FORM_URL || '#'

const steps = [
  {
    icon: FileText,
    title: 'Kirim Proposal',
    description:
      'Isi form dengan judul, abstrak singkat, dan pengantar singkat tentang Anda. Tidak perlu sempurna — yang penting jelas.',
  },
  {
    icon: ClipboardCheck,
    title: 'Kurasi oleh Komite',
    description:
      'Tim kurator meninjau setiap proposal berdasarkan kualitas, relevansi topik, dan kesesuaian dengan audiens JDD.',
  },
  {
    icon: CalendarClock,
    title: 'Pengumuman',
    description:
      'Pembicara terpilih akan dihubungi dan dikonfirmasi jadwal serta format sesinya secara pribadi.',
  },
  {
    icon: Rocket,
    title: 'Naik Panggung',
    description:
      'Sampaikan materi Anda di hadapan ribuan peserta dan jadilah bagian dari Jatim Developer Day 2026.',
  },
]
</script>