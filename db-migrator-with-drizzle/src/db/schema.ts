import {
    bigint,
    boolean,
    datetime,
    decimal,
    index,
    int,
    json,
    longtext,
    mediumtext,
    mysqlTable,
    mysqlEnum,
    primaryKey,
    smallint,
    text,
    time,
    timestamp,
    tinyint,
    uniqueIndex,
    varchar,
} from "drizzle-orm/mysql-core";
import type { AnyMySqlColumn } from "drizzle-orm/mysql-core";

const unsignedBigInt = () => bigint({ mode: "number", unsigned: true });

const auditColumns = () => ({
    created_at: datetime(),
    created_by: unsignedBigInt(),
    updated_at: datetime(),
    updated_by: unsignedBigInt(),
    deleted_at: datetime(),
    deleted_by: unsignedBigInt(),
});

export const migrationsTable = mysqlTable("migrations", {
    id: int({ unsigned: true }).autoincrement().primaryKey(),
    migration: varchar({ length: 255 }).notNull(),
    batch: int().notNull(),
});

export const usersTable = mysqlTable(
    "users",
    {
        id: bigint({ mode: "number", unsigned: true })
            .autoincrement()
            .primaryKey(),
        name: varchar({ length: 255 }).notNull(),
        email: varchar({ length: 255 }).notNull(),
        email_verified_at: timestamp(),
        password: varchar({ length: 255 }).notNull(),
        remember_token: varchar({ length: 100 }),
        // 1=Superadmin
        access_type: tinyint(),
        is_active: tinyint().notNull().default(1),
        created_by: bigint({ mode: "number", unsigned: true }).references(
            (): AnyMySqlColumn => usersTable.id,
        ),
        created_at: datetime(),
        updated_by: bigint({ mode: "number", unsigned: true }).references(
            (): AnyMySqlColumn => usersTable.id,
        ),
        updated_at: datetime(),
        deleted_by: bigint({ mode: "number", unsigned: true }).references(
            (): AnyMySqlColumn => usersTable.id,
        ),
        deleted_at: datetime(),
    },
    (t) => [uniqueIndex("users_email_unique").on(t.email)],
);

export const passwordResetTokensTable = mysqlTable("password_reset_tokens", {
    email: varchar({ length: 255 }).notNull().primaryKey(),
    token: varchar({ length: 255 }).notNull(),
    created_at: timestamp(),
});

export const sessionsTable = mysqlTable(
    "sessions",
    {
        id: varchar({ length: 255 }).notNull().primaryKey(),
        user_id: bigint({ mode: "number", unsigned: true }),
        ip_address: varchar({ length: 45 }),
        user_agent: text(),
        payload: longtext().notNull(),
        last_activity: int().notNull(),
    },
    (t) => [
        index("sessions_user_id_index").on(t.user_id),
        index("sessions_last_activity_index").on(t.last_activity),
    ],
);

export const cacheTable = mysqlTable(
    "cache",
    {
        key: varchar({ length: 255 }).notNull().primaryKey(),
        value: mediumtext().notNull(),
        expiration: bigint({ mode: "number" }).notNull(),
    },
    (t) => [index("cache_expiration_index").on(t.expiration)],
);

export const cacheLocksTable = mysqlTable(
    "cache_locks",
    {
        key: varchar({ length: 255 }).notNull().primaryKey(),
        owner: varchar({ length: 255 }).notNull(),
        expiration: bigint({ mode: "number" }).notNull(),
    },
    (t) => [index("cache_locks_expiration_index").on(t.expiration)],
);

export const jobsTable = mysqlTable(
    "jobs",
    {
        id: bigint({ mode: "number", unsigned: true })
            .autoincrement()
            .primaryKey(),
        queue: varchar({ length: 255 }).notNull(),
        payload: longtext().notNull(),
        attempts: smallint({ unsigned: true }).notNull(),
        reserved_at: int({ unsigned: true }),
        available_at: int({ unsigned: true }).notNull(),
        created_at: int({ unsigned: true }).notNull(),
    },
    (t) => [index("jobs_queue_index").on(t.queue)],
);

export const jobBatchesTable = mysqlTable("job_batches", {
    id: varchar({ length: 255 }).notNull().primaryKey(),
    name: varchar({ length: 255 }).notNull(),
    total_jobs: int().notNull(),
    pending_jobs: int().notNull(),
    failed_jobs: int().notNull(),
    failed_job_ids: longtext().notNull(),
    options: mediumtext(),
    cancelled_at: int(),
    created_at: int().notNull(),
    finished_at: int(),
});

