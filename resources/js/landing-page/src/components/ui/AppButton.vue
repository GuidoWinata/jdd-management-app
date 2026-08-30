<script setup>
import { computed } from 'vue'

const props = defineProps({
  href: { type: String, default: undefined },
  variant: { type: String, default: 'solid' }, // 'solid' | 'outline' | 'outline-fill'
  size: { type: String, default: 'md' }, // 'md' | 'lg'
  glow: { type: Boolean, default: false },
})

const variantClass = computed(
  () =>
    ({
      solid: 'bg-jd-cyan hover:bg-jd-cyan-dark text-black',
      outline: 'border-2 border-gray-500/40 text-gray-300 hover:border-jd-cyan hover:text-jd-cyan',
      'outline-fill': 'border border-jd-cyan text-jd-cyan hover:bg-jd-cyan hover:text-black',
    }[props.variant])
)

const sizeClass = computed(
  () =>
    ({
      md: 'px-8 py-3.5 text-xs md:text-sm',
      lg: 'px-10 py-4 text-xs md:text-sm',
    }[props.size])
)

const classes = computed(() => [
  'inline-flex items-center justify-center gap-2 rounded-full font-bold uppercase tracking-[0.15em] transition-all duration-300',
  variantClass.value,
  sizeClass.value,
  props.glow ? 'shadow-[0_0_20px_rgba(24,188,188,0.2)]' : '',
])
</script>

<template>
  <a v-if="href" :href="href" :class="classes">
    <slot />
  </a>
  <button v-else :class="classes">
    <slot />
  </button>
</template>