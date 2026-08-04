<?php

namespace Database\Seeders;

use App\Constants\DatabaseConst;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class JatimDevDaySeeder extends Seeder
{
    /**
     * Seed the scraped Jatim Developer Day data.
     */
    public function run(): void
    {
        $data = File::json(base_path('jatimdevday_scraped_data.json'), JSON_THROW_ON_ERROR);

        DB::transaction(function () use ($data): void {
            $now = now();
            $event = Arr::except($data['events'][0], 'id');

            DB::table(DatabaseConst::EVENT())
                ->where('slug', $event['slug'])
                ->delete();

            $eventId = DB::table(DatabaseConst::EVENT())->insertGetId([
                ...$event,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $eventSections = array_map(fn (array $section): array => [
                ...Arr::except($section, 'id'),
                'event_id' => $eventId,
                'settings_json' => json_encode($section['settings_json'], JSON_THROW_ON_ERROR),
                'created_at' => $now,
                'updated_at' => $now,
            ], $data['event_sections']);
            DB::table(DatabaseConst::EVENT_SECTION())->insert($eventSections);

            $speakerIds = $this->insertEventRecords(
                DB::table(DatabaseConst::SPEAKER()),
                $data['speakers'],
                $eventId,
                $now,
            );
            $materialIds = $this->insertEventRecords(
                DB::table(DatabaseConst::MATERIAL()),
                $data['materials'],
                $eventId,
                $now,
            );

            $materialSpeakers = array_map(fn (array $materialSpeaker): array => [
                ...$materialSpeaker,
                'material_id' => $materialIds[$materialSpeaker['material_id']],
                'speaker_id' => $speakerIds[$materialSpeaker['speaker_id']],
                'created_at' => $now,
                'updated_at' => $now,
            ], $data['material_speakers']);
            DB::table(DatabaseConst::MATERIAL_SPEAKER())->insert($materialSpeakers);

            $agendaItems = array_map(fn (array $agendaItem): array => [
                ...Arr::except($agendaItem, 'id'),
                'event_id' => $eventId,
                'material_id' => $agendaItem['material_id'] === null
                    ? null
                    : $materialIds[$agendaItem['material_id']],
                'created_at' => $now,
                'updated_at' => $now,
            ], $data['agenda_items']);
            DB::table(DatabaseConst::AGENDA_ITEM())->insert($agendaItems);

            $merchandiseIds = $this->insertEventRecords(
                DB::table(DatabaseConst::MERCHANDISE()),
                $data['merchandises'],
                $eventId,
                $now,
            );
            $ticketIds = $this->insertEventRecords(
                DB::table(DatabaseConst::TICKET()),
                $data['tickets'],
                $eventId,
                $now,
            );

            $ticketMerchandises = array_map(fn (array $ticketMerchandise): array => [
                ...$ticketMerchandise,
                'ticket_id' => $ticketIds[$ticketMerchandise['ticket_id']],
                'merchandise_id' => $merchandiseIds[$ticketMerchandise['merchandise_id']],
                'created_at' => $now,
                'updated_at' => $now,
            ], $data['ticket_merchandises']);
            DB::table(DatabaseConst::TICKET_MERCHANDISE())->insert($ticketMerchandises);

            $this->insertEventRecords(
                DB::table(DatabaseConst::PARTNER()),
                $data['partners'],
                $eventId,
                $now,
            );
        });
    }

    /**
     * @param  list<array<string, mixed>>  $records
     * @return array<int, int>
     */
    private function insertEventRecords(Builder $query, array $records, int $eventId, mixed $now): array
    {
        $ids = [];

        foreach ($records as $record) {
            $sourceId = $record['id'];
            $ids[$sourceId] = $query->insertGetId([
                ...Arr::except($record, 'id'),
                'event_id' => $eventId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        return $ids;
    }
}