export const failedJobsTable = mysqlTable(
    "failed_jobs",
    {
        id: bigint({ mode: "number", unsigned: true })
            .autoincrement()
            .primaryKey(),
        uuid: varchar({ length: 255 }).notNull(),
        connection: varchar({ length: 255 }).notNull(),
        queue: varchar({ length: 255 }).notNull(),
        payload: longtext().notNull(),
        exception: longtext().notNull(),
        failed_at: timestamp().notNull().defaultNow(),
    },
    (t) => [
        uniqueIndex("failed_jobs_uuid_unique").on(t.uuid),
        index("failed_jobs_connection_queue_failed_at_index").on(
            t.connection,
            t.queue,
            t.failed_at,
        ),
    ],
);

export const sidebarMenuAccessesTable = mysqlTable(
    "sidebar_menu_accesses",
    {
        id: bigint({ mode: "number", unsigned: true })
            .autoincrement()
            .primaryKey(),
        sidebar_menu_id: bigint({ mode: "number", unsigned: true }).notNull(),
        // 1=Superadmin,2=Kepala Sekolah,3=Bendahara,4=Wali Murid,5=Staff
        access_type: tinyint().notNull(),
        created_by: bigint({ mode: "number", unsigned: true }),
        created_at: timestamp(),
    },
    (t) => [
        uniqueIndex(
            "sidebar_menu_accesses_sidebar_menu_id_access_type_unique",
        ).on(t.sidebar_menu_id, t.access_type),
        index("sidebar_menu_accesses_sidebar_menu_id_index").on(
            t.sidebar_menu_id,
        ),
    ],
);

export const sidebarMenuGroupsTable = mysqlTable(
    "sidebar_menu_groups",
    {
        id: bigint({ mode: "number", unsigned: true })
            .autoincrement()
            .primaryKey(),
        key: varchar({ length: 50 }).notNull(),
        label: varchar({ length: 100 }).notNull(),
        color: varchar({ length: 50 }).notNull().default("blue"),
        sort_order: smallint().notNull().default(0),
        created_at: timestamp(),
        updated_at: timestamp(),
    },
    (t) => [uniqueIndex("sidebar_menu_groups_key_unique").on(t.key)],
);

export const sidebarMenusTable = mysqlTable(
    "sidebar_menus",
    {
        id: bigint({ mode: "number", unsigned: true })
            .autoincrement()
            .primaryKey(),
        // Self-referencing, max 1 level deep
        parent_id: bigint({ mode: "number", unsigned: true }),
        label: varchar({ length: 255 }).notNull(),
        // Laravel named route, e.g. admin.dashboard
        route_name: varchar({ length: 255 }),
        // Icon blade include path
        icon: varchar({ length: 255 }),
        // utama|lembaga|keuangan|bendahara
        group: varchar({ length: 50 }).notNull(),
        sort_order: smallint().notNull().default(0),
        is_active: tinyint().notNull().default(1),
        created_by: bigint({ mode: "number", unsigned: true }),
        updated_by: bigint({ mode: "number", unsigned: true }),
        deleted_by: bigint({ mode: "number", unsigned: true }),
        created_at: datetime(),
        updated_at: datetime(),
        deleted_at: datetime(),
    },
    (t) => [
        index("sidebar_menus_parent_id_index").on(t.parent_id),
        index("sidebar_menus_group_sort_order_index").on(t.group, t.sort_order),
    ],
);

export const eventsTable = mysqlTable(
    "events",
    {
        id: unsignedBigInt().autoincrement().primaryKey(),
        name: varchar({ length: 200 }).notNull(),
        slug: varchar({ length: 200 }).notNull(),
        description: text(),
        starts_at: datetime(),
        ends_at: datetime(),
        location: varchar({ length: 255 }),
        status: mysqlEnum(["draft", "published", "archived"])
            .notNull()
            .default("draft"),
        ...auditColumns(),
    },
    (t) => [
        uniqueIndex("uq_events_slug").on(t.slug),
        index("idx_events_status_date").on(t.status, t.starts_at),
    ],
);

