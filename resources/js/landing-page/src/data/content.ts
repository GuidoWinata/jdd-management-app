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

export const stats: Stat[] = [
  { icon: 'people', number: '500 +', label: 'Tech Leaders & Devs' },
  { icon: 'building', number: '20+', label: 'Industry Experts' },
  { icon: 'calendar', number: '1', label: 'Full-Day Session' },
  { icon: 'briefcase', number: '6', label: 'Session Tracks' },
]