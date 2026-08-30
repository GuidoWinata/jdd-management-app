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
            href="#"
            class="w-10 h-10 rounded-full border border-gray-700/60 flex items-center justify-center text-gray-400 hover:text-white hover:border-white transition duration-300"
          >
            <!-- Instagram Icon -->
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="1.5"
                d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01M7 3h10a4 4 0 014 4v10a4 4 0 01-4 4H7a4 4 0 01-4-4V7a4 4 0 014-4z"
              ></path>
            </svg>
          </a>
          <a
            href="#"
            class="w-10 h-10 rounded-full border border-gray-700/60 flex items-center justify-center text-gray-400 hover:text-white hover:border-white transition duration-300"
          >
            <!-- WhatsApp Icon -->
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="1.5"
                d="M17.498 14.382c-.301-.15-1.767-.867-2.04-.966-.274-.101-.473-.15-.673.15-.197.295-.771.964-.944 1.162-.175.195-.349.21-.646.068-.301-.15-1.265-.464-2.409-1.485-.888-.795-1.484-1.77-1.66-2.07-.174-.3-.019-.465.13-.615.136-.135.301-.345.451-.523.146-.181.194-.301.297-.496.098-.2.05-.375-.025-.524-.075-.15-.672-1.62-.922-2.206-.24-.584-.487-.51-.672-.51-.172-.015-.371-.015-.571-.015-.2 0-.523.074-.797.359-.273.3-1.045 1.02-1.045 2.475s1.07 2.865 1.219 3.075c.149.195 2.105 3.195 5.1 4.485.714.3 1.27.48 1.704.629.714.227 1.365.195 1.88.121.574-.091 1.767-.721 2.016-1.426.255-.705.255-1.29.18-1.425-.074-.135-.27-.21-.57-.36z"
              ></path>
            </svg>
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
        <div>JDD TEAM &copy; 2025, ALL RIGHTS RESERVED</div>

        <div class="flex flex-wrap justify-center gap-6 md:gap-8">
          <a href="#" class="hover:text-jd-cyan transition duration-300">FAQ</a>
          <a href="#" class="hover:text-jd-cyan transition duration-300">Term of Service</a>
          <a href="#" class="hover:text-jd-cyan transition duration-300">Refund Policy</a>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
import bgFooter from "../assets/bg-footer.png";
import jddLogo from "../assets/jdd-logo.svg";

const props = defineProps({
  navLinks: {
    type: Array,
    default: () => [
      { label: 'Tentang', href: '#about' },
      { label: 'Speaker', href: '#speakers' },
      { label: 'Agenda', href: '#agenda' },
    ],
  },
})
</script>