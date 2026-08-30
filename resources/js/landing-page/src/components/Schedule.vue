<template>
  <Section id="agenda">
    <SectionHeader
      number="03"
      label="The Symposium"
      description="Agenda lengkap symposium dari registrasi hingga sesi workshop bersama para praktisi industri."
    >
      AGENDA & <span class="text-jd-cyan">SESSIONS</span>
    </SectionHeader>

    <!-- AGENDA LIST -->
    <div class="flex flex-col gap-8">
      <div v-for="group in agendaGroups" :key="group.category" class="flex flex-col">
        <!-- Category Bar -->
        <div class="bg-jd-cyan text-black font-bold text-xs tracking-[0.2em] uppercase py-3 px-6 rounded-md mb-2">
          {{ group.category }}
        </div>

        <!-- Session Items -->
        <div class="flex flex-col">
          <div
            v-for="(session, sessionIndex) in group.sessions"
            :key="sessionIndex"
            class="flex flex-col md:flex-row items-start md:items-center py-6 px-4 md:px-6 border-b border-gray-900 hover:bg-[#030d12] transition-colors duration-300 gap-6 reveal"
            :style="{ transitionDelay: `${(sessionIndex % 3) * 0.1}s` }"
          >
            <!-- Left: Time & Location -->
            <div class="w-full md:w-1/4 flex flex-col md:text-right flex-shrink-0">
              <span class="text-jd-cyan font-medium tracking-wider text-sm md:text-base">
                {{ session.time }}
              </span>
              <span class="text-gray-500 text-[10px] tracking-[0.15em] uppercase mt-1.5 font-semibold">
                {{ session.location }}
              </span>
            </div>

            <!-- Middle: Session Details -->
            <div class="w-full md:w-auto flex-1 flex flex-col">
              <span class="text-gray-500 text-[10px] tracking-[0.15em] uppercase mb-1.5 font-bold">
                {{ session.type }}
              </span>
              <h3 class="text-white font-bold text-lg md:text-xl leading-tight">
                {{ session.title }}
              </h3>
              <span v-if="session.speaker" class="text-gray-400 text-xs mt-2 font-medium">
                {{ session.speaker }}
              </span>
            </div>

            <!-- Right: Speaker Thumbnail -->
            <div class="hidden md:flex w-16 flex-shrink-0 justify-end">
              <div class="w-12 h-12 rounded-xl bg-gray-800 border border-gray-700 overflow-hidden relative">
                <div class="absolute inset-0 bg-gray-600/50 mix-blend-luminosity"></div>
                <svg class="w-full h-full text-gray-500 opacity-50 p-2" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- DOWNLOAD BUTTON -->
    <div class="mt-16 flex justify-center reveal-scale">
      <AppButton variant="outline-fill">
        Download Rundown
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
        </svg>
      </AppButton>
    </div>
  </Section>
</template>

<script setup>
import Section from './ui/Section.vue'
import SectionHeader from './ui/SectionHeader.vue'
import AppButton from './ui/AppButton.vue'
import { agendaGroups } from '../data/content'
</script>