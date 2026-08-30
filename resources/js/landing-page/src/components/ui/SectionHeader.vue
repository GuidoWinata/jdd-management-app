<script setup>
import { computed } from 'vue'

const props = defineProps({
  number: { type: String, default: '' },
  label: { type: String, default: '' },
  title: { type: String, default: '' },
  description: { type: String, default: '' },
  headlineClass: { type: String, default: '' },
  descriptionClass: { type: String, default: '' },
})

const headlineClass = computed(
  () => props.headlineClass || 'text-4xl md:text-5xl font-black uppercase tracking-wider'
)

const descriptionClass = computed(
  () =>
    props.descriptionClass ||
    'text-gray-400 text-sm md:text-base font-medium max-w-2xl leading-relaxed'
)
</script>

<template>
  <div class="flex flex-col items-center text-center mb-16 reveal">
    <div v-if="label || number" class="flex items-center gap-4 mb-6">
      <span class="text-jd-cyan text-xs font-bold tracking-widest">{{ number }}</span>
      <div class="w-12 h-px bg-gray-700"></div>
      <span class="text-gray-400 text-xs font-semibold tracking-[0.2em] uppercase">{{ label }}</span>
    </div>

    <h2 :class="headlineClass">
      <slot>{{ title }}</slot>
    </h2>

    <p v-if="description" :class="descriptionClass">
      {{ description }}
    </p>
  </div>
</template>