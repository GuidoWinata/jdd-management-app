// Data statis sementara. Saat CMS siap, ganti nilai-nilai di bawah
// dengan hasil fetch dari src/api/cms.ts tanpa mengubah struktur tipe.

export interface Speaker {
  id: number
  name: string
  role: string
  category: string
  company: string
  highlighted: boolean
}

export interface AgendaSession {
  time: string
  location: string
  type: string
  title: string
  speaker: string | null
}

export interface AgendaGroup {
  category: string
  sessions: AgendaSession[]
}

export type TicketType = 'regular' | 'vip'

export interface Ticket {
  type: TicketType
  subtitle: string
  title: string
  price: string
  buttonText: string
  ribbon?: string
  features: string[]
}

export interface Sponsor {
  id: number
  name: string
}

export interface SponsorTiers {
  gold: Sponsor[]
  silver: Sponsor[]
  bronze: Sponsor[]
}

export interface GalleryItem {
  id: number
  label: string
  resolutionHint: string
  gridClass: string
}

export interface CommunityPartner {
  type: 'text-icon' | 'lion' | 'hexagon' | 'brackets'
  nameLine1: string
  nameLine2?: string
}

export type StatIcon = 'people' | 'building' | 'calendar' | 'briefcase'

export interface Stat {
  icon: StatIcon
  number: string
  label: string
}

export const speakers: Speaker[] = [
  { id: 1, name: 'Ainun Najib', role: 'Tech Leader & Data Innovator', category: 'KEYNOTE SPEAKER', company: 'Tarsquare', highlighted: true },
  { id: 2, name: 'Zain Fathoni', role: 'Software Engineer', category: 'KEYNOTE SPEAKER', company: 'Tarsquare', highlighted: true },
  { id: 3, name: 'Listiarso Wastuargo', role: 'Tech Professional', category: 'KEYNOTE SPEAKER', company: 'Tarsquare', highlighted: true },
  { id: 4, name: 'Dewi Lestari', role: 'Platform Engineer', category: 'COMMUNITY SPEAKER', company: 'Gojek', highlighted: false },
  { id: 5, name: 'Budi Santoso', role: 'Cloud Architect', category: 'COMMUNITY SPEAKER', company: 'AWS', highlighted: false },
  { id: 6, name: 'Rina Wijaya', role: 'Frontend Engineer', category: 'COMMUNITY SPEAKER', company: 'Tokopedia', highlighted: false },
]

export const agendaGroups: AgendaGroup[] = [
  {
    category: 'REGISTRATION',
    sessions: [
      {
        time: '08:00 — 09:00',
        location: 'GRAND HERITAGE LOBBY',
        type: 'REGISTRATION',
        title: 'Registration & Welcome Morning Coffee',
        speaker: null,
      },
    ],
  },
  {
    category: 'KEYNOTE & SESSIONS',
    sessions: [
      {
        time: '09:00 — 10:00',
        location: 'GRAND HALL',
        type: 'KEYNOTE ADDRESS',
        title: 'The Future of Software Engineering in Indonesia',
        speaker: 'Ainun Najib',
      },
      {
        time: '10:15 — 11:15',
        location: 'GRAND HALL',
        type: 'ARCHITECTURE TALK',
        title: 'Microservices Architecture at Scale: Lessons from Production',
        speaker: 'Zain Fathoni',
      },
      {
        time: '11:30 — 12:30',
        location: 'GRAND HALL',
        type: 'CLOUD TALK',
        title: 'Building Resilient & Distributed Cloud Systems',
        speaker: 'Listiarso Wastuargo',
      },
    ],
  },
  {
    category: 'MASTERCLASS WORKSHOPS',
    sessions: [
      {
        time: '13:30 — 15:00',
        location: 'WORKSHOP ROOM A',
        type: 'MASTERCLASS',
        title: 'Kubernetes in Production: A Hands-On Deep Dive',
        speaker: 'Listiarso Wastuargo',
      },
      {
        time: '13:30 — 15:00',
        location: 'WORKSHOP ROOM B',
        type: 'MASTERCLASS',
        title: 'CI/CD & Platform Engineering Best Practices',
        speaker: 'Zain Fathoni',
      },
      {
        time: '15:15 — 16:15',
        location: 'GRAND HALL',
        type: 'PANEL DISCUSSION',
        title: 'Open Source Ecosystem in East Java',
        speaker: 'All Headliners',
      },
    ],
  },
]