export const eventSectionsTable = mysqlTable(
    "event_sections",
    {
        id: unsignedBigInt().autoincrement().primaryKey(),
        event_id: unsignedBigInt()
            .notNull()
            .references(() => eventsTable.id, { onDelete: "cascade" }),
        section_key: varchar({ length: 100 }).notNull(),
        section_type: varchar({ length: 50 }).notNull(),
        title: varchar({ length: 255 }),
        description: text(),
        image_path: varchar({ length: 500 }),
        settings_json: json(),
        sort_order: int({ unsigned: true }).notNull().default(0),
        is_active: boolean().notNull().default(true),
        ...auditColumns(),
    },
    (t) => [
        uniqueIndex("uq_event_section_key").on(t.event_id, t.section_key),
        index("idx_event_sections_display").on(
            t.event_id,
            t.is_active,
            t.sort_order,
        ),
        index("idx_event_sections_type").on(t.event_id, t.section_type),
    ],
);

export const speakersTable = mysqlTable(
    "speakers",
    {
        id: unsignedBigInt().autoincrement().primaryKey(),
        event_id: unsignedBigInt()
            .notNull()
            .references(() => eventsTable.id, { onDelete: "cascade" }),
        name: varchar({ length: 200 }).notNull(),
        photo_path: varchar({ length: 500 }),
        job_title: varchar({ length: 200 }),
        company: varchar({ length: 200 }),
        bio: text(),
        speaker_group: varchar({ length: 50 }),
        sort_order: int({ unsigned: true }).notNull().default(0),
        is_active: boolean().notNull().default(true),
        ...auditColumns(),
    },
    (t) => [
        index("idx_speakers_display").on(t.event_id, t.is_active, t.sort_order),
        index("idx_speakers_name").on(t.event_id, t.name),
    ],
);

export const materialsTable = mysqlTable(
    "materials",
    {
        id: unsignedBigInt().autoincrement().primaryKey(),
        event_id: unsignedBigInt()
            .notNull()
            .references(() => eventsTable.id, { onDelete: "cascade" }),
        title: varchar({ length: 255 }).notNull(),
        slug: varchar({ length: 255 }).notNull(),
        description: text(),
        label: varchar({ length: 100 }),
        label_color: varchar({ length: 20 }),
        sort_order: int({ unsigned: true }).notNull().default(0),
        is_active: boolean().notNull().default(true),
        ...auditColumns(),
    },
    (t) => [
        uniqueIndex("uq_material_event_slug").on(t.event_id, t.slug),
        index("idx_materials_display").on(
            t.event_id,
            t.is_active,
            t.sort_order,
        ),
        index("idx_materials_label").on(t.event_id, t.label),
    ],
);

export const materialSpeakersTable = mysqlTable(
    "material_speakers",
    {
        material_id: unsignedBigInt()
            .notNull()
            .references(() => materialsTable.id, { onDelete: "cascade" }),
        speaker_id: unsignedBigInt()
            .notNull()
            .references(() => speakersTable.id, { onDelete: "cascade" }),
        role: varchar({ length: 50 }).notNull().default("speaker"),
        sort_order: int({ unsigned: true }).notNull().default(0),
        ...auditColumns(),
    },
    (t) => [
        primaryKey({ columns: [t.material_id, t.speaker_id] }),
        index("idx_material_speakers_speaker").on(t.speaker_id),
    ],
);

export const agendaGroupsTable = mysqlTable(
    "agenda_groups",
    {
        id: unsignedBigInt().autoincrement().primaryKey(),
        event_id: unsignedBigInt()
            .notNull()
            .references(() => eventsTable.id, { onDelete: "cascade" }),
        title: varchar({ length: 255 }).notNull(),
        place: varchar({ length: 255 }),
        description: text(),
        sort_order: int({ unsigned: true }).notNull().default(0),
        is_active: boolean().notNull().default(true),
        ...auditColumns(),
    },
    (t) => [
        index("idx_agenda_groups_display").on(
            t.event_id,
            t.is_active,
            t.sort_order,
        ),
    ],
);

export const agendaItemsTable = mysqlTable(
    "agenda_items",
    {
        id: unsignedBigInt().autoincrement().primaryKey(),
        event_id: unsignedBigInt()
            .notNull()
            .references(() => eventsTable.id, { onDelete: "cascade" }),
        agenda_group_id: unsignedBigInt()
            .notNull()
            .references(() => agendaGroupsTable.id, { onDelete: "cascade" }),
        material_id: unsignedBigInt().references(() => materialsTable.id, {
            onDelete: "set null",
        }),
        title: varchar({ length: 255 }),
        category: varchar({ length: 100 }).notNull(),
        starts_at: time().notNull(),
        ends_at: time(),
        place: varchar({ length: 255 }),
        description: text(),
        sort_order: int({ unsigned: true }).notNull().default(0),
        is_active: boolean().notNull().default(true),
        ...auditColumns(),
    },
    (t) => [
        index("idx_agenda_schedule").on(t.event_id, t.is_active, t.starts_at),
        index("idx_agenda_group").on(t.agenda_group_id),
        index("idx_agenda_category").on(t.event_id, t.category),
        index("idx_agenda_material").on(t.material_id),
    ],
);

