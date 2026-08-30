export interface ApiResponse<T> {
  data: T
  message?: string
}

export interface PaginatedResponse<T> {
  data: T[]
  meta: {
    currentPage: number
    lastPage: number
    perPage: number
    total: number
  }
}

// TODO: tambahkan tipe entitas CMS sesuai kontrak BE di sini,
// misalnya Speaker, AgendaGroup, Ticket, Sponsor, GalleryItem, dst.
