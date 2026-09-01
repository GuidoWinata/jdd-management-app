interface AppConfig {
  apiBaseUrl: string
  appType: string
  useApiData: boolean
  eventDate: string
  speakerFormUrl: string
  mediaPartnerFormUrl: string
}

declare interface Window {
  APP_CONFIG: AppConfig
}
