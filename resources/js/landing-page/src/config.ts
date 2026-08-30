export const config = {
  useApiData: import.meta.env.VITE_USE_API_DATA === 'true',
  baseUrl: import.meta.env.VITE_API_BASE_URL || 'https://jdd.smartlogy-labs.my.id',
  eventId: 1
}

export function useConfig() {
  return config
}
