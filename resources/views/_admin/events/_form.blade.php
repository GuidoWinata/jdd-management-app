@php
    $startsAt = old('starts_at', $data->starts_at ?? null);
    $endsAt = old('ends_at', $data->ends_at ?? null);

    $startsAt = $startsAt ? \Illuminate\Support\Carbon::parse($startsAt)->format('Y-m-d H:i') : null;
    $endsAt = $endsAt ? \Illuminate\Support\Carbon::parse($endsAt)->format('Y-m-d H:i') : null;
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <x-admin.input label="Nama Event" name="name" :value="$data->name ?? null" required />
    <x-admin.input label="Slug" name="slug" :value="$data->slug ?? null" required />

    <x-admin.input label="Lokasi" name="location" :value="$data->location ?? null" />
    <x-admin.select label="Status" name="status" :options="$statuses" :value="$data->status ?? 'draft'" required />

    <x-admin.input label="Mulai" name="starts_at" type="text" :value="$startsAt" class="flatpickr-datetime" />
    <x-admin.input label="Selesai" name="ends_at" type="text" :value="$endsAt" class="flatpickr-datetime" />
</div>

@push('scripts')
    <script>
        (function () {
            function initEventDatepickers() {
                if (!window.flatpickr) {
                    return;
                }

                document.querySelectorAll('.flatpickr-datetime:not([data-flatpickr-ready])').forEach(function (input) {
                    input.dataset.flatpickrReady = '1';
                    window.flatpickr(input, {
                        enableTime: true,
                        dateFormat: 'Y-m-d H:i',
                        altInput: true,
                        altFormat: 'd F Y H:i',
                        allowInput: true,
                        time_24hr: true,
                    });
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initEventDatepickers);
            } else {
                initEventDatepickers();
            }
        })();
    </script>
@endpush

<div class="mt-4 space-y-2">
    <label for="description" class="text-sm text-gray-600 dark:text-neutral-200">Deskripsi</label>
    <textarea id="description" name="description" rows="5"
        class="py-2.5 sm:py-3 px-4 block w-full border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 placeholder-gray-400">{{ old('description', $data->description ?? null) }}</textarea>
</div>

<div class="flex items-center justify-end gap-2 mt-6">
    <x-admin.button href="{{ route('admin.events.index') }}" color="outline-secondary">
        Batal
    </x-admin.button>
    <x-admin.button type="submit">
        Simpan
    </x-admin.button>
</div>
