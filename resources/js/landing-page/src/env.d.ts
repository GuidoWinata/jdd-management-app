type ApiDataConfig = Record<string, boolean>

interface AppConfig {
  apiBaseUrl: string
  appType: string
  useApiData: boolean | ApiDataConfig
  eventDate: string
  speakerFormUrl: string
  mediaPartnerFormUrl: string
}

declare interface Window {
  APP_CONFIG: AppConfig
}
