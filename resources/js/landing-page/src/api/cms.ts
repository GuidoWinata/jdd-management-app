import client from './client'
import type { ApiResponse } from './types'

// Pusat fungsi endpoint CMS.
// TODO: isi endpoint sesuai bagian yang akan diambil dari BE
// (misalnya speakers, agenda, tickets, gallery, sponsors, cta, footer).

// Contoh pola pemakaian (pada komponen/views):
//   import { useQuery } from '@tanstack/vue-query'
//   const { data, isPending, error } = useQuery({
//     queryKey: ['speakers'],
//     queryFn: getSpeakers,
//   })

// Contoh endpoint:
// export async function getSpeakers() {
//   const { data } = await client.get<ApiResponse<Speaker[]>>('/cms/speakers')
//   return data.data
// }

