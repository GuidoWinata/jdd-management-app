<template>
  <section class="bg-[#020b10] py-20 px-6 font-sans">
    <div class="container mx-auto max-w-4xl">
      
      <!-- List FAQ -->
      <div class="flex flex-col gap-4">
        <div 
          v-for="(faq, index) in faqs" 
          :key="index"
          class="bg-[#05141e] border border-[#0a2333] rounded-md border-l-[4px] border-l-[#547b97] overflow-hidden"
        >
          <!-- Header (Pertanyaan) -->
          <button 
            @click="toggleFaq(index)"
            class="w-full flex items-center justify-start text-left p-5 focus:outline-none hover:bg-[#071c29] transition-colors duration-300"
          >
            <!-- Icon Chevron -->
            <svg 
              class="w-4 h-4 text-white mr-4 transform transition-transform duration-300 flex-shrink-0"
              :class="activeIndex === index ? 'rotate-180' : 'rotate-0'"
              fill="none" 
              stroke="currentColor" 
              viewBox="0 0 24 24"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
            </svg>
            
            <span class="text-white font-bold text-sm md:text-base">
              {{ faq.question }}
            </span>
          </button>

          <!-- Body (Jawaban) dengan Animasi CSS Grid -->
          <div 
            class="grid transition-all duration-300 ease-in-out"
            :class="activeIndex === index ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'"
          >
            <div class="overflow-hidden">
              <div class="p-5 pt-0 pl-13 text-[#8ba7b8] text-sm md:text-sm leading-relaxed">
                {{ faq.answer }}
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue';

const activeIndex = ref(0);

const toggleFaq = (index) => {
  activeIndex.value = activeIndex.value === index ? null : index;
};

const faqs = ref([
  {
    question: 'Apa itu Jatim Developer Day?',
    answer: 'Jatim Developer Day adalah event teknologi di Jawa Timur yang bertujuan membangun ekosistem IT melalui komunitas. Event ini menghadirkan speaker ahli dari berbagai bidang teknologi dan dihadiri peserta dari berbagai latar belakang IT.'
  },
  {
    question: 'Apa saja jenis acara di Jatim Developer Day?',
    answer: 'Acara mencakup Keynote Sessions, Architecture Talks, Masterclass Workshops, dan sesi Networking yang didesain untuk memperdalam pengetahuan teknis serta memperluas koneksi profesional Anda di industri.'
  },
  {
    question: 'Siapa yang bisa mengikuti Jatim Developer Day?',
    answer: 'Event ini terbuka untuk Software Engineers, Tech Leads, CTOs, Data Scientists, Mahasiswa IT, dan siapa saja yang antusias terhadap perkembangan teknologi dan pengembangan perangkat lunak.'
  },
  {
    question: 'Di mana event diselenggarakan?',
    answer: 'Jatim Developer Day 2026 akan diselenggarakan di Heritage Convention Center, Pasuruan, Jawa Timur. Informasi detail mengenai akses dan rute dapat dilihat pada halaman lokasi.'
  },
  {
    question: 'Apa saja yang akan saya dapatkan dari acara ini?',
    answer: 'Anda akan mendapatkan insight mendalam dari para praktisi global, kesempatan networking dengan ratusan developer, e-certificate, makan siang, coffee break, serta merchandise eksklusif (tergantung kategori tiket).'
  },
  {
    question: 'Bagaimana cara mendaftar?',
    answer: 'Pendaftaran dapat dilakukan langsung melalui website ini dengan menekan tombol "Beli Tiket". Pilih kategori tiket yang Anda inginkan dan selesaikan pembayaran melalui sistem kami.'
  },
  {
    question: 'Apakah acara menyediakan makan dan minum?',
    answer: 'Ya, seluruh peserta yang memiliki tiket valid akan mendapatkan fasilitas makan siang dan coffee break selama acara berlangsung.'
  },
  {
    question: 'Bagaimana jika saya tidak bisa hadir setelah mendaftar?',
    answer: 'Tiket yang sudah dibeli tidak dapat di-refund. Namun, Anda dapat memindahtangankan (transfer) tiket Anda kepada orang lain maksimal H-3 sebelum acara tanpa biaya tambahan.'
  },
  {
    question: 'Apakah ada kesempatan untuk menjadi speaker atau volunteer?',
    answer: 'Tentu! Kami membuka pendaftaran untuk Call for Papers (Speakers) dan Volunteer beberapa bulan sebelum acara dimulai. Pantau terus sosial media kami untuk informasi pembukaannya.'
  }
]);
</script>

<style scoped>
.pl-13 {
  padding-left: 3.25rem;
}
</style>
