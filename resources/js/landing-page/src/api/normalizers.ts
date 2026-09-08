import type { Speaker, Ticket } from './types'

interface RawSpeaker {
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
  materials?: { id: number; title: string; slug: string }[]
}

export function normalizeSpeaker(raw: RawSpeaker): Speaker {
  return {
    id: raw.id,
    event_id: raw.event_id,
    event_name: raw.event_name,
    name: raw.name,
    bio: raw.bio,
    company: raw.company,
    job_title: raw.job_title,
    photo_path: raw.photo_path,
    speaker_group: raw.speaker_group,
    is_active: raw.is_active,
    sort_order: raw.sort_order,
    materials: raw.materials
  }
}

export function normalizeSpeakers(raw: RawSpeaker[]): Speaker[] {
  return raw.map(normalizeSpeaker)
}

interface RawTicket {
  id: number
  event_id: number
  name: string
  slug: string
  description: string | null
  price: number
  compare_price: number | null
  ticket_type: string
  capacity: number | null
  sold: number
  benefits_json: string[] | null
  description_html: string | null
  label: string | null
  label_color: string | null
  sales_starts_at: string | null
  sales_ends_at: string | null
  cta_label: string | null
  cta_url: string | null
  sort_order: number
  is_active: boolean
  created_at: string
  updated_at: string
}

export function normalizeTicket(raw: RawTicket): Ticket {
  return {
    id: raw.id,
    event_id: raw.event_id,
    name: raw.name,
    slug: raw.slug,
    description: raw.description,
    price: raw.price,
    compare_price: raw.compare_price,
    ticket_type: raw.ticket_type,
    capacity: raw.capacity,
    sold: raw.sold,
    benefits: raw.benefits_json,
    description_html: raw.description_html,
    label: raw.label,
    label_color: raw.label_color,
    sales_starts_at: raw.sales_starts_at,
    sales_ends_at: raw.sales_ends_at,
    cta_label: raw.cta_label,
    cta_url: raw.cta_url,
    sort_order: raw.sort_order,
    is_active: raw.is_active,
    created_at: raw.created_at,
    updated_at: raw.updated_at,
  }
}

export function normalizeTickets(raw: RawTicket[]): Ticket[] {
  return raw.map(normalizeTicket)
}