export const merchandisesTable = mysqlTable(
    "merchandises",
    {
        id: unsignedBigInt().autoincrement().primaryKey(),
        event_id: unsignedBigInt()
            .notNull()
            .references(() => eventsTable.id, { onDelete: "cascade" }),
        name: varchar({ length: 200 }).notNull(),
        photo_path: varchar({ length: 500 }),
        description: text(),
        cta_label: varchar({ length: 100 }),
        cta_url: varchar({ length: 1000 }),
        sort_order: int({ unsigned: true }).notNull().default(0),
        is_active: boolean().notNull().default(true),
        ...auditColumns(),
    },
    (t) => [
        index("idx_merchandises_display").on(
            t.event_id,
            t.is_active,
            t.sort_order,
        ),
        index("idx_merchandises_name").on(t.event_id, t.name),
    ],
);

export const ticketsTable = mysqlTable(
    "tickets",
    {
        id: unsignedBigInt().autoincrement().primaryKey(),
        event_id: unsignedBigInt()
            .notNull()
            .references(() => eventsTable.id, { onDelete: "cascade" }),
        name: varchar({ length: 200 }).notNull(),
        slug: varchar({ length: 200 }).notNull(),
        ticket_type: mysqlEnum(["single", "bundle"])
            .notNull()
            .default("single"),
        price: decimal({ precision: 15, scale: 2 }).notNull(),
        compare_price: decimal({ precision: 15, scale: 2 }),
        description_html: longtext(),
        benefits_json: json(),
        label: varchar({ length: 100 }),
        label_color: varchar({ length: 20 }),
        sales_starts_at: datetime(),
        sales_ends_at: datetime(),
        cta_label: varchar({ length: 100 }).notNull().default("Beli Tiket"),
        cta_url: varchar({ length: 1000 }).notNull(),
        sort_order: int({ unsigned: true }).notNull().default(0),
        is_active: boolean().notNull().default(true),
        ...auditColumns(),
    },
    (t) => [
        uniqueIndex("uq_ticket_event_slug").on(t.event_id, t.slug),
        index("idx_tickets_display").on(t.event_id, t.is_active, t.sort_order),
        index("idx_tickets_sales_period").on(
            t.event_id,
            t.sales_starts_at,
            t.sales_ends_at,
        ),
        index("idx_tickets_label").on(t.event_id, t.label),
    ],
);

export const ticketMerchandisesTable = mysqlTable(
    "ticket_merchandises",
    {
        ticket_id: unsignedBigInt()
            .notNull()
            .references(() => ticketsTable.id, { onDelete: "cascade" }),
        merchandise_id: unsignedBigInt()
            .notNull()
            .references(() => merchandisesTable.id, { onDelete: "cascade" }),
        quantity: int({ unsigned: true }).notNull().default(1),
        ...auditColumns(),
    },
    (t) => [
        primaryKey({ columns: [t.ticket_id, t.merchandise_id] }),
        index("idx_ticket_merchandise_merchandise").on(t.merchandise_id),
    ],
);

export const partnersTable = mysqlTable(
    "partners",
    {
        id: unsignedBigInt().autoincrement().primaryKey(),
        event_id: unsignedBigInt()
            .notNull()
            .references(() => eventsTable.id, { onDelete: "cascade" }),
        partner_type: mysqlEnum([
            "sponsor",
            "media_partner",
            "community_partner",
            "supporting_partner",
        ]).notNull(),
        sponsor_category: mysqlEnum(["gold", "silver", "bronze"]),
        name: varchar({ length: 200 }).notNull(),
        logo_path: varchar({ length: 500 }),
        website_url: varchar({ length: 1000 }),
        sort_order: int({ unsigned: true }).notNull().default(0),
        is_active: boolean().notNull().default(true),
        ...auditColumns(),
    },
    (t) => [
        index("idx_partners_display").on(
            t.event_id,
            t.partner_type,
            t.sponsor_category,
            t.is_active,
            t.sort_order,
        ),
        index("idx_partners_name").on(t.event_id, t.name),
    ],
);
