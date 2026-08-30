export interface ApiResponse<T> {
  data: T
  message?: string
}

export interface PaginatedResponse<T> {
  data: T[]
  meta: {
    currentPage: number
    lastPage: number
    perPage: number
    total: number
  }
}

export interface Event {
  id: number
  name: string
  slug: string
  description: string | null
  start_date: string
  end_date: string
  location: string
  venue: string | null
  status: string
  is_active: boolean
  created_at: string
  updated_at: string
  sections?: EventSection[]
  speakers?: Speaker[]
  tickets?: Ticket[]
  merchandises?: Merchandise[]
  partners?: Partner[]
}

export interface EventSection {
  id: number
  event_id: number
  name: string
  slug: string
  content: string
  order: number
  is_active: boolean
  created_at: string
  updated_at: string
}

export interface Speaker {
  id: number
  event_id: number
  event_name: string
  name: string
  bio: string | null
  company: string | null
  job_title: string | null
  photo_path: string | null
  speaker_group: string | null
  is_active: number
  sort_order: number
  materials?: Material[]
}

export interface Material {
  id: number
  event_id?: number
  speaker_id?: number | null
  title: string
  description?: string | null
  type?: string
  file_url?: string | null
  video_url?: string | null
  slide_url?: string | null
  created_at?: string
  updated_at?: string
  slug?: string
  label?: string | null
  label_color?: string | null
  role?: string
  sort_order?: number
  speaker?: Speaker
}

export interface AgendaGroup {
  id: number
  event_id: number
  name: string
  slug: string
  description: string | null
  location: string | null
  order: number
  created_at: string
  updated_at: string
  agenda_items?: AgendaItem[]
}

export interface AgendaItem {
  id: number
  event_id: number
  agenda_group_id: number
  material_id: number | null
  title: string
  description: string | null
  start_time: string
  end_time: string
  order: number
  created_at: string
  updated_at: string
  material?: Material
  agenda_group?: AgendaGroup
}

export interface Ticket {
  id: number
  event_id: number
  name: string
  slug: string
  description: string | null
  price: number
  ticket_type: 'single' | 'bundle' | string
  capacity: number | null
  sold: number
  benefits: string[] | null
  is_active: boolean
  order: number
  created_at: string
  updated_at: string
  merchandises?: Merchandise[]
}

export interface Merchandise {
  id: number
  event_id: number
  name: string
  slug: string
  description: string | null
  price: number
  image: string | null
  stock: number | null
  is_active: boolean
  order: number
  link: string | null
  created_at: string
  updated_at: string
}

export interface Partner {
  id: number
  event_id: number
  name: string
  slug: string
  description: string | null
  logo: string | null
  website: string | null
  partner_type: 'sponsor' | 'media_partner' | 'community_partner' | 'supporting_partner' | string
  sponsor_category: 'gold' | 'silver' | 'bronze' | null
  order: number
  created_at: string
  updated_at: string
}
