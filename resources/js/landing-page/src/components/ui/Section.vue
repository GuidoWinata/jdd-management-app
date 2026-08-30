<script setup>
import { computed } from 'vue'

const props = defineProps({
  id: { type: String, default: undefined },
  variant: { type: String, default: 'base' }, // 'base' | 'deep'
  size: { type: String, default: 'md' }, // 'md' | 'lg'
  borderTop: { type: Boolean, default: false },
  container: { type: String, default: 'max-w-6xl' },
})

const bgClass = computed(() => (props.variant === 'deep' ? 'bg-jd-bg-deep' : 'bg-jd-bg'))

const sectionClass = computed(() => [
  'text-white font-sans overflow-hidden',
  bgClass.value,
  props.size === 'lg' ? 'py-32' : 'py-24',
  props.borderTop ? 'border-t border-gray-900' : '',
])
</script>

<template>
  <section :id="id" :class="sectionClass">
    <div v-if="$slots.default" class="container mx-auto px-6" :class="container">
      <slot />
    </div>
    <slot name="full" />
  </section>
</template>
