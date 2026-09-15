<template>
  <div class="bg-jd-bg text-white font-sans min-h-screen">
    <Navbar backHref="/" />
    <main>
      <slot />
    </main>
    <Footer />
  </div>
</template>

<script setup>
import Navbar from "../Navbar.vue";
import Footer from "../Footer.vue";
</script>
