<script setup>
import { useReveal } from "../composables/useReveal";
import Navbar from "../components/Navbar.vue";
import Hero from "../components/Hero.vue";
import CommunityPartners from "../components/CommunityPartners.vue";
import Vision from "../components/Vision.vue";
import CfsHowItWorks from "../components/CfsHowItWorks.vue";
import Cta from "../components/Cta.vue";
import Footer from "../components/Footer.vue";

const formUrl = import.meta.env.VITE_SPEAKER_FORM_URL || "#"

useReveal();
</script>

<template>
  <div class="bg-[#031118] text-white font-sans min-h-screen">
    <Navbar
      :links="[
        { label: 'HOME', href: '#home' },
        { label: 'ABOUT', href: '#about' },
        { label: 'PARTNERS', href: '#partners' },
      ]"
      cta-label="DAFTAR JADI PEMBICARA"
      :cta-href="formUrl"
    />
    <main>
      <Hero
        badge-text="Call for Speakers 2026 · East Java Premier Tech Gathering"
        primary-label="DAFTAR JADI PEMBICARA"
        :primary-href="formUrl"
        secondary-label="KETAHUI LEBIH LANJUT"
        secondary-href="#about"
      />
      <CommunityPartners />
      <Vision />
      <!-- <CfsHowItWorks /> -->
      <Cta
        primary-label="DAFTAR JADI PEMBICARA"
        :primary-href="formUrl"
        secondary-label="JADI PARTNER KOMUNITAS"
        secondary-href="#partners"
      />
      <Footer
        :nav-links="[
          { label: 'Tentang', href: '#about' },
          { label: 'Partners', href: '#partners' },
        ]"
      />
    </main>
  </div>
</template>