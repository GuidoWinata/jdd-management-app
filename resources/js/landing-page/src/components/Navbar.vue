<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { PhArrowLeft, PhArrowUpRight, PhList, PhX } from '@phosphor-icons/vue'
import jddLogo from '../assets/jdd-logo-white.svg'
import { URLS } from '../constants'

const props = defineProps({
  links: {
    type: Array,
    default: () => [
      { label: 'HOME', href: '#home' },
      { label: 'ABOUT', href: '#about' },
      { label: 'VENUE', href: '#venue' },
      { label: 'SPEAKERS', href: '#speakers' },
      { label: 'AGENDA', href: '#agenda' },
      { label: 'TICKETS', href: '#tickets' },
    ],
  },
  ctaLabel: { type: String, default: 'BELI TIKET' },
  ctaHref: { type: String, default: URLS.SPEAKER_FORM },
  backHref: { type: String, default: '' },
})

const navLinks = props.links

const activeId = ref('home')
const hidden = ref(false)
const menuOpen = ref(false)

let lastScrollY = 0
let observer = null

function onScroll() {
  const y = window.scrollY
  hidden.value = y > lastScrollY && y > 120
  lastScrollY = y
}

function toggleMenu() {
  menuOpen.value = !menuOpen.value
}

function closeMenu() {
  menuOpen.value = false
}

function navigateTo(href) {
  closeMenu()
  const el = document.querySelector(href)
  if (el) {
    el.scrollIntoView({ behavior: 'smooth' })
  }
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
  <!-- Mobile Menu Overlay -->
  <div
    v-if="menuOpen"
    class="fixed inset-0 z-[59] bg-black/60 backdrop-blur-sm lg:hidden"
    @click="closeMenu"
  ></div>

  <!-- Mobile Menu Drawer -->
  <div
    class="fixed top-0 right-0 h-full w-72 z-[60] bg-jd-bg/95 backdrop-blur-md border-l border-white/10 transform transition-transform duration-300 lg:hidden"
    :class="menuOpen ? 'translate-x-0' : 'translate-x-full'"
  >
    <div class="flex items-center justify-between px-6 py-5 border-b border-white/10">
      <span class="text-white font-bold text-sm tracking-widest uppercase">Menu</span>
      <button @click="closeMenu" class="text-gray-400 hover:text-white transition-colors">
        <PhX :size="24" :weight="'bold'" />
      </button>
    </div>
    <nav class="flex flex-col px-6 py-6 gap-1">
      <a
        v-for="link in navLinks"
        :key="link.href"
        :href="link.href"
        @click.prevent="navigateTo(link.href)"
        :class="[
          'py-3 px-4 rounded-xl text-sm font-semibold tracking-wide transition-colors duration-300',
          activeId === link.href.slice(1)
            ? 'text-jd-cyan bg-white/5'
            : 'text-gray-400 hover:text-white hover:bg-white/5',
        ]"
      >{{ link.label }}</a>
      <a
        :href="ctaHref"
        class="mt-4 bg-jd-cyan hover:bg-jd-cyan-dark text-jd-on-cyan font-bold text-xs px-6 py-3 rounded-full flex items-center justify-center gap-2 transition-colors duration-300 shadow-md"
      >
        <span>{{ ctaLabel }}</span>
        <PhArrowUpRight :size="16" :weight="'bold'" />
      </a>
    </nav>
  </div>

  <!-- Main Navbar -->
  <nav
    class="fixed top-4 sm:top-6 left-1/2 -translate-x-1/2 w-[95%] max-w-7xl z-50 bg-white/5 backdrop-blur-md shadow-2xl rounded-full px-4 sm:px-6 py-2.5 sm:py-3 flex items-center justify-between transition-all duration-500"
    :class="hidden ? '-translate-y-[150%] opacity-0 pointer-events-none' : 'opacity-100'"
  >
    <!-- Bagian Kiri: Logo & Judul -->
    <a href="/" class="flex items-center gap-3 sm:gap-4 cursor-pointer">
      <img :src="jddLogo" alt="JDD Logo" class="w-9 sm:w-11 h-auto drop-shadow-[0_0_25px_rgba(207,221,17,0.25)]" />

      <div class="flex flex-col text-white font-bold text-[11px] sm:text-[13px] leading-tight tracking-wider drop-shadow-[0_0_25px_rgba(207,221,17,0.25)]">
        <span>JATIM</span>
        <span>DEVELOPER</span>
        <span>DAY</span>
      </div>
    </a>

    <!-- Bagian Tengah: Navigation Links (Desktop) -->
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

    <!-- Bagian Kanan: Hamburger (Mobile) / Back or CTA (Desktop) -->
    <div class="flex items-center gap-3">
      <router-link
        v-if="backHref"
        :to="backHref"
        class="hidden sm:flex items-center gap-2 text-jd-cyan hover:text-white text-sm font-semibold transition-colors duration-300"
      >
        <PhArrowLeft :size="18" :weight="'bold'" />
        <span class="hidden sm:inline">Kembali</span>
      </router-link>
      <a
        v-else
        :href="ctaHref"
        class="bg-jd-cyan hover:bg-jd-cyan-dark text-jd-on-cyan font-bold text-xs sm:text-sm px-3.5 sm:px-6 py-2 sm:py-2.5 rounded-full items-center gap-2 transition-colors duration-300 shadow-md whitespace-nowrap hidden lg:flex"
      >
        <span>{{ ctaLabel }}</span>
        <PhArrowUpRight :size="16" :weight="'bold'" />
      </a>

      <!-- Hamburger Button (Mobile) -->
      <button
        @click="toggleMenu"
        class="lg:hidden text-white hover:text-jd-cyan transition-colors duration-300 p-1"
        aria-label="Toggle navigation menu"
      >
        <PhList :size="24" :weight="'bold'" />
      </button>
    </div>
  </nav>
</template>