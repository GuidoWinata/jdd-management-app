<template>
  <Section id="tickets">
    <SectionHeader
      number="04"
      label="Invitation Pass"
      description="Akses eksklusif untuk pembelajaran intensif, networking eksekutif, dan suvenir spesial edisi Maskot Jawa Timur."
    >
      <span class="text-jd-cyan">SELECT</span> YOUR SESSIONS
    </SectionHeader>

    <!-- TICKETS GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <div
        v-for="(ticket, index) in tickets"
        :key="ticket.type"
        :class="[
          'relative rounded-2xl p-8 md:p-10 flex flex-col border transition-all duration-300 hover:-translate-y-1 reveal-scale',
          cardClass(ticket.type),
        ]"
        :style="{ transitionDelay: `${(index % 2) * 0.1}s` }"
      >
        <!-- VIP Ribbon -->
        <div
          v-if="ticket.ribbon"
          class="absolute top-6 -right-10 bg-jd-cyan text-black text-[9px] font-black px-12 py-1.5 uppercase tracking-[0.2em] transform rotate-45 shadow-md"
        >
          {{ ticket.ribbon }}
        </div>

        <!-- Ticket Header -->
        <div class="mb-8">
          <span
            class="text-[10px] tracking-[0.2em] font-bold uppercase block mb-3"
            :class="ticket.type === 'vip' ? 'text-jd-cyan' : 'text-gray-400'"
          >
            {{ ticket.subtitle }}
          </span>
          <h3 class="text-2xl font-black uppercase tracking-wide text-white mb-3">
            {{ ticket.title }}
          </h3>
          <div class="text-4xl md:text-[2.5rem] font-black" :class="priceClass(ticket.type)">
            {{ ticket.price }}
          </div>
        </div>

        <!-- Ticket Features -->
        <ul class="flex-1 space-y-4 mb-10">
          <li v-for="feature in ticket.features" :key="feature" class="flex items-start">
            <svg class="w-5 h-5 text-jd-cyan mr-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span class="text-gray-300 text-sm font-medium leading-relaxed">{{ feature }}</span>
          </li>
        </ul>

        <!-- Action Button -->
        <button
          :class="[
            'w-full py-4 rounded-xl text-[10px] md:text-xs font-bold tracking-[0.2em] uppercase transition-colors duration-300',
            buttonClass(ticket.type),
          ]"
        >
          {{ ticket.buttonText }}
        </button>
      </div>
    </div>
  </Section>
</template>

<script setup>
import Section from './ui/Section.vue'
import SectionHeader from './ui/SectionHeader.vue'
import { tickets } from '../data/content'

const cardClass = (type) =>
  type === 'vip'
    ? 'bg-[#0A252E] border-jd-cyan overflow-hidden shadow-[0_0_30px_rgba(24,188,188,0.1)]'
    : 'bg-[#0B1519] border-gray-800'

const priceClass = (type) => (type === 'vip' ? 'text-jd-cyan' : 'text-white')

const buttonClass = (type) =>
  type === 'vip'
    ? 'bg-jd-cyan text-black hover:bg-jd-cyan-dark'
    : 'bg-[#13232C] text-white hover:bg-[#1C323F] border border-gray-700'
</script>