export const tickets: Ticket[] = [
  {
    type: 'regular',
    subtitle: 'STANDARD ACCESS',
    title: 'REGULAR PASS',
    price: 'Rp 35.000',
    buttonText: 'REGISTER NOW',
    features: [
      '1 Full Day Symposium Access',
      'Lunch & Coffee Break Facilities',
      'Verified Digital Credential Certificate',
    ],
  },
  {
    type: 'vip',
    subtitle: 'BEST VALUE PACKAGE',
    title: 'BUNDLING VIP PASS',
    price: 'Rp 185.000',
    buttonText: 'RESERVE VIP BUNDLE',
    ribbon: 'VIP MERCH',
    features: [
      'All Regular Pass Benefits Included',
      'Exclusive JDD T-Shirt (Maskot Pasuruan Edition)',
      'VIP Priority Lounge & Swag Kit',
    ],
  },
]

export const sponsors: SponsorTiers = {
  gold: [
    { id: 1, name: 'Sponsor Logo' },
    { id: 2, name: 'Sponsor Logo' },
    { id: 3, name: 'Sponsor Logo' },
  ],
  silver: [
    { id: 4, name: 'Sponsor Logo' },
    { id: 5, name: 'Sponsor Logo' },
    { id: 6, name: 'Sponsor Logo' },
  ],
  bronze: [
    { id: 7, name: 'Sponsor Logo' },
    { id: 8, name: 'Sponsor Logo' },
  ],
}

export const galleryItems: GalleryItem[] = [
  { id: 1, label: 'Speaker (Kiri)', resolutionHint: 'Potret / Vertikal', gridClass: 'col-span-1 md:col-span-1 lg:col-span-1 lg:row-span-2' },
  { id: 2, label: 'Grup Foto Atas', resolutionHint: 'Lanskap / Lebar', gridClass: 'col-span-1 md:col-span-2 lg:col-span-2 lg:row-span-1' },
  { id: 3, label: 'Speaker (Kanan Atas)', resolutionHint: 'Lanskap Standar', gridClass: 'col-span-1 md:col-span-1 lg:col-span-1 lg:row-span-1' },
  { id: 4, label: 'Diskusi Sesi Tengah', resolutionHint: 'Lanskap / Lebar', gridClass: 'col-span-1 md:col-span-2 lg:col-span-2 lg:row-span-1' },
  { id: 5, label: 'Grup Kanan Tengah', resolutionHint: 'Lanskap Standar', gridClass: 'col-span-1 md:col-span-1 lg:col-span-1 lg:row-span-1' },
  { id: 6, label: 'Foto Panggung Besar', resolutionHint: 'Lanskap / Sangat Lebar', gridClass: 'col-span-1 md:col-span-2 lg:col-span-2 lg:row-span-1' },
  { id: 7, label: 'Speaker Layar', resolutionHint: 'Lanskap Standar', gridClass: 'col-span-1 md:col-span-1 lg:col-span-1 lg:row-span-1' },
  { id: 8, label: 'Sesi Diskusi Bawah', resolutionHint: 'Lanskap Standar', gridClass: 'col-span-1 md:col-span-1 lg:col-span-1 lg:row-span-1' },
]

export const communityPartners: CommunityPartner[] = [
  { type: 'text-icon', nameLine1: 'Bangkalan', nameLine2: 'Dev' },
  { type: 'brackets', nameLine1: 'PASURUANDEV' },
  { type: 'lion', nameLine1: 'BACKEND', nameLine2: 'NGALAM COMMUNITY' },
  { type: 'hexagon', nameLine1: 'SidoarjoDev' },
]

export const stats: Stat[] = [
  { icon: 'people', number: '1,000+', label: 'Tech Leaders & Devs' },
  { icon: 'building', number: '20+', label: 'Industry Experts' },
  { icon: 'calendar', number: '2', label: 'Days of Sessions' },
  { icon: 'briefcase', number: '12+', label: 'Workshop Tracks' },
]