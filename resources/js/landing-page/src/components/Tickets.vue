<template>
    <Section id="tickets" variant="white">
        <SectionHeader
            number="05"
            label="Invitation Pass"
            headline-class="text-3xl sm:text-5xl md:text-6xl font-semibold leading-[1.1] max-w-5xl mx-auto"
            description-class="text-gray-600 text-sm md:text-base max-w-4xl mx-auto lg:mb-12 mt-5 leading-relaxed"
            description="Akses eksklusif untuk pembelajaran intensif, networking eksekutif, dan souvenir spesial edisi Maskot JDD 2026."
        >
            Select Your Sessions
        </SectionHeader>

        <!-- TICKETS GRID -->
        <div
            v-if="tickets && tickets.length"
            class="flex flex-wrap justify-center gap-8"
        >
            <div
                v-for="(ticket, index) in tickets"
                :key="ticket.id"
                :class="[
                    'relative rounded-2xl p-8 md:p-10 flex flex-col border transition-all duration-300 hover:-translate-y-1 reveal-scale',
                    cardClass(ticket.ticket_type, ticket.is_sold_out),
                ]"
                :style="{ transitionDelay: `${(index % 2) * 0.1}s` }"
            >
                <!-- Bundle Ribbon -->
                <div
                    v-if="ticket.ticket_type === 'bundle'"
                    class="absolute top-6 -right-10 bg-jd-cyan text-jd-on-cyan text-[9px] font-black px-12 py-1.5 uppercase tracking-[0.2em] transform rotate-45 shadow-md"
                >
                    EXCLUSIVE
                </div>

                <!-- Sold Out Ribbon -->
                <div
                    v-if="ticket.is_sold_out"
                    class="absolute top-6 -right-10 bg-red-500 text-white text-[9px] font-black px-12 py-1.5 uppercase tracking-[0.2em] transform rotate-45 shadow-md"
                >
                    SOLD OUT
                </div>

                <!-- Ticket Header -->
                <div class="mb-8">
                    <span
                        class="text-[10px] tracking-[0.2em] font-bold uppercase block mb-3"
                        :class="
                            ticket.ticket_type === 'bundle'
                                ? 'text-jd-cyan'
                                : 'text-gray-500'
                        "
                    >
                        {{ (ticket.label || "TBA").toUpperCase() }}
                    </span>
                    <h3
                        class="text-2xl font-bold uppercase tracking-wide mb-3"
                        :class="
                            ticket.ticket_type === 'bundle'
                                ? 'text-white'
                                : 'text-gray-900'
                        "
                    >
                        {{ ticket.name.toUpperCase() }}
                    </h3>
                    <div
                        class="text-4xl md:text-[2.5rem] font-semibold text-jd-dark"
                        :class="
                            ticket.ticket_type === 'bundle'
                                ? 'text-white'
                                : 'text-gray-900'
                        "
                    >
                        <span v-if="ticket.price === 0">TBA</span>
                        <template v-else>
                            <span class="text-lg md:text-xl align-top">Rp</span>
                            {{ formatRupiah(ticket.price) }}
                        </template>
                    </div>
                </div>

                <!-- Ticket Features -->
                <ul class="flex-1 space-y-4 mb-10">
                    <li
                        v-for="(feature, fi) in ticket.benefits || []"
                        :key="fi"
                        class="flex items-start"
                    >
                        <PhCheck
                            :size="20"
                            :weight="'bold'"
                            class="mr-4 flex-shrink-0 mt-0.5"
                            :class="
                                ticket.ticket_type === 'bundle'
                                    ? 'text-jd-cyan'
                                    : 'text-gray-900'
                            "
                        />
                        <span
                            class="text-sm font-medium leading-relaxed"
                            :class="
                                ticket.ticket_type === 'bundle'
                                    ? 'text-white'
                                    : 'text-gray-700'
                            "
                        >
                            {{ feature }}
                        </span>
                    </li>
                </ul>

                <!-- Action Button -->
                <a
                    v-if="ticket.cta_url && !ticket.is_sold_out"
                    :href="ticket.cta_url"
                    target="_blank"
                    rel="noopener noreferrer"
                    :class="[
                        'w-full py-4 rounded-xl text-[10px] md:text-xs font-bold tracking-[0.2em] uppercase transition-colors duration-300 text-center block',
                        buttonClass(ticket.ticket_type),
                    ]"
                >
                    {{ ticket.cta_label || "Beli Tiket" }}
                </a>
                <button
                    v-else-if="ticket.is_sold_out"
                    disabled
                    class="w-full py-4 rounded-xl text-[10px] md:text-xs font-bold tracking-[0.2em] uppercase bg-gray-200 text-gray-400 cursor-not-allowed"
                >
                    SOLD OUT
                </button>
                <button
                    v-else
                    :class="[
                        'w-full py-4 rounded-xl text-[10px] md:text-xs font-bold tracking-[0.2em] uppercase transition-colors duration-300',
                        buttonClass(ticket.ticket_type),
                    ]"
                >
                    {{ ticket.cta_label || "Beli Tiket" }}
                </button>
            </div>
        </div>
    </Section>
</template>

<script setup>
import Section from "./ui/Section.vue";
import SectionHeader from "./ui/SectionHeader.vue";
import { PhCheck } from "@phosphor-icons/vue";
import { useTickets } from "../composables/useEventData";

const tickets = useTickets();

function formatRupiah(value) {
    return new Intl.NumberFormat("id-ID", {
        style: "decimal",
        maximumFractionDigits: 0,
    }).format(value);
}

// Logika Kelas Dinamis Berdasarkan Tipe Tiket
const cardClass = (type, isSoldOut) => {
    if (isSoldOut) return "bg-gray-50 border-gray-200 opacity-75";
    return type === "bundle"
        ? "bg-jd-dark border-transparent shadow-2xl"
        : "bg-white border-gray-200 shadow-xl";
};

const priceClass = (type) =>
    type === "bundle" ? "text-jd-cyan" : "text-gray-900";

const buttonClass = (type) =>
    type === "bundle"
        ? "bg-jd-cyan text-jd-on-cyan hover:brightness-110"
        : "bg-gray-900 text-white hover:bg-gray-800";
</script>
