<script setup lang="ts">
import Home from './views/Home.vue'
import CallForSpeakers from './views/CallForSpeakers.vue'

const isSpeakersMode = window.APP_CONFIG?.appType === 'speakers'
</script>

<template>
  <CallForSpeakers v-if="isSpeakersMode" />
  <Home v-else />
</template>
