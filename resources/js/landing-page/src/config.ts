export const config = {
  useApiData: window.APP_CONFIG?.useApiData ?? true,
  baseUrl: window.APP_CONFIG?.apiBaseUrl || 'https://jdd.smartlogy-labs.my.id',
  eventId: 1
}

export function useConfig() {
  return config
}

export function isApiEnabled(entity: string): boolean {
  const val = config.useApiData
  if (typeof val === 'boolean') return val
  return val[entity] ?? false
}
