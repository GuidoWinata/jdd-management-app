export const config = {
  useApiData: window.APP_CONFIG?.useApiData ?? true,
  baseUrl: window.APP_CONFIG?.apiBaseUrl || 'https://jdd.smartlogy-labs.my.id',
  eventId: 1
}

export function useConfig() {
  return config
}
