<template>
  <!-- Container dengan background putih dan border atas-bawah gelap -->
  <div class="w-full border-t-[3px] border-b-[3px] border-[#082f3c] py-8 font-sans">
    <div class="container mx-auto px-4 max-w-7xl">
      <div class="flex flex-col md:flex-row justify-between items-center gap-10 md:gap-0">
        <template v-for="(stat, index) in stats" :key="index">
          <!-- Stat Item -->
          <div class="flex items-center gap-4 px-2 lg:px-6 w-full md:w-auto justify-center md:justify-start">
            <!-- Icon -->
            <div class="text-[#cae8ea] w-12 h-12 flex-shrink-0 flex items-center justify-center">
              <svg v-if="stat.icon === 'people'" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-full h-full">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.318a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM20.25 10.5a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM6.75 13.5A6.75 6.75 0 000 20.25v.75h13.5v-.75a6.75 6.75 0 00-6.75-6.75zM15.75 16.5a6.75 6.75 0 00-6.386-4.5h-.404a8.23 8.23 0 014.538 4.5h2.25z" />
              </svg>
              <svg v-else-if="stat.icon === 'building'" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-full h-full">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 21h18M5 21V5a2 2 0 012-2h10a2 2 0 012 2v16M9 9h2M9 13h2M9 17h2M13 9h2M13 13h2M13 17h2" />
              </svg>
              <svg v-else-if="stat.icon === 'calendar'" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-full h-full">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                <rect x="7" y="14" width="2" height="2" fill="currentColor" stroke="none" />
              </svg>
              <svg v-else-if="stat.icon === 'briefcase'" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-full h-full">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.118l-12.14.93A2.25 2.25 0 014.5 19.22v-4.81M20.25 14.15A5.228 5.228 0 0018 13.5H6a5.228 5.228 0 00-2.25.65M20.25 14.15V9a2.25 2.25 0 00-2.25-2.25h-1.5M4.5 14.15V9A2.25 2.25 0 016.75 6.75h1.5M9 6.75v-1.5a2.25 2.25 0 012.25-2.25h1.5a2.25 2.25 0 012.25 2.25v1.5M9 6.75h6" />
              </svg>
            </div>

            <!-- Text Content -->
            <div class="flex flex-col">
              <span class="text-3xl lg:text-[2.5rem] font-black text-[#cae8ea] leading-none mb-1">
                {{ stat.number }}
              </span>
              <span class="text-[10px] lg:text-xs font-bold tracking-[0.15em] text-[#619b9e] uppercase">
                {{ stat.label }}
              </span>
            </div>
          </div>

          <!-- Vertical Separator (Desktop) -->
          <div v-if="index < stats.length - 1" class="hidden md:block w-[1px] h-14 bg-[#082f3c] opacity-80 flex-shrink-0"></div>

          <!-- Horizontal Separator (Mobile) -->
          <div v-if="index < stats.length - 1" class="block md:hidden w-16 h-[1px] bg-[#082f3c] opacity-30"></div>
        </template>
      </div>
    </div>
  </div>
</template>

<script setup>
import { stats } from '../data/content'
</script>