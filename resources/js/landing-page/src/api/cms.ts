import client from './client'
import type { ApiResponse } from './types'
import type { Event, Speaker, Material, AgendaGroup, AgendaItem, Ticket, Merchandise, Partner, EventSection } from './types'
import { normalizeSpeakers } from './normalizers'

export async function getEvents() {
  const { data } = await client.get<ApiResponse<Event[]>>('/api/events')
  return data.data
}

export async function getEventDetail(eventId: number) {
  const { data } = await client.get<ApiResponse<Event>>(`/api/events/${eventId}`)
  return data.data
}

export async function getAgenda(eventId: number) {
  const { data } = await client.get<ApiResponse<AgendaGroup[]>>(`/api/events/${eventId}/agenda`)
  return data.data
}

export async function getAgendaGlobal() {
  const { data } = await client.get<ApiResponse<AgendaGroup[]>>('/api/events/agenda')
  return data.data
}

export async function getSections(eventId: number) {
  const { data } = await client.get<ApiResponse<EventSection[]>>('/api/event-sections', {
    params: { event_id: eventId, no_pagination: true }
  })
  return data.data
}

export async function getSectionDetail(sectionId: number) {
  const { data } = await client.get<ApiResponse<EventSection>>(`/api/event-sections/${sectionId}`)
  return data.data
}

export async function getSpeakers(speakerGroup?: string): Promise<Speaker[]> {
  const params: Record<string, string | boolean> = { no_pagination: true }
  if (speakerGroup) {
    params.speaker_group = speakerGroup
  }

  const response = await client.get('/api/speakers', { params })
  const rawList = response.data?.data?.list ?? response.data?.data ?? []
  return normalizeSpeakers(Array.isArray(rawList) ? rawList : [])
}

export async function getSpeakerDetail(speakerId: number) {
  const { data } = await client.get<ApiResponse<Speaker>>(`/api/speakers/${speakerId}`)
  return data.data
}

export async function getMaterials(eventId: number) {
  const { data } = await client.get<ApiResponse<Material[]>>('/api/materials', {
    params: { event_id: eventId, no_pagination: true }
  })
  return data.data
}

export async function getMaterialDetail(materialId: number) {
  const { data } = await client.get<ApiResponse<Material>>(`/api/materials/${materialId}`)
  return data.data
}

export async function getAgendaGroups(eventId: number) {
  const { data } = await client.get<ApiResponse<AgendaGroup[]>>('/api/agenda-groups', {
    params: { event_id: eventId, no_pagination: true }
  })
  return data.data
}

export async function getAgendaGroupDetail(agendaGroupId: number) {
  const { data } = await client.get<ApiResponse<AgendaGroup>>(`/api/agenda-groups/${agendaGroupId}`)
  return data.data
}

export async function getAgendaItems(eventId: number) {
  const { data } = await client.get<ApiResponse<AgendaItem[]>>('/api/agenda-items', {
    params: { event_id: eventId, no_pagination: true }
  })
  return data.data
}

export async function getAgendaItemDetail(agendaItemId: number) {
  const { data } = await client.get<ApiResponse<AgendaItem>>(`/api/agenda-items/${agendaItemId}`)
  return data.data
}

export async function getTickets(eventId: number, ticketType?: string) {
  const { data } = await client.get<ApiResponse<Ticket[]>>('/api/tickets', {
    params: { 
      event_id: eventId, 
      ticket_type: ticketType || '', 
      no_pagination: true 
    }
  })
  return data.data
}

export async function getTicketDetail(ticketId: number) {
  const { data } = await client.get<ApiResponse<Ticket>>(`/api/tickets/${ticketId}`)
  return data.data
}

export async function getMerchandises(eventId: number) {
  const { data } = await client.get<ApiResponse<Merchandise[]>>('/api/merchandises', {
    params: { event_id: eventId, no_pagination: true }
  })
  return data.data
}

export async function getMerchandiseDetail(merchandiseId: number) {
  const { data } = await client.get<ApiResponse<Merchandise>>(`/api/merchandises/${merchandiseId}`)
  return data.data
}

export async function getPartners(eventId: number, partnerType?: string, sponsorCategory?: string) {
  const { data } = await client.get<ApiResponse<Partner[]>>('/api/partners', {
    params: { 
      event_id: eventId, 
      partner_type: partnerType || '', 
      sponsor_category: sponsorCategory || '', 
      no_pagination: true 
    }
  })
  return data.data
}

export async function getPartnerDetail(partnerId: number) {
  const { data } = await client.get<ApiResponse<Partner>>(`/api/partners/${partnerId}`)
  return data.data
}
