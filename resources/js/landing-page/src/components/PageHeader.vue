<template>
  <header class="w-full py-16 md:py-52 px-6 bg-red-300 relative overflow-hidden">
    
    <!-- Background Image (same as Hero) -->
    <div
      class="absolute inset-0 bg-cover bg-center bg-no-repeat z-0"
      :style="{ backgroundImage: `url(${heroImg})` }"
    ></div>

    <div class="container mx-auto max-w-6xl relative z-10">
      
      <!-- Headline Utama -->
      <h1 class="text-5xl md:text-6xl  font-semibold leading-[1.1] mb-6">
        <span v-if="titleSolid" class="block text-jd-text-light">{{ titleSolid }}</span>
        <span v-if="titleOutline" class="block text-jd-cyan">{{ titleOutline }}</span>
      </h1>

      <!-- Subtitle -->
      <p v-if="subtitle" class="text-jd-text-muted text-base max-w-2xl">
        {{ subtitle }}
      </p>

    </div>
  </header>
</template>

<script setup>
import { defineProps } from 'vue';
import heroImg from "../assets/background-img.png";

defineProps({
  titleSolid: {
    type: String,
    default: ''
  },
  titleOutline: {
    type: String,
    default: ''
  },
  subtitle: {
    type: String,
    default: ''
  }
});
</script>
