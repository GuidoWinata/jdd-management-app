<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import jddLogo from '../assets/jdd-logo.svg'

const props = defineProps({
  links: {
    type: Array,
    default: () => [
      { label: 'HOME', href: '#home' },
      { label: 'ABOUT', href: '#about' },
      { label: 'SPEAKERS', href: '#speakers' },
      { label: 'AGENDA', href: '#agenda' },
      { label: 'TICKETS', href: '#tickets' },
    ],
  },
  ctaLabel: { type: String, default: 'BELI TIKET' },
  ctaHref: { type: String, default: '#tickets' },
})

const navLinks = props.links

const activeId = ref('home')
const hidden = ref(false)

let lastScrollY = 0
let observer = null

function onScroll() {
  const y = window.scrollY
  hidden.value = y > lastScrollY && y > 120
  lastScrollY = y
}

onMounted(() => {
  window.addEventListener('scroll', onScroll, { passive: true })

  observer = new IntersectionObserver(
    (entries) => {
      for (const entry of entries) {
        if (entry.isIntersecting) activeId.value = entry.target.id
      }
    },
    { rootMargin: '-20% 0px -70% 0px', threshold: 0 }
  )

  document.querySelectorAll('section[id]').forEach((el) => observer.observe(el))
})

onUnmounted(() => {
  window.removeEventListener('scroll', onScroll)
  observer?.disconnect()
})
</script>

<template>
  <nav
    class="fixed top-4 sm:top-6 left-1/2 -translate-x-1/2 w-[95%] max-w-7xl z-50 bg-[#0B1A24]/40 backdrop-blur-xl border border-white/15 shadow-2xl rounded-full px-4 sm:px-6 py-2.5 sm:py-3 flex items-center justify-between transition-all duration-500"
    :class="hidden ? '-translate-y-[150%] opacity-0 pointer-events-none' : 'opacity-100'"
  >
    <!-- Bagian Kiri: Logo & Judul -->
    <a href="#home" class="flex items-center gap-3 sm:gap-4 cursor-pointer">
      <img :src="jddLogo" alt="JDD Logo" class="w-9 sm:w-11 h-auto" />

      <div class="flex flex-col text-jd-cyan font-bold text-[11px] sm:text-[13px] leading-tight tracking-wider">
        <span>JATIM</span>
        <span>DEVELOPER</span>
        <span>DAY</span>
      </div>
    </a>

    <!-- Bagian Tengah: Navigation Links -->
    <div class="hidden lg:flex items-center gap-8 text-sm font-semibold">
      <a
        v-for="link in navLinks"
        :key="link.href"
        :href="link.href"
        :class="[
          'transition-colors duration-300 tracking-wide',
          activeId === link.href.slice(1)
            ? 'text-jd-cyan'
            : 'text-gray-400 hover:text-white',
        ]"
        >{{ link.label }}</a
      >
    </div>

    <!-- Bagian Kanan: Call to Action Button -->
    <div class="flex items-center">
      <a
        :href="ctaHref"
        class="bg-jd-cyan hover:bg-jd-cyan-dark text-[#0B1A24] font-bold text-xs sm:text-sm px-3.5 sm:px-6 py-2 sm:py-2.5 rounded-full flex items-center gap-2 transition-colors duration-300 shadow-md whitespace-nowrap"
      >
        <span>{{ ctaLabel }}</span>
        <svg class="hidden sm:block" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="7" y1="17" x2="17" y2="7"></line>
          <polyline points="7 7 17 7 17 17"></polyline>
        </svg>
      </a>
    </div>
  </nav>
</template>