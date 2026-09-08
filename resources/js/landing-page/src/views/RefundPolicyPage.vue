<template>
  <div class="bg-[#031118] text-white font-sans min-h-screen">
    <Navbar backHref="/" />
    <main>
      <PageHeader
        titleSolid="KEBIJAKAN PENGEMBALIAN"
        titleOutline="DANA"
        subtitle="Harap baca kebijakan pengembalian dana dengan teliti sebelum melakukan pembelian tiket."
      />
      <RefundPolicy />
    </main>
    <Footer />
  </div>
</template>

<script setup>
import Navbar from '../components/Navbar.vue'
import PageHeader from '../components/PageHeader.vue'
import RefundPolicy from '../components/RefundPolicy.vue'
import Footer from '../components/Footer.vue'
</script>
