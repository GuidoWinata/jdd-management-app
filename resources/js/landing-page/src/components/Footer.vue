<template>
  <footer
    class="relative pt-12 pb-10 px-6 font-sans border-t border-gray-800 overflow-hidden"
  >
    <!-- Background Image -->
    <div
      class="absolute inset-0 bg-cover bg-center"
      :style="{ backgroundImage: `url(${bgFooter})` }"
    ></div>

    <div class="container mx-auto relative z-10">
      <!-- TOP ROW: Social Icons & Nav Pills -->
      <div
        class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-24"
      >
        <!-- Social Icons -->
        <div class="flex gap-4">
          <a
            href="https://www.instagram.com/jatimdevday"
            class="w-10 h-10 rounded-full border border-gray-700/60 flex items-center justify-center text-gray-400 hover:text-white hover:border-white transition duration-300"
          >
            <PhInstagramLogo :size="18" :weight="'regular'" />
          </a>
          <a
            href="#"
            class="w-10 h-10 rounded-full border border-gray-700/60 flex items-center justify-center text-gray-400 hover:text-white hover:border-white transition duration-300"
          >
            <PhWhatsappLogo :size="18" :weight="'regular'" />
          </a>
        </div>

        <!-- Nav Pills -->
        <div class="flex flex-wrap gap-3">
          <a
            v-for="link in navLinks"
            :key="link.href"
            :href="link.href"
            class="px-6 py-2 rounded-full border border-gray-700/60 text-[10px] sm:text-xs font-semibold tracking-widest text-gray-400 hover:text-white hover:border-white uppercase transition duration-300"
          >
            {{ link.label }}
          </a>
        </div>
      </div>

      <!-- CENTER BIG LOGO & TEXT -->
      <div class="flex items-center gap-6 md:gap-10 mb-28 pl-4">
        <!-- JDD Logo -->
        <div class="relative w-28 h-28 md:w-36 md:h-36 flex-shrink-0">
          <img
            :src="jddLogo"
            alt="JDD Logo"
            class="w-full h-full object-contain drop-shadow-[0_0_25px_rgba(24,188,188,0.25)]"
          />
        </div>

        <!-- Text Title -->
        <div class="flex flex-col tracking-wide">
          <span
            class="text-4xl md:text-[3.5rem] font-black leading-[1.05] text-transparent bg-clip-text bg-gradient-to-r from-jd-cyan to-teal-500"
            >JATIM</span
          >
          <span
            class="text-4xl md:text-[3.5rem] font-black leading-[1.05] text-transparent bg-clip-text bg-gradient-to-r from-jd-cyan to-teal-700/80"
            >DEVELOPER</span
          >
          <span class="text-4xl md:text-[3.5rem] font-black leading-[1.05] text-jd-cyan"
            >DAY</span
          >
        </div>
      </div>

      <!-- BOTTOM ROW: Copyright & Links -->
      <div
        class="flex flex-col md:flex-row justify-between items-center gap-6 text-[10px] md:text-xs text-jd-cyan/80 tracking-widest font-semibold uppercase"
      >
        <div>JDD TEAM &copy; 2026, ALL RIGHTS RESERVED</div>

        <div class="flex flex-wrap justify-center gap-6 md:gap-8">
          <router-link to="/faq" class="hover:text-jd-cyan transition duration-300">FAQ</router-link>
          <a href="#" class="hover:text-jd-cyan transition duration-300">Term of Service</a>
          <router-link to="/refund-policy" class="hover:text-jd-cyan transition duration-300">Refund Policy</router-link>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
import bgFooter from "../assets/bg-footer.png";
import jddLogo from "../assets/jdd-logo.svg";
import { PhInstagramLogo, PhWhatsappLogo } from '@phosphor-icons/vue'

const props = defineProps({
  navLinks: {
    type: Array,
    default: () => [
      { label: 'Tentang', href: '#about' },
      { label: 'Venue', href: '#venue' },
      { label: 'Speaker', href: '#speakers' },
      { label: 'Agenda', href: '#agenda' },
    ],
  },
})
</script>