<template>
    <PageLayout>
        <PageHeader
            titleSolid="Frequently Asked Question"
            subtitle="Punya pertanyaan tentang Jatim Developer Day? Temukan jawabannya di sini. Jika tidak menemukan jawaban yang dicari, jangan ragu untuk menghubungi kami."
        />
        <Faq />
    </PageLayout>
</template>

<script setup>
import PageLayout from "../components/ui/PageLayout.vue";
import PageHeader from "../components/PageHeader.vue";
import Faq from "../components/Faq.vue";
</script>
