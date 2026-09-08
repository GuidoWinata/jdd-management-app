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
    <div v-if="tickets && tickets.length" class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <div
        v-for="(ticket, index) in tickets"
        :key="ticket.id"
        :class="[
          'relative rounded-2xl p-8 md:p-10 flex flex-col border transition-all duration-300 hover:-translate-y-1 reveal-scale',
          cardClass(ticket.ticket_type),
        ]"
        :style="{ transitionDelay: `${(index % 2) * 0.1}s` }"
      >
        <!-- VIP Ribbon -->
        <div
          v-if="ticket.ticket_type === 'bundle'"
          class="absolute top-6 -right-10 bg-jd-cyan text-black text-[9px] font-black px-12 py-1.5 uppercase tracking-[0.2em] transform rotate-45 shadow-md"
        >
          VIP MERCH
        </div>

        <!-- Ticket Header -->
        <div class="mb-8">
          <span
            class="text-[10px] tracking-[0.2em] font-bold uppercase block mb-3"
            :class="ticket.ticket_type === 'bundle' ? 'text-jd-cyan' : 'text-gray-400'"
          >
            {{ (ticket.label || 'TBA').toUpperCase() }}
          </span>
          <h3 class="text-2xl font-black uppercase tracking-wide text-white mb-3">
            {{ ticket.name.toUpperCase() }} PASS
          </h3>
          <div class="text-4xl md:text-[2.5rem] font-black" :class="priceClass(ticket.ticket_type)">
            <span v-if="ticket.price === 0">TBA</span>
            <template v-else>
              <span class="text-lg md:text-xl align-top">Rp</span>
              {{ formatRupiah(ticket.price) }}
            </template>
          </div>
        </div>

        <!-- Ticket Features -->
        <ul class="flex-1 space-y-4 mb-10">
          <li v-for="(feature, fi) in (ticket.benefits || [])" :key="fi" class="flex items-start">
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
            buttonClass(ticket.ticket_type),
          ]"
        >
          {{ ticket.cta_label || 'Beli Tiket' }}
        </button>
      </div>
    </div>
  </Section>
</template>

<script setup>
import Section from './ui/Section.vue'
import SectionHeader from './ui/SectionHeader.vue'
import { useTickets } from '../composables/useEventData'

const tickets = useTickets()

function formatRupiah(value) {
  return new Intl.NumberFormat('id-ID', {
    style: 'decimal',
    maximumFractionDigits: 0,
  }).format(value)
}

const cardClass = (type) =>
  type === 'bundle'
    ? 'bg-[#0A252E] border-jd-cyan overflow-hidden shadow-[0_0_30px_rgba(24,188,188,0.1)]'
    : 'bg-[#0B1519] border-gray-800'

const priceClass = (type) => (type === 'bundle' ? 'text-jd-cyan' : 'text-white')

const buttonClass = (type) =>
  type === 'bundle'
    ? 'bg-jd-cyan text-black hover:bg-jd-cyan-dark'
    : 'bg-[#13232C] text-white hover:bg-[#1C323F] border border-gray-700'
</script>
