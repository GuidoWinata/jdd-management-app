<template>
    <div class="bg-jd-bg text-white font-sans min-h-screen">
        <Navbar backHref="/" />
        <main>
            <PageHeader
                titleSolid="Frequently Asked Question"
                subtitle="Punya pertanyaan tentang Jatim Developer Day? Temukan jawabannya di sini. Jika tidak menemukan jawaban yang dicari, jangan ragu untuk menghubungi kami."
            />
            <Faq />
        </main>
        <Footer />
    </div>
</template>

<script setup>
import Navbar from "../components/Navbar.vue";
import PageHeader from "../components/PageHeader.vue";
import Faq from "../components/Faq.vue";
import Footer from "../components/Footer.vue";
</script>
