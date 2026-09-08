<template>
  <div class="bg-[#031118] text-white font-sans min-h-screen">
    <Navbar backHref="/" />
    <main>
      <PageHeader
        titleSolid="PERTANYAAN"
        titleOutline="UMUM"
        subtitle="Temukan jawaban atas pertanyaan yang sering diajukan seputar Jatim Developer Day."
      />
      <Faq />
    </main>
    <Footer />
  </div>
</template>

<script setup>
import Navbar from '../components/Navbar.vue'
import PageHeader from '../components/PageHeader.vue'
import Faq from '../components/Faq.vue'
import Footer from '../components/Footer.vue'
</script>
