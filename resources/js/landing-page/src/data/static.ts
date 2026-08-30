import type { Event, EventSection, Speaker, Material, AgendaGroup, AgendaItem, Ticket, Merchandise, Partner } from '../api/types'

export const staticEvent: Event = {
  id: 1,
  name: 'Jatim Developer Day 2024',
  slug: 'jatim-developer-day-2024',
  description: 'Developer conference terbesar di Jawa Timur',
  start_date: '2024-11-15',
  end_date: '2024-11-16',
  location: 'Surabaya',
  venue: 'Grand Heritage Hotel',
  status: 'upcoming',
  is_active: true,
  created_at: '2024-01-01T00:00:00Z',
  updated_at: '2024-01-01T00:00:00Z'
}

export const staticSections: EventSection[] = [
  {
    id: 1,
    event_id: 1,
    name: 'About',
    slug: 'about',
    content: '<p>Jatim Developer Day adalah konferensi developer terbesar di Jawa Timur.</p>',
    order: 1,
    is_active: true,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  },
  {
    id: 2,
    event_id: 1,
    name: 'Venue',
    slug: 'venue',
    content: '<p>Grand Heritage Hotel, Surabaya</p>',
    order: 2,
    is_active: true,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  }
]

export const staticSpeakers: Speaker[] = [
  {
    id: 1,
    event_id: 1,
    event_name: 'Jatim Developer Day 2024',
    name: 'Ainun Najib',
    bio: 'Tech leader dengan pengalaman di bidang data dan AI.',
    company: 'Tarsquare',
    job_title: 'Tech Leader & Data Innovator',
    photo_path: null,
    speaker_group: 'keynote',
    is_active: 1,
    sort_order: 1
  },
  {
    id: 2,
    event_id: 1,
    event_name: 'Jatim Developer Day 2024',
    name: 'Zain Fathoni',
    bio: 'Software engineer dengan fokus pada mobile development.',
    company: 'Tarsquare',
    job_title: 'Software Engineer',
    photo_path: null,
    speaker_group: 'keynote',
    is_active: 1,
    sort_order: 2
  },
  {
    id: 3,
    event_id: 1,
    event_name: 'Jatim Developer Day 2024',
    name: 'Listiarso Wastuargo',
    bio: 'Tech professional dengan pengalaman di berbagai industri.',
    company: 'Tarsquare',
    job_title: 'Tech Professional',
    photo_path: null,
    speaker_group: 'keynote',
    is_active: 1,
    sort_order: 3
  },
  {
    id: 4,
    event_id: 1,
    event_name: 'Jatim Developer Day 2024',
    name: 'Dewi Lestari',
    bio: 'Platform engineer dengan keahlian di Kubernetes dan cloud.',
    company: 'Gojek',
    job_title: 'Platform Engineer',
    photo_path: null,
    speaker_group: 'lightning',
    is_active: 0,
    sort_order: 4
  },
  {
    id: 5,
    event_id: 1,
    event_name: 'Jatim Developer Day 2024',
    name: 'Budi Santoso',
    bio: 'Cloud architect dengan sertifikasi AWS.',
    company: 'AWS',
    job_title: 'Cloud Architect',
    photo_path: null,
    speaker_group: 'workshop',
    is_active: 0,
    sort_order: 5
  },
  {
    id: 6,
    event_id: 1,
    event_name: 'Jatim Developer Day 2024',
    name: 'Rina Wijaya',
    bio: 'Frontend engineer dengan fokus pada Vue.js dan React.',
    company: 'Tokopedia',
    job_title: 'Frontend Engineer',
    photo_path: null,
    speaker_group: 'lightning',
    is_active: 0,
    sort_order: 6
  }
]

export const staticMaterials: Material[] = [
  {
    id: 1,
    event_id: 1,
    speaker_id: 1,
    title: 'Data Innovation in Modern Tech',
    description: 'Membahas inovasi data di era modern.',
    type: 'keynote',
    file_url: null,
    video_url: null,
    slide_url: null,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  },
  {
    id: 2,
    event_id: 1,
    speaker_id: 2,
    title: 'Mobile Development Best Practices',
    description: 'Best practices dalam pengembangan aplikasi mobile.',
    type: 'keynote',
    file_url: null,
    video_url: null,
    slide_url: null,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  }
]

export const staticAgendaGroups: AgendaGroup[] = [
  {
    id: 1,
    event_id: 1,
    name: 'Main Hall',
    slug: 'main-hall',
    description: 'Aula utama untuk sesi keynote',
    location: 'Grand Heritage Ballroom',
    order: 1,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  },
  {
    id: 2,
    event_id: 1,
    name: 'Room A',
    slug: 'room-a',
    description: 'Ruang untuk workshop',
    location: 'Room A - 2nd Floor',
    order: 2,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  }
]

