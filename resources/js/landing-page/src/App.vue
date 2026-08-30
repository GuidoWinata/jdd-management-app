<script setup lang="ts">
import Home from './views/Home.vue'
import CallForSpeakers from './views/CallForSpeakers.vue'

const isSpeakersMode = import.meta.env.VITE_APP_TYPE === 'speakers'
</script>

<template>
  <CallForSpeakers v-if="isSpeakersMode" />
  <Home v-else />
</template>
