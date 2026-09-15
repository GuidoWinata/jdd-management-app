<template>
  <!-- Container dengan background putih dan border atas-bawah -->
  <div class="w-full border-t border-b border-jd-dark py-8 font-sans bg-background">
    <div class="container mx-auto px-4">
      <div class="flex flex-col md:flex-row justify-between items-center gap-10 md:gap-0">
        <template v-for="(stat, index) in stats" :key="index">
          <!-- Stat Item -->
          <div class="flex items-center gap-4 px-2 lg:px-6 w-full md:w-auto justify-center md:justify-start">
            <!-- Icon -->
            <div class="text-jd-dark w-12 h-12 flex-shrink-0 flex items-center justify-center">
              <component :is="iconMap[stat.icon]" :size="48" :weight="'regular'" />
            </div>

            <!-- Text Content -->
            <div class="flex flex-col">
              <span class="text-3xl lg:text-[2.5rem] font-bold text-jd-dark leading-none mb-1">
                {{ stat.number }}
              </span>
              <span class="text-[10px] lg:text-xs font-bold tracking-[0.15em] text-gray-500 uppercase">
                {{ stat.label }}
              </span>
            </div>
          </div>

          <!-- Vertical Separator (Desktop) -->
          <div v-if="index < stats.length - 1" class="hidden md:block w-[1px] h-14 bg-jd-dark opacity-80 flex-shrink-0"></div>

          <!-- Horizontal Separator (Mobile) -->
          <div v-if="index < stats.length - 1" class="block md:hidden w-16 h-[1px] bg-jd-dark opacity-30"></div>
        </template>
      </div>
    </div>
  </div>
</template>

<script setup>
import { stats } from '../data/content'
import { PhUsers, PhBuildingOffice, PhCalendarBlank, PhBriefcase } from '@phosphor-icons/vue'

const iconMap = {
  people: PhUsers,
  building: PhBuildingOffice,
  calendar: PhCalendarBlank,
  briefcase: PhBriefcase,
}
</script>