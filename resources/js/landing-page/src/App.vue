<script setup lang="ts">
import CallForSpeakers from './views/CallForSpeakers.vue'

const isSpeakersMode = window.APP_CONFIG?.appType === 'speakers'
</script>

<template>
  <CallForSpeakers v-if="isSpeakersMode" />
  <router-view v-else />
</template>
