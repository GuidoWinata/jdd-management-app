<template>
  <Section variant="deep" size="lg" border-top container="max-w-7xl">
    <div class="flex flex-col items-center text-center">
      <!-- Eyebrow Text -->
      <span
        class="text-jd-cyan text-sm font-bold tracking-[0.2em] uppercase mb-8 block reveal"
        style="transition-delay: 0.1s"
      >
        Limited Seats Available
      </span>

      <!-- Main Headline -->
      <h2
        class="text-5xl md:text-7xl font-montserrat font-black uppercase tracking-tight mb-8 leading-tight reveal"
        style="transition-delay: 0.2s"
      >
        BE PART OF THE <span class="text-jd-cyan">MOMENT</span>
      </h2>

      <!-- Subtitle -->
      <p
        class="text-[#98b6c2] text-lg md:text-xl font-medium leading-relaxed max-w-3xl mb-12 reveal"
        style="transition-delay: 0.3s"
      >
        Bergabunglah bersama 500+ developer dan tech leader Jawa Timur dalam acara yang mendefinisikan ulang masa depan teknologi.
      </p>

      <!-- Action Buttons -->
      <div
        class="flex flex-col sm:flex-row items-center justify-center gap-6 w-full sm:w-auto reveal"
        style="transition-delay: 0.4s"
      >
        <AppButton :glow="true" :href="primaryHref" class="w-full sm:w-auto">
          {{ primaryLabel }}
          <span class="text-lg leading-none">&rarr;</span>
        </AppButton>

        <AppButton variant="outline" :href="secondaryHref" class="w-full sm:w-auto">
          {{ secondaryLabel }}
          <span class="text-lg leading-none">&rarr;</span>
        </AppButton>
      </div>
    </div>
  </Section>
</template>

<script setup>
import Section from './ui/Section.vue'
import AppButton from './ui/AppButton.vue'

defineProps({
  primaryLabel: { type: String, default: 'DAPATKAN TIKET' },
  primaryHref: { type: String, default: '#tickets' },
  secondaryLabel: { type: String, default: 'JADI SPONSORSHIP' },
  secondaryHref: { type: String, default: '#sponsors' },
})
</script>