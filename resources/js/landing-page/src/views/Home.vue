<script setup>
import { useReveal } from "../composables/useReveal";
import Navbar from "../components/Navbar.vue";
import Hero from "../components/Hero.vue";
import CommunityPartners from "../components/CommunityPartners.vue";
import TextMarquee from "../components/ui/TextMarquee.vue";
import Vision from "../components/Vision.vue";
import StatsBar from "../components/StatsBar.vue";
import Speakers from "../components/Speakers.vue";
import Schedule from "../components/Schedule.vue";
import Tickets from "../components/Tickets.vue";
import Gallery from "../components/Gallery.vue";
import Sponsors from "../components/Sponsors.vue";
import Cta from "../components/Cta.vue";
import Footer from "../components/Footer.vue";

useReveal();
</script>

<template>
  <div class="bg-[#031118] text-white font-sans min-h-screen">
    <Navbar />
    <main>
      <Hero />
      <CommunityPartners />
      <TextMarquee />
      <Vision />
      <StatsBar />
      <Speakers />
      <TextMarquee
        :items="[
          'KEYNOTE ADDRESS',
          'ARCHITECTURE TALK',
          'CLOUD TALK',
          'MASTERCLASS WORKSHOP',
          'PANEL DISCUSSION',
          'OPEN SOURCE ECOSYSTEM',
        ]"
      />
      <Schedule />
      <Tickets />
      <Gallery />
      <Sponsors />
      <Cta />
      <Footer />
    </main>
  </div>
</template>