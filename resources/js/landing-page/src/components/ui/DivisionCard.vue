<template>
  <div class="flex flex-col items-center text-center w-36 sm:w-40 md:w-48">
    <!-- Division Header -->
    <div class="bg-jd-card-alt/80 border border-jd-cyan/30 rounded-xl px-4 py-3 mb-3 w-full shadow-[0_0_15px_rgba(207,221,17,0.05)]">
      <p class="text-jd-cyan text-xs tracking-[0.15em] uppercase font-bold">{{ name }}</p>
      <p class="text-white text-xs font-semibold mt-1.5">{{ head }}</p>
    </div>

    <!-- Members -->
    <div class="flex flex-col gap-1.5 w-full">
      <div
        v-for="member in members"
        :key="member"
        class="bg-jd-card-alt/40 border border-gray-800 rounded-lg px-3 py-2 text-center"
      >
        <p class="text-gray-400 text-[11px] tracking-wide">{{ member }}</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  name: string
  head: string
  members: string[]
}>()
</script>
