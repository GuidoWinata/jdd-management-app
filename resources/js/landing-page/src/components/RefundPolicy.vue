<template>
  <section class="bg-[#020b10] text-white py-10 px-6 font-sans">
    <div class="container mx-auto max-w-6xl flex flex-col md:flex-row gap-8 items-start">
      
      <!-- SIDEBAR NAVIGATION -->
      <aside class="w-full md:w-1/4 sticky top-24 shrink-0 z-10">
        <div class="bg-[#061621] border border-[#0d283b] rounded-2xl p-4 flex flex-col gap-2 shadow-lg">
          <a 
            v-for="(menu, index) in policies" 
            :key="index"
            :href="'#policy-' + index"
            @click="activeMenu = index"
            :class="[
              'px-4 py-3 rounded-xl text-sm font-medium transition-colors duration-300',
              activeMenu === index 
                ? 'bg-[#0d283b] text-white' 
                : 'text-[#6b8b9d] hover:text-white hover:bg-[#0a1e2d]'
            ]"
          >
            {{ menu.shortTitle }}
          </a>
        </div>
      </aside>

      <!-- POLICY CARDS CONTENT -->
      <div class="w-full md:w-3/4 flex flex-col gap-6">
        <div 
          v-for="(policy, index) in policies" 
          :key="index"
          :id="'policy-' + index"
          class="bg-[#061621] border border-[#0d283b] rounded-2xl p-6 md:p-8 shadow-md scroll-mt-28"
        >
          <!-- Card Header / Title -->
          <h3 class="text-lg md:text-xl font-bold text-white mb-4 flex items-center gap-3">
            <svg class="w-4 h-4 text-[#6b8b9d] transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
            {{ policy.title }}
          </h3>

          <!-- Card Content / Body -->
          <div class="text-[#8ba7b8] text-sm md:text-base leading-relaxed pl-7">
            <!-- Deskripsi Utama (jika ada) -->
            <p v-if="policy.description" class="mb-3">
              {{ policy.description }}
            </p>

            <!-- Bullet Points -->
            <ul v-if="policy.bullets && policy.bullets.length" class="list-none space-y-2 mb-4">
              <li v-for="(bullet, bIndex) in policy.bullets" :key="bIndex" class="flex items-start">
                <span class="mr-2 text-[#18BCBC]">-</span>
                <span>{{ bullet }}</span>
              </li>
            </ul>

            <!-- Box Khusus / Sub-konten (Format Transfer) -->
            <div v-if="policy.formatBox" class="mt-4 p-4 border border-[#0d283b] rounded-xl bg-[#030d14]">
              <p class="font-medium text-white mb-2">Format Transfer:</p>
              <ul class="space-y-1 text-sm text-[#8ba7b8]">
                <li>Nama asal: [Nama pembeli tiket asli]</li>
                <li>Pemegang tiket: [Nama orang yang akan hadir]</li>
              </ul>
            </div>

            <!-- Box Peringatan Khusus (Ketentuan Khusus) -->
            <div v-if="policy.warningBox" class="mt-6 p-4 border border-[#3b2a1a] rounded-xl bg-[#1c130b]">
              <p class="font-bold text-[#e6a23c] mb-2 flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                Peringatan Penting
              </p>
              <p class="text-sm text-[#d4bca4]">
                {{ policy.warningBox }}
              </p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue';

// State untuk melacak menu aktif di sidebar
const activeMenu = ref(0);

// Data kebijakan sesuai teks di dalam gambar
const policies = ref([
  {
    shortTitle: 'Kebijakan Umum',
    title: '1. Kebijakan Umum',
    description: 'Dengan membeli tiket melalui platform Jatim Developer Day, peserta memahami dan menyetujui bahwa:',
    bullets: [
      'Tidak ada pengembalian dana dalam kondisi apapun',
      'Semua penjualan tiket bersifat final',
      'Peserta bertanggung jawab penuh atas keputusan pembelian',
      'Kebijakan ini berlaku untuk semua kategori tiket (Early Bird, Regular, Student)'
    ]
  },
  {
    shortTitle: 'Pembatalan oleh Peserta',
    title: '2. Pembatalan oleh Peserta',
    description: 'Tidak ada pengembalian dana untuk kasus:',
    bullets: [
      'Berhalangan hadir karena alasan pribadi',
      'Perubahan jadwal pribadi atau konflik agenda',
      'Kondisi darurat atau sakit mendadak',
      'Salah pilih kategori tiket atau sesi workshop',
      'Ketidakpuasan terhadap speaker atau materi',
      'Kondisi apapun yang berasal dari peserta'
    ]
  },
  {
    shortTitle: 'Pembatalan Penyelenggara',
    title: '3. Pembatalan oleh Penyelenggara',
    description: 'Pengecualian khusus hanya berlaku jika: Event dibatalkan total. Peserta mendapat pengembalian dana senilai tiket untuk event Jatim Developer Day lainnya maksimal dalam 12 hari kerja.',
    bullets: []
  },
  {
    shortTitle: 'Force Majeure & Keadaan Darurat',
    title: '4. Force Majeure & Keadaan Darurat',
    description: 'Jika event tidak dapat dilaksanakan karena:',
    bullets: [
      'Bencana alam (gempa, banjir, dll)',
      'Pandemi atau kebijakan pemerintah',
      'Kondisi darurat nasional/regional',
      'Masalah teknis venue yang tidak dapat diatasi'
    ]
  },
  {
    shortTitle: 'Transfer Tiket',
    title: '5. Transfer Tiket',
    description: 'Transfer tiket ke orang lain diperbolehkan maksimal H-3 (3 hari sebelum event). GRATIS tanpa biaya administrasi. Transfer hanya sekali, tidak bisa ditransfer lagi.',
    bullets: [],
    formatBox: true
  },
  {
    shortTitle: 'Ketentuan Khusus',
    title: '6. Ketentuan Khusus',
    description: '',
    bullets: [
      'Tiket student dengan harga khusus tetap berlaku kebijakan no refund',
      'Tiket gratis atau complimentary tidak berlaku sistem pengembalian',
      'Workshop premium atau add-on session mengikuti kebijakan yang sama',
      'Platform tidak bertanggung jawab atas biaya perjalanan atau akomodasi peserta'
    ],
    warningBox: 'Harap baca dengan seksama detail event, jadwal, dan lokasi sebelum membeli tiket. Pembelian tiket dianggap sebagai persetujuan penuh terhadap kebijakan no refund ini.'
  }
]);
</script>

<style scoped>
html {
  scroll-behavior: smooth;
}
</style>