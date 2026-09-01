import axios from 'axios'

const client = axios.create({
  baseURL: window.APP_CONFIG?.apiBaseUrl,
  headers: {
    'Content-Type': 'application/json',
  },
})

client.interceptors.request.use((config) => {
  // TODO: attach auth token bila diperlukan, contoh:
  // const token = localStorage.getItem('jdd-token')
  // if (token) config.headers.Authorization = `Bearer ${token}`
  return config
})

client.interceptors.response.use(
  (response) => response,
  (error) => {
    // TODO: handle error terpusat (toast, logging, dsb.) di sini
    return Promise.reject(error)
  }
)

export default client
