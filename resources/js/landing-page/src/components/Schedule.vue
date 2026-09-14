<template>
    <Section id="agenda">
        <SectionHeader
            number="04"
            label="The Symposium"
            headline-class="text-5xl md:text-6xl font-semibold leading-[1.1] max-w-5xl mx-auto"
            description-class="text-gray-600 text-sm md:text-base max-w-3xl mx-auto mb-12 mt-5 leading-relaxed"
            description="Agenda lengkap symposium dari registrasi hingga sesi workshop bersama para praktisi industri."
        >
            Agenda & Sessions
        </SectionHeader>

        <!-- LOADING STATE -->
        <div v-if="!agendaGroups" class="flex flex-col gap-8 mt-10">
            <div v-for="i in 3" :key="i" class="flex flex-col animate-pulse">
                <div
                    class="bg-gray-800 text-transparent font-bold text-xs tracking-[0.2em] uppercase py-4 px-6 rounded-xl md:rounded-2xl mb-2 w-full md:w-1/3"
                >
                    Loading...
                </div>
                <div class="flex flex-col">
                    <div
                        v-for="j in 3"
                        :key="j"
                        class="flex flex-col md:flex-row items-start md:items-center py-6 px-4 md:px-6 border-b border-gray-800/50 gap-6"
                    >
                        <div
                            class="w-full md:w-1/4 flex flex-col md:text-right flex-shrink-0 gap-2"
                        >
                            <div
                                class="h-4 bg-gray-800 rounded w-32 ml-auto"
                            ></div>
                            <div
                                class="h-3 bg-gray-800 rounded w-24 ml-auto"
                            ></div>
                        </div>
                        <div
                            class="w-full md:w-auto flex-1 flex flex-col gap-2"
                        >
                            <div class="h-3 bg-gray-800 rounded w-32"></div>
                            <div class="h-5 bg-gray-800 rounded w-64"></div>
                        </div>
                        <div
                            class="hidden md:block w-14 h-14 rounded-xl bg-gray-800 ml-auto"
                        ></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- EMPTY STATE -->
        <div
            v-else-if="agendaGroups.length === 0"
            class="text-center py-12 mt-10"
        >
            <p class="text-gray-500 font-mono tracking-widest uppercase">
                Jadwal belum tersedia.
            </p>
        </div>

        <!-- AGENDA LIST -->
        <div v-else class="flex flex-col gap-10 mt-10">
            <div
                v-for="(group, groupIndex) in agendaGroups"
                :key="group.category"
                class="flex flex-col"
            >
                <!-- Category Bar (Solid Neon) -->
                <div
                    class="bg-jd-cyan text-jd-on-cyan font-semibold text-xs md:text-sm tracking-widest uppercase py-3.5 px-6 rounded-xl md:rounded-2xl mb-2 shadow-sm"
                >
                    {{ group.category }}
                </div>

                <!-- Session Items -->
                <div class="flex flex-col">
                    <div
                        v-for="(session, sessionIndex) in group.sessions"
                        :key="sessionIndex"
                        class="flex flex-col md:flex-row items-start md:items-center py-6 px-4 md:px-6 border-b border-white/10 hover:bg-gray-200 transition-colors duration-300 gap-6 reveal group"
                        :style="{
                            transitionDelay: `${(sessionIndex % 3) * 0.1}s`,
                        }"
                    >
                        <!-- Left: Time & Location -->
                        <div
                            class="w-1/5 flex flex-col md:text-right flex-shrink-0"
                        >
                            <span
                                class="text-jd-dark font-medium tracking-wider text-sm md:text-base"
                            >
                                {{ session.time }}
                            </span>
                            <span
                                class="text-gray-500 text-[10px] tracking-[0.15em] uppercase mt-1.5 font-bold"
                            >
                                {{ session.location }}
                            </span>
                        </div>

                        <!-- Middle: Session Details -->
                        <div class="w-full md:w-auto flex-1 flex flex-col">
                            <span
                                class="text-gray-500 text-[10px] tracking-[0.15em] uppercase mb-1.5 font-bold"
                            >
                                {{ session.type }}
                            </span>
                            <h3
                                class="text-jd-dark font-bold text-base md:text-lg leading-snug transition-colors"
                            >
                                {{ session.title }}
                            </h3>
                            <span
                                v-if="session.speaker"
                                class="text-gray-500 text-xs mt-1.5 font-medium"
                            >
                                {{ session.speaker }}
                            </span>
                        </div>

                        <!-- Right: Speaker Thumbnail (Solid Neon Box) -->
                        <div class="hidden md:flex flex-shrink-0 justify-end">
                            <div
                                class="w-14 h-14 md:w-16 md:h-16 rounded-xl bg-jd-cyan overflow-hidden relative shadow-md flex items-center justify-center"
                            >
                                <!-- Jika ada foto speaker -->
                                <img
                                    v-if="session.speaker_photo"
                                    :src="session.speaker_photo"
                                    :alt="session.speaker"
                                    class="w-full h-full object-cover object-bottom"
                                />
                                <!-- Fallback Icon jika tidak ada foto -->
                                <PhUser
                                    v-else
                                    class="text-jd-on-cyan opacity-50"
                                    :size="28"
                                    weight="fill"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </Section>
</template>

<script setup>
import Section from "./ui/Section.vue";
import SectionHeader from "./ui/SectionHeader.vue";
import { PhUser } from "@phosphor-icons/vue";
import { useSchedule } from "../composables/useEventData";

// Mengambil data jadwal dari composable
const agendaGroups = useSchedule();
</script>