export const staticAgendaItems: AgendaItem[] = [
  {
    id: 1,
    event_id: 1,
    agenda_group_id: 1,
    material_id: 1,
    title: 'Registration & Welcome Coffee',
    description: 'Pendaftaran dan kopi pagi',
    start_time: '08:00:00',
    end_time: '09:00:00',
    order: 1,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  },
  {
    id: 2,
    event_id: 1,
    agenda_group_id: 1,
    material_id: 1,
    title: 'Opening Keynote - Data Innovation',
    description: 'Keynote tentang inovasi data',
    start_time: '09:00:00',
    end_time: '10:00:00',
    order: 2,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  },
  {
    id: 3,
    event_id: 1,
    agenda_group_id: 1,
    material_id: 2,
    title: 'Mobile Development Session',
    description: 'Sesi tentang mobile development',
    start_time: '10:15:00',
    end_time: '11:15:00',
    order: 3,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  }
]

export const staticTickets: Ticket[] = [
  {
    id: 1,
    event_id: 1,
    name: 'Regular Ticket',
    slug: 'regular-ticket',
    description: 'Tiket reguler untuk akses penuh acara',
    price: 150000,
    ticket_type: 'single',
    capacity: 500,
    sold: 120,
    benefits: ['Akses semua sesi', 'Snack dan makan siang', 'Merchandise kit'],
    is_active: true,
    order: 1,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  },
  {
    id: 2,
    event_id: 1,
    name: 'VIP Ticket',
    slug: 'vip-ticket',
    description: 'Tiket VIP dengan keuntungan eksklusif',
    price: 350000,
    ticket_type: 'single',
    capacity: 50,
    sold: 30,
    benefits: ['Akses semua sesi', 'Snack dan makan siang', 'Merchandise eksklusif', 'Meet & greet dengan speaker', 'Reserved seating'],
    is_active: true,
    order: 2,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  }
]

export const staticMerchandises: Merchandise[] = [
  {
    id: 1,
    event_id: 1,
    name: 'JDD T-Shirt 2024',
    slug: 'jdd-tshirt-2024',
    description: 'Kaos eksklusif JDD 2024',
    price: 75000,
    image: null,
    stock: 200,
    is_active: true,
    order: 1,
    link: null,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  },
  {
    id: 2,
    event_id: 1,
    name: 'JDD Sticker Pack',
    slug: 'jdd-sticker-pack',
    description: 'Paket stiker JDD',
    price: 25000,
    image: null,
    stock: 500,
    is_active: true,
    order: 2,
    link: null,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  }
]

export const staticPartners: Partner[] = [
  {
    id: 1,
    event_id: 1,
    name: 'Tarsquare',
    slug: 'tarsquare',
    description: 'Technology partner',
    logo: null,
    website: 'https://tarsquare.com',
    partner_type: 'sponsor',
    sponsor_category: 'gold',
    order: 1,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  },
  {
    id: 2,
    event_id: 1,
    name: 'Gojek',
    slug: 'gojek',
    description: 'Super app partner',
    logo: null,
    website: 'https://gojek.com',
    partner_type: 'sponsor',
    sponsor_category: 'silver',
    order: 2,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  },
  {
    id: 3,
    event_id: 1,
    name: 'AWS',
    slug: 'aws',
    description: 'Cloud partner',
    logo: null,
    website: 'https://aws.amazon.com',
    partner_type: 'sponsor',
    sponsor_category: 'bronze',
    order: 3,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  },
  {
    id: 4,
    event_id: 1,
    name: 'Bangkalan Dev',
    slug: 'bangkalan-dev',
    description: 'Community partner dari Bangkalan',
    logo: null,
    website: null,
    partner_type: 'community_partner',
    sponsor_category: null,
    order: 4,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  },
  {
    id: 5,
    event_id: 1,
    name: 'PasuruanDev',
    slug: 'pasuruandev',
    description: 'Community partner dari Pasuruan',
    logo: null,
    website: null,
    partner_type: 'community_partner',
    sponsor_category: null,
    order: 5,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  },
  {
    id: 6,
    event_id: 1,
    name: 'Backend Ngalam Community',
    slug: 'backend-ngalam-community',
    description: 'Community partner dari Malang',
    logo: null,
    website: null,
    partner_type: 'community_partner',
    sponsor_category: null,
    order: 6,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  },
  {
    id: 7,
    event_id: 1,
    name: 'SidoarjoDev',
    slug: 'sidoarjodev',
    description: 'Community partner dari Sidoarjo',
    logo: null,
    website: null,
    partner_type: 'community_partner',
    sponsor_category: null,
    order: 7,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  }
]
