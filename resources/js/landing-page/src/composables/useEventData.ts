import { computed, ref, type Ref, type ComputedRef } from 'vue'
import { useQuery } from '@tanstack/vue-query'
import { useConfig } from '../config'
import * as api from '../api/cms'
import * as staticData from '../data/static'
import type { Event, Speaker, Material, AgendaGroup, AgendaItem, Ticket, Merchandise, Partner, EventSection } from '../api/types'

export function useEvent(eventId?: number): ComputedRef<Event | undefined> {
  const config = useConfig()
  const id = eventId ?? config.eventId
  
  const { data: apiData } = useQuery({
    queryKey: ['event', id],
    queryFn: () => api.getEventDetail(id),
    enabled: config.useApiData
  })
  
  return computed(() => config.useApiData ? apiData.value : staticData.staticEvent)
}

export function useSpeakers(): ComputedRef<Speaker[] | undefined> {
  const config = useConfig()
  
  const { data: apiData, isPending, isError, error } = useQuery({
    queryKey: ['speakers'],
    queryFn: () => api.getSpeakers(),
    enabled: config.useApiData
  })
  
  return computed(() => {
    if (!config.useApiData) {
      return staticData.staticSpeakers
    }
    
    if (isPending.value) {
      return undefined
    }
    
    if (isError.value) {
      return []
    }
    
    return apiData.value
  })
}

export function useMaterials(eventId?: number): ComputedRef<Material[] | undefined> {
  const config = useConfig()
  const id = eventId ?? config.eventId
  
  const { data: apiData } = useQuery({
    queryKey: ['materials', id],
    queryFn: () => api.getMaterials(id),
    enabled: config.useApiData
  })
  
  return computed(() => config.useApiData ? apiData.value : staticData.staticMaterials)
}

export function useAgendaGroups(eventId?: number): ComputedRef<AgendaGroup[] | undefined> {
  const config = useConfig()
  const id = eventId ?? config.eventId
  
  const { data: apiData } = useQuery({
    queryKey: ['agendaGroups', id],
    queryFn: () => api.getAgendaGroups(id),
    enabled: config.useApiData
  })
  
  return computed(() => config.useApiData ? apiData.value : staticData.staticAgendaGroups)
}

export function useAgendaItems(eventId?: number): ComputedRef<AgendaItem[] | undefined> {
  const config = useConfig()
  const id = eventId ?? config.eventId
  
  const { data: apiData } = useQuery({
    queryKey: ['agendaItems', id],
    queryFn: () => api.getAgendaItems(id),
    enabled: config.useApiData
  })
  
  return computed(() => config.useApiData ? apiData.value : staticData.staticAgendaItems)
}

export function useAgenda(eventId?: number): ComputedRef<AgendaGroup[] | undefined> {
  const config = useConfig()
  const id = eventId ?? config.eventId
  
  const { data: apiData } = useQuery({
    queryKey: ['agenda', id],
    queryFn: () => api.getAgenda(id),
    enabled: config.useApiData
  })
  
  return computed(() => config.useApiData ? apiData.value : staticData.staticAgendaGroups)
}

export function useTickets(eventId?: number): ComputedRef<Ticket[] | undefined> {
  const config = useConfig()
  const id = eventId ?? config.eventId
  
  const { data: apiData } = useQuery({
    queryKey: ['tickets', id],
    queryFn: () => api.getTickets(id),
    enabled: config.useApiData
  })
  
  return computed(() => config.useApiData ? apiData.value : staticData.staticTickets)
}

export function useMerchandises(eventId?: number): ComputedRef<Merchandise[] | undefined> {
  const config = useConfig()
  const id = eventId ?? config.eventId
  
  const { data: apiData } = useQuery({
    queryKey: ['merchandises', id],
    queryFn: () => api.getMerchandises(id),
    enabled: config.useApiData
  })
  
  return computed(() => config.useApiData ? apiData.value : staticData.staticMerchandises)
}

export function usePartners(eventId?: number): ComputedRef<Partner[] | undefined> {
  const config = useConfig()
  const id = eventId ?? config.eventId
  
  const { data: apiData } = useQuery({
    queryKey: ['partners', id],
    queryFn: () => api.getPartners(id),
    enabled: config.useApiData
  })
  
  return computed(() => config.useApiData ? apiData.value : staticData.staticPartners)
}

export function useSections(eventId?: number): ComputedRef<EventSection[] | undefined> {
  const config = useConfig()
  const id = eventId ?? config.eventId
  
  const { data: apiData } = useQuery({
    queryKey: ['sections', id],
    queryFn: () => api.getSections(id),
    enabled: config.useApiData
  })
  
  return computed(() => config.useApiData ? apiData.value : staticData.staticSections)
}

export function useSponsors(eventId?: number): ComputedRef<Partner[] | undefined> {
  const config = useConfig()
  const id = eventId ?? config.eventId
  
  const { data: apiData } = useQuery({
    queryKey: ['sponsors', id],
    queryFn: () => api.getPartners(id, 'sponsor'),
    enabled: config.useApiData
  })
  
  return computed(() => {
    if (config.useApiData) {
      return apiData.value
    }
    return staticData.staticPartners.filter(p => p.partner_type === 'sponsor')
  })
}

export function useSponsorsByCategory(eventId?: number) {
  const partners = useSponsors(eventId)
  
  return computed(() => {
    const data = partners.value || []
    return {
      gold: data.filter(p => p.sponsor_category === 'gold'),
      silver: data.filter(p => p.sponsor_category === 'silver'),
      bronze: data.filter(p => p.sponsor_category === 'bronze')
    }
  })
}

export function useCommunityPartners(eventId?: number): ComputedRef<Partner[] | undefined> {
  const config = useConfig()
  const id = eventId ?? config.eventId
  
  const { data: apiData } = useQuery({
    queryKey: ['communityPartners', id],
    queryFn: () => api.getPartners(id, 'community_partner'),
    enabled: config.useApiData
  })
  
  return computed(() => {
    if (config.useApiData) {
      return apiData.value
    }
    return staticData.staticPartners.filter(p => p.partner_type === 'community_partner')
  })
}

export function useKeynoteSpeakers(): ComputedRef<Speaker[] | undefined> {
  const config = useConfig()
  
  const { data: apiData } = useQuery({
    queryKey: ['keynoteSpeakers'],
    queryFn: () => api.getSpeakers('keynote'),
    enabled: config.useApiData
  })
  
  return computed(() => {
    if (config.useApiData) {
      return apiData.value
    }
    return staticData.staticSpeakers.filter(s => s.speaker_group === 'keynote')
  })
}

export function useWorkshopSpeakers(): ComputedRef<Speaker[] | undefined> {
  const config = useConfig()
  
  const { data: apiData } = useQuery({
    queryKey: ['workshopSpeakers'],
    queryFn: () => api.getSpeakers('workshop'),
    enabled: config.useApiData
  })
  
  return computed(() => {
    if (config.useApiData) {
      return apiData.value
    }
    return staticData.staticSpeakers.filter(s => s.speaker_group === 'workshop')
  })
}

export function useHighlightedSpeakers(): ComputedRef<Speaker[] | undefined> {
  const speakers = useSpeakers()
  
  return computed(() => {
    return speakers.value?.filter(s => s.is_active === 1)
  })
}
