<template>
  <PageLayout>
    <PageHeader
      titleSolid="KEBIJAKAN PENGEMBALIAN"
      titleOutline="DANA"
      subtitle="Harap baca kebijakan pengembalian dana dengan teliti sebelum melakukan pembelian tiket."
    />
    <RefundPolicy />
  </PageLayout>
</template>

<script setup>
import PageLayout from '../components/ui/PageLayout.vue'
import PageHeader from '../components/PageHeader.vue'
import RefundPolicy from '../components/RefundPolicy.vue'
</script>
