// Data statis sementara. Saat CMS siap, ganti nilai-nilai di bawah
// dengan hasil fetch dari src/api/cms.ts tanpa mengubah struktur tipe.

import gallerySpLeftPt from '../assets/gallery/sp-left-pt.webp'
import galleryGroupTopLsc from '../assets/gallery/group-top-lsc.webp'
import gallerySpRight1x1 from '../assets/gallery/sp-right-1x1.webp'
import galleryDscsMidLsc from '../assets/gallery/dscs-mid-lsc.webp'
import galleryGroupRight1x1 from '../assets/gallery/group-right-1x1.webp'
import gallerySpBtm1x1 from '../assets/gallery/sp-btm-1x1.webp'
import gallerySpLeftbtmLsc from '../assets/gallery/sp-leftbtm-lsc.webp'
import galleryDscsBtm1x1 from '../assets/gallery/dscs-btm-1x1.webp'

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
  image: string
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
  { id: 1, name: 'Eko Kurniawan Khannedy', role: 'Programmer Zaman Now | Technical Architect', category: 'KEYNOTE SPEAKER', company: '', highlighted: true },
  { id: 2, name: 'Sandhika Galih', role: 'Web Programming Unpas | GDE Web & UI', category: 'KEYNOTE SPEAKER', company: '', highlighted: true },
  { id: 3, name: 'Nosa Shandy', role: 'Cyber Security Professional | Local Rockstar', category: 'KEYNOTE SPEAKER', company: '', highlighted: true },
  { id: 4, name: 'TBA', role: 'TBA', category: 'COMMUNITY SPEAKER', company: '', highlighted: false },
  { id: 5, name: 'TBA', role: 'TBA', category: 'COMMUNITY SPEAKER', company: '', highlighted: false },
  { id: 6, name: 'TBA', role: 'TBA', category: 'COMMUNITY SPEAKER', company: '', highlighted: false },
]

export const agendaGroups: AgendaGroup[] = [
  {
    category: 'OPENING',
    sessions: [
      {
        time: '08:00 — 09:20',
        location: 'MAIN HALL',
        type: 'REGISTRATION',
        title: 'Registration',
        speaker: null,
      },
    ],
  },
  {
    category: 'KEYNOTE SESSIONS',
    sessions: [
      {
        time: '09:20 — 09:50',
        location: 'MAIN HALL',
        type: 'KEYNOTE',
        title: 'TBA',
        speaker: 'Nosa Shandy',
      },
      {
        time: '10:00 — 10:30',
        location: 'MAIN HALL',
        type: 'KEYNOTE',
        title: 'TBA',
        speaker: 'Eko Kurniawan Khannedy',
      },
      {
        time: '10:50 — 11:20',
        location: 'MAIN HALL',
        type: 'KEYNOTE',
        title: 'TBA',
        speaker: 'Sandhika Galih',
      },
    ],
  },
  {
    category: 'PARALLEL SESSIONS',
    sessions: [
      {
        time: '13:20 — 15:20',
        location: 'MULTIPLE ROOMS',
        type: 'PARALLEL',
        title: 'Interactive Session 1',
        speaker: null,
      },
      {
        time: '13:20 — 15:20',
        location: 'MULTIPLE ROOMS',
        type: 'PARALLEL',
        title: 'Interactive Session 2',
        speaker: null,
      },
      {
        time: '13:20 — 15:20',
        location: 'MULTIPLE ROOMS',
        type: 'WORKSHOP',
        title: 'Workshop',
        speaker: null,
      },
      {
        time: '13:20 — 15:20',
        location: 'MULTIPLE ROOMS',
        type: 'LIGHTNING TALK',
        title: 'Lightning Talk',
        speaker: null,
      },
    ],
  },
  {
    category: 'CLOSING',
    sessions: [
      {
        time: '15:20 — 15:30',
        location: 'MAIN HALL',
        type: 'CLOSING',
        title: 'Documentation & Closing',
        speaker: null,
      },
    ],
  },
]

export const tickets: Ticket[] = [
  {
    type: 'regular',
    subtitle: 'STANDARD ACCESS',
    title: 'REGULAR PASS',
    price: 'TBA',
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
    price: 'TBA',
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
  { id: 1, label: 'Speaker (Kiri)', resolutionHint: 'Potret / Vertikal', gridClass: 'col-span-1 md:col-span-1 lg:col-span-1 lg:row-span-2', image: gallerySpLeftPt },
  { id: 2, label: 'Grup Foto Atas', resolutionHint: 'Lanskap / Lebar', gridClass: 'col-span-1 md:col-span-2 lg:col-span-2 lg:row-span-1', image: galleryGroupTopLsc },
  { id: 3, label: 'Speaker (Kanan Atas)', resolutionHint: 'Lanskap Standar', gridClass: 'col-span-1 md:col-span-1 lg:col-span-1 lg:row-span-1', image: gallerySpRight1x1 },
  { id: 4, label: 'Diskusi Sesi Tengah', resolutionHint: 'Lanskap / Lebar', gridClass: 'col-span-1 md:col-span-2 lg:col-span-2 lg:row-span-1', image: galleryDscsMidLsc },
  { id: 5, label: 'Grup Kanan Tengah', resolutionHint: 'Lanskap Standar', gridClass: 'col-span-1 md:col-span-1 lg:col-span-1 lg:row-span-1', image: galleryGroupRight1x1 },
  { id: 6, label: 'Foto Panggung Besar', resolutionHint: 'Lanskap / Sangat Lebar', gridClass: 'col-span-1 md:col-span-2 lg:col-span-2 lg:row-span-1', image: gallerySpBtm1x1 },
  { id: 7, label: 'Speaker Layar', resolutionHint: 'Lanskap Standar', gridClass: 'col-span-1 md:col-span-1 lg:col-span-1 lg:row-span-1', image: gallerySpLeftbtmLsc },
  { id: 8, label: 'Sesi Diskusi Bawah', resolutionHint: 'Lanskap Standar', gridClass: 'col-span-1 md:col-span-1 lg:col-span-1 lg:row-span-1', image: galleryDscsBtm1x1 },
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