import type { Event, EventSection, Speaker, Material, AgendaGroup, AgendaItem, Ticket, Merchandise, Partner } from '../api/types'

export const staticEvent: Event = {
  id: 1,
  name: 'Jatim Developer Day 2024',
  slug: 'jatim-developer-day-2024',
  description: 'Developer conference terbesar di Jawa Timur',
  start_date: '2024-11-15',
  end_date: '2024-11-16',
  location: 'Surabaya',
  venue: 'Grand Heritage Hotel',
  status: 'upcoming',
  is_active: true,
  created_at: '2024-01-01T00:00:00Z',
  updated_at: '2024-01-01T00:00:00Z'
}

export const staticSections: EventSection[] = [
  {
    id: 1,
    event_id: 1,
    name: 'About',
    slug: 'about',
    content: '<p>Jatim Developer Day adalah konferensi developer terbesar di Jawa Timur.</p>',
    order: 1,
    is_active: true,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  },
  {
    id: 2,
    event_id: 1,
    name: 'Venue',
    slug: 'venue',
    content: '<p>Grand Heritage Hotel, Surabaya</p>',
    order: 2,
    is_active: true,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  }
]

export const staticSpeakers: Speaker[] = [
  {
    id: 1,
    event_id: 1,
    event_name: 'Jatim Developer Day 2026',
    name: 'Eko Kurniawan Khannedy',
    bio: 'Programmer Zaman Now | Technical Architect',
    company: '',
    job_title: 'Programmer Zaman Now | Technical Architect',
    photo_path: null,
    speaker_group: 'keynote',
    is_active: 1,
    sort_order: 1
  },
  {
    id: 2,
    event_id: 1,
    event_name: 'Jatim Developer Day 2026',
    name: 'Sandhika Galih',
    bio: 'Web Programming Unpas | GDE Web & UI',
    company: '',
    job_title: 'Web Programming Unpas | GDE Web & UI',
    photo_path: null,
    speaker_group: 'keynote',
    is_active: 1,
    sort_order: 2
  },
  {
    id: 3,
    event_id: 1,
    event_name: 'Jatim Developer Day 2026',
    name: 'Nosa Shandy',
    bio: 'Cyber Security Professional | Local Rockstar',
    company: '',
    job_title: 'Cyber Security Professional | Local Rockstar',
    photo_path: null,
    speaker_group: 'keynote',
    is_active: 1,
    sort_order: 3
  },
  {
    id: 4,
    event_id: 1,
    event_name: 'Jatim Developer Day 2026',
    name: 'TBA',
    bio: null,
    company: '',
    job_title: 'TBA',
    photo_path: null,
    speaker_group: 'lightning',
    is_active: 0,
    sort_order: 4
  },
  {
    id: 5,
    event_id: 1,
    event_name: 'Jatim Developer Day 2026',
    name: 'TBA',
    bio: null,
    company: '',
    job_title: 'TBA',
    photo_path: null,
    speaker_group: 'workshop',
    is_active: 0,
    sort_order: 5
  },
  {
    id: 6,
    event_id: 1,
    event_name: 'Jatim Developer Day 2026',
    name: 'TBA',
    bio: null,
    company: '',
    job_title: 'TBA',
    photo_path: null,
    speaker_group: 'lightning',
    is_active: 0,
    sort_order: 6
  }
]

export const staticMaterials: Material[] = [
  {
    id: 1,
    event_id: 1,
    speaker_id: 1,
    title: 'Data Innovation in Modern Tech',
    description: 'Membahas inovasi data di era modern.',
    type: 'keynote',
    file_url: null,
    video_url: null,
    slide_url: null,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  },
  {
    id: 2,
    event_id: 1,
    speaker_id: 2,
    title: 'Mobile Development Best Practices',
    description: 'Best practices dalam pengembangan aplikasi mobile.',
    type: 'keynote',
    file_url: null,
    video_url: null,
    slide_url: null,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  }
]

export const staticAgendaGroups: any = {
  event: { id: 1, name: 'Jatim Dev Day 2026' },
  agenda_groups: [
    {
      id: 1,
      title: 'OPENING',
      place: 'Main Hall',
      description: 'Sesi pembukaan',
      sort_order: 1,
      items: [
        { id: 1, title: 'Registration', starts_at: '08:00:00', ends_at: '09:00:00', place: 'Main Hall', description: null, sort_order: 1, material: null, speakers: [] },
      ],
    },
    {
      id: 2,
      title: 'KEYNOTE SESSIONS',
      place: 'Main Hall',
      description: 'Sesi keynote',
      sort_order: 2,
      items: [
        { id: 2, title: 'Security Matters: AI Is the New Attack Surface', starts_at: '09:20:00', ends_at: '10:00:00', place: 'Main Hall', description: null, sort_order: 1, material: null, speakers: [{ name: 'Nosa Shandy' }] },
        { id: 3, title: 'AI Can Write Code. Can You Design the System? (TBC)', starts_at: '10:00:00', ends_at: '10:45:00', place: 'Main Hall', description: null, sort_order: 2, material: null, speakers: [{ name: 'Eko Kurniawan Khannedy' }] },
        { id: 4, title: 'Tech Talent 2.0: Cara Belajar, Beradaptasi, dan Tetap Relevan di Tengah Gelombang AI (TBC)', starts_at: '11:00:00', ends_at: '11:45:00', place: 'Main Hall', description: null, sort_order: 3, material: null, speakers: [{ name: 'Sandhika Galih' }] },
      ],
    },
    {
      id: 3,
      title: 'PARALLEL SESSIONS',
      place: 'Multiple Rooms',
      description: 'Sesi paralel',
      sort_order: 3,
      items: [
        { id: 5, title: 'Career Consultation', starts_at: '13:20:00', ends_at: '15:20:00', place: 'Multiple Rooms', description: null, sort_order: 1, material: null, speakers: [] },
        { id: 6, title: 'Application Pitching', starts_at: '13:20:00', ends_at: '15:20:00', place: 'Multiple Rooms', description: null, sort_order: 2, material: null, speakers: [] },
        { id: 7, title: 'Showcase Portfolio', starts_at: '13:20:00', ends_at: '15:20:00', place: 'Multiple Rooms', description: null, sort_order: 3, material: null, speakers: [] },
        { id: 8, title: 'Technical Workshop', starts_at: '13:20:00', ends_at: '15:20:00', place: 'Multiple Rooms', description: null, sort_order: 4, material: null, speakers: [] },
        { id: 9, title: 'Lightning Talk', starts_at: '13:20:00', ends_at: '15:20:00', place: 'Multiple Rooms', description: null, sort_order: 4, material: null, speakers: [] },
        { id: 10, title: 'Community Management FGD', starts_at: '13:20:00', ends_at: '15:20:00', place: 'Multiple Rooms', description: null, sort_order: 4, material: null, speakers: [] },
      ],
    },
    {
      id: 4,
      title: 'CLOSING',
      place: 'Main Hall',
      description: 'Penutupan',
      sort_order: 4,
      items: [
        { id: 11, title: 'Documentation & Closing', starts_at: '15:20:00', ends_at: '15:30:00', place: 'Main Hall', description: null, sort_order: 1, material: null, speakers: [] },
      ],
    },
  ],
}

export const staticAgendaItems: AgendaItem[] = [
  {
    id: 1,
    event_id: 1,
    agenda_group_id: 1,
    material_id: 1,
    title: 'Registration & Welcome Coffee',
    description: 'Pendaftaran dan kopi pagi',
    start_time: '08:00:00',
    end_time: '09:00:00',
    order: 1,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  },
  {
    id: 2,
    event_id: 1,
    agenda_group_id: 1,
    material_id: 1,
    title: 'Opening Keynote - Data Innovation',
    description: 'Keynote tentang inovasi data',
    start_time: '09:00:00',
    end_time: '10:00:00',
    order: 2,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  },
  {
    id: 3,
    event_id: 1,
    agenda_group_id: 1,
    material_id: 2,
    title: 'Mobile Development Session',
    description: 'Sesi tentang mobile development',
    start_time: '10:15:00',
    end_time: '11:15:00',
    order: 3,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  }
]

