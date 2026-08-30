import type { Speaker } from './types'

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