export const staticTickets: Ticket[] = [
  {
    id: 1,
    event_id: 1,
    name: 'Flash Sale 9.9',
    slug: 'flash-sale-99',
    description: null,
    price: 35000,
    compare_price: null,
    ticket_type: 'single',
    capacity: null,
    sold: 0,
    benefits: [
      '1 Full-Day All-Access Pass',
      'High-Impact Career Accelerator Access',
      'Elite Tech Networking Lounge',
      'Verified Digital Certificate',
    ],
    description_html: null,
    label: '🔥 BEST VALUE',
    label_color: null,
    sales_starts_at: null,
    sales_ends_at: null,
    cta_label: 'Beli Tiket Presale #1',
    cta_url: 'https://avora.id/jatimdeveloperday/jatim-developer-day-2026',
    sort_order: 1,
    is_active: true,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  },
  // {
  //   id: 2,
  //   event_id: 1,
  //   name: 'Regular',
  //   slug: 'regular',
  //   description: null,
  //   price: 0,
  //   compare_price: null,
  //   ticket_type: 'single',
  //   capacity: null,
  //   sold: 0,
  //   benefits: [
  //     '1 Full-Day All-Access Pass',
  //     'High-Impact Career Accelerator Access',
  //     'Elite Tech Networking Lounge',
  //     'Verified Digital Certificate',
  //   ],
  //   description_html: null,
  //   label: '⭐ MOST POPULAR',
  //   label_color: null,
  //   sales_starts_at: null,
  //   sales_ends_at: null,
  //   cta_label: 'Beli Tiket',
  //   cta_url: null,
  //   sort_order: 2,
  //   is_active: true,
  //   created_at: '2024-01-01T00:00:00Z',
  //   updated_at: '2024-01-01T00:00:00Z'
  // },
  // {
  //   id: 3,
  //   event_id: 1,
  //   name: 'Bundling',
  //   slug: 'bundling',
  //   description: null,
  //   price: 0,
  //   compare_price: null,
  //   ticket_type: 'bundle',
  //   capacity: null,
  //   sold: 0,
  //   benefits: [
  //     'All regular ticket benefits',
  //     'Exclusive JDD Official T-Shirt',
  //     'Limited Edition Lanyard, Keychain & Tote Bag',
  //     'Signature Lanyard & ID Card Holder untuk data tiket',
  //   ],
  //   description_html: null,
  //   label: '💎 COMPLETE EXPERIENCE',
  //   label_color: null,
  //   sales_starts_at: null,
  //   sales_ends_at: null,
  //   cta_label: 'Beli Tiket',
  //   cta_url: null,
  //   sort_order: 3,
  //   is_active: true,
  //   created_at: '2024-01-01T00:00:00Z',
  //   updated_at: '2024-01-01T00:00:00Z'
  // }
]

export const staticMerchandises: Merchandise[] = [
  {
    id: 1,
    event_id: 1,
    name: 'JDD T-Shirt 2024',
    slug: 'jdd-tshirt-2024',
    description: 'Kaos eksklusif JDD 2024',
    price: 75000,
    image: null,
    stock: 200,
    is_active: true,
    order: 1,
    link: null,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  },
  {
    id: 2,
    event_id: 1,
    name: 'JDD Sticker Pack',
    slug: 'jdd-sticker-pack',
    description: 'Paket stiker JDD',
    price: 25000,
    image: null,
    stock: 500,
    is_active: true,
    order: 2,
    link: null,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  }
]

export const staticPartners: Partner[] = [
  {
    id: 1,
    event_id: 1,
    name: 'Tarsquare',
    slug: 'tarsquare',
    description: 'Technology partner',
    logo: null,
    website: 'https://tarsquare.com',
    partner_type: 'sponsor',
    sponsor_category: 'gold',
    order: 1,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  },
  {
    id: 2,
    event_id: 1,
    name: 'Gojek',
    slug: 'gojek',
    description: 'Super app partner',
    logo: null,
    website: 'https://gojek.com',
    partner_type: 'sponsor',
    sponsor_category: 'silver',
    order: 2,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  },
  {
    id: 3,
    event_id: 1,
    name: 'AWS',
    slug: 'aws',
    description: 'Cloud partner',
    logo: null,
    website: 'https://aws.amazon.com',
    partner_type: 'sponsor',
    sponsor_category: 'bronze',
    order: 3,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  },
  {
    id: 4,
    event_id: 1,
    name: 'Bangkalan Dev',
    slug: 'bangkalan-dev',
    description: 'Community partner dari Bangkalan',
    logo: null,
    website: null,
    partner_type: 'community_partner',
    sponsor_category: null,
    order: 4,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  },
  {
    id: 5,
    event_id: 1,
    name: 'PasuruanDev',
    slug: 'pasuruandev',
    description: 'Community partner dari Pasuruan',
    logo: null,
    website: null,
    partner_type: 'community_partner',
    sponsor_category: null,
    order: 5,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  },
  {
    id: 6,
    event_id: 1,
    name: 'Backend Ngalam Community',
    slug: 'backend-ngalam-community',
    description: 'Community partner dari Malang',
    logo: null,
    website: null,
    partner_type: 'community_partner',
    sponsor_category: null,
    order: 6,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  },
  {
    id: 7,
    event_id: 1,
    name: 'SidoarjoDev',
    slug: 'sidoarjodev',
    description: 'Community partner dari Sidoarjo',
    logo: null,
    website: null,
    partner_type: 'community_partner',
    sponsor_category: null,
    order: 7,
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  }
]
