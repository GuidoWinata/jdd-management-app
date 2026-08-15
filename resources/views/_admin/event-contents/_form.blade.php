@foreach ($fields as $field)
    @php
        $name = $field['name'];
        $type = $field['type'];
        $value = old($name, $data->{$name} ?? ($name === 'is_active' ? 1 : null));

        if ($name === 'benefits') {
            $value = old('benefits', $data->benefits_json ?? []);
        }

        if (($name === 'settings_json') && (is_array($value) || is_object($value))) {
            $value = json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        if ($value && in_array($type, ['datetime-local'], true)) {
            $value = \Illuminate\Support\Carbon::parse($value)->format('Y-m-d H:i');
        }
    @endphp

    @if ($type === 'file')
        <div class="space-y-2" data-field-name="{{ $name }}">
            <label for="{{ $name }}" class="text-sm text-gray-600 dark:text-neutral-200">{{ $field['label'] }}</label>
            <input id="{{ $name }}" name="{{ $name }}" type="file" accept="image/jpeg,image/png,image/webp"
                class="block w-full text-sm text-gray-600 file:me-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:text-neutral-400 dark:file:bg-blue-900/20 dark:file:text-blue-400">
            @if ($value)
                @php
                    $imageUrl = str_starts_with($value, 'http') ? $value : \Illuminate\Support\Facades\Storage::url($value);
                @endphp
                <a href="{{ $imageUrl }}" target="_blank" class="inline-flex text-xs text-blue-600 hover:text-blue-700 dark:text-blue-400">
                    {{ $value }}
                </a>
            @endif
        </div>
    @elseif ($type === 'textarea')
        <div class="space-y-2 md:col-span-2" data-field-name="{{ $name }}">
            <label for="{{ $name }}" class="text-sm text-gray-600 dark:text-neutral-200">
                {{ $field['label'] }}
                @if ($field['required'] ?? false)
                    <span class="text-red-500">*</span>
                @endif
            </label>
            <textarea id="{{ $name }}" name="{{ $name }}" rows="5"
                class="py-2.5 sm:py-3 px-4 block w-full border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 placeholder-gray-400">{{ $value }}</textarea>
        </div>
    @elseif ($type === 'editor')
        <div class="space-y-2 md:col-span-2" data-field-name="{{ $name }}">
            <label for="{{ $name }}" class="text-sm text-gray-600 dark:text-neutral-200">{{ $field['label'] }}</label>
            <textarea id="{{ $name }}" name="{{ $name }}" class="js-editor">{!! $value !!}</textarea>
        </div>
    @elseif ($type === 'benefits')
        @php
            $benefits = collect(is_array($value) ? $value : [])->filter()->values();
            $benefits = $benefits->isEmpty() ? collect(['']) : $benefits;
        @endphp
        <div class="space-y-2 md:col-span-2" data-field-name="{{ $name }}">
            <label class="text-sm text-gray-600 dark:text-neutral-200">{{ $field['label'] }}</label>
            <div class="js-benefit-list space-y-2">
                @foreach ($benefits as $benefit)
                    <div class="flex items-center gap-2 js-benefit-row">
                        <input name="benefits[]" value="{{ $benefit }}" type="text"
                            class="py-2.5 sm:py-3 px-4 block w-full border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 placeholder-gray-400"
                            placeholder="Snack, Lunch, e-Certificate">
                        <button type="button"
                            class="js-remove-benefit shrink-0 size-10 inline-flex items-center justify-center rounded-lg border border-gray-200 text-red-600 hover:bg-red-50 dark:border-neutral-700 dark:text-red-400 dark:hover:bg-red-900/20"
                            title="Hapus">
                            @include('_admin._layout.icons.trash')
                        </button>
                    </div>
                @endforeach
            </div>
            <button type="button" class="js-add-benefit text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400">
                Tambah benefit
            </button>
        </div>
    @elseif ($type === 'merchandise-addons')
        @php
            $addonRows = collect(old('merchandise_addons', $data->merchandises ?? []))
                ->map(fn ($addon) => [
                    'merchandise_id' => is_array($addon) ? $addon['merchandise_id'] ?? $addon['id'] ?? null : ($addon->merchandise_id ?? $addon->id ?? null),
                    'quantity' => is_array($addon) ? $addon['quantity'] ?? 1 : ($addon->quantity ?? 1),
                ])
                ->filter(fn ($addon) => $addon['merchandise_id'])
                ->values();
            $addonRows = $addonRows->isEmpty() ? collect([['merchandise_id' => '', 'quantity' => 1]]) : $addonRows;
        @endphp
        <div class="space-y-2 md:col-span-2" data-field-name="{{ $name }}">
            <label class="text-sm text-gray-600 dark:text-neutral-200">{{ $field['label'] }}</label>
            <div class="js-merchandise-addon-list space-y-2" data-next-index="{{ $addonRows->count() }}">
                @foreach ($addonRows as $index => $addon)
                    <div class="grid grid-cols-1 sm:grid-cols-[1fr_120px_auto] gap-2 js-merchandise-addon-row">
                        <select name="merchandise_addons[{{ $index }}][merchandise_id]"
                            class="js-select2 py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                            <option value="">-</option>
                            @foreach ($field['options'] as $optionValue => $text)
                                <option value="{{ $optionValue }}" {{ (string) $addon['merchandise_id'] === (string) $optionValue ? 'selected' : '' }}>
                                    {{ $text }}
                                </option>
                            @endforeach
                        </select>
                        <input name="merchandise_addons[{{ $index }}][quantity]" value="{{ $addon['quantity'] }}" type="number" min="1"
                            class="py-2.5 sm:py-3 px-4 block w-full border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                        <button type="button"
                            class="js-remove-merchandise-addon size-10 inline-flex items-center justify-center rounded-lg border border-gray-200 text-red-600 hover:bg-red-50 dark:border-neutral-700 dark:text-red-400 dark:hover:bg-red-900/20"
                            title="Hapus">
                            @include('_admin._layout.icons.trash')
                        </button>
                    </div>
                @endforeach
            </div>
            <template id="merchandise-addon-template">
                <div class="grid grid-cols-1 sm:grid-cols-[1fr_120px_auto] gap-2 js-merchandise-addon-row">
                    <select name="merchandise_addons[__INDEX__][merchandise_id]"
                        class="js-select2 py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                        <option value="">-</option>
                        @foreach ($field['options'] as $optionValue => $text)
                            <option value="{{ $optionValue }}">{{ $text }}</option>
                        @endforeach
                    </select>
                    <input name="merchandise_addons[__INDEX__][quantity]" value="1" type="number" min="1"
                        class="py-2.5 sm:py-3 px-4 block w-full border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                    <button type="button"
                        class="js-remove-merchandise-addon size-10 inline-flex items-center justify-center rounded-lg border border-gray-200 text-red-600 hover:bg-red-50 dark:border-neutral-700 dark:text-red-400 dark:hover:bg-red-900/20"
                        title="Hapus">
                        @include('_admin._layout.icons.trash')
                    </button>
                </div>
            </template>
            <button type="button" class="js-add-merchandise-addon text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400">
                Tambah merchandise
            </button>
        </div>
    @elseif ($type === 'agenda-items')
        @php
            $agendaRows = collect(old('agenda_items', $data->items ?? $data->agenda_items ?? []))
                ->map(fn ($item) => [
                    'id' => is_array($item) ? $item['id'] ?? null : ($item->id ?? null),
                    'material_id' => is_array($item) ? $item['material_id'] ?? null : ($item->material_id ?? null),
                    'starts_at' => is_array($item) ? $item['starts_at'] ?? null : ($item->starts_at ?? null),
                    'ends_at' => is_array($item) ? $item['ends_at'] ?? null : ($item->ends_at ?? null),
                ])
                ->values();
            $agendaRows = $agendaRows->isEmpty() ? collect([['id' => null, 'material_id' => '', 'starts_at' => '', 'ends_at' => '']]) : $agendaRows;
        @endphp
        <div class="space-y-2 md:col-span-2" data-field-name="{{ $name }}">
            <div class="flex items-center justify-between gap-3">
                <label class="text-sm font-medium text-gray-700 dark:text-neutral-200">{{ $field['label'] }}</label>
                <button type="button" class="js-add-agenda-item inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400">
                    @include('_admin._layout.icons.add')
                    Tambah materi
                </button>
            </div>
            <div class="hidden lg:grid lg:grid-cols-[minmax(0,1fr)_130px_130px_40px] gap-2 px-3 text-xs font-medium text-gray-500 dark:text-neutral-400">
                <span>Materi</span>
                <span>Mulai</span>
                <span>Selesai</span>
                <span></span>
            </div>
            <div class="js-agenda-item-list space-y-2" data-next-index="{{ $agendaRows->count() }}">
                @foreach ($agendaRows as $index => $item)
                    <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,1fr)_130px_130px_auto] gap-2 rounded-lg border border-gray-200 p-3 dark:border-neutral-700 js-agenda-item-row">
                        <input type="hidden" name="agenda_items[{{ $index }}][id]" value="{{ $item['id'] }}">
                        <select name="agenda_items[{{ $index }}][material_id]"
                            class="js-select2 py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                            <option value="">- Pilih materi -</option>
                            @foreach ($field['options'] as $optionValue => $text)
                                <option value="{{ $optionValue }}" {{ (string) $item['material_id'] === (string) $optionValue ? 'selected' : '' }}>
                                    {{ $text }}
                                </option>
                            @endforeach
                        </select>
                        <input name="agenda_items[{{ $index }}][starts_at]" value="{{ $item['starts_at'] ? substr($item['starts_at'], 0, 5) : '' }}" type="text"
                            class="flatpickr-time py-2.5 sm:py-3 px-4 block w-full border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                            placeholder="Mulai">
                        <input name="agenda_items[{{ $index }}][ends_at]" value="{{ $item['ends_at'] ? substr($item['ends_at'], 0, 5) : '' }}" type="text"
                            class="flatpickr-time py-2.5 sm:py-3 px-4 block w-full border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                            placeholder="Selesai">
                        <button type="button"
                            class="js-remove-agenda-item size-10 inline-flex items-center justify-center rounded-lg border border-gray-200 text-red-600 hover:bg-red-50 dark:border-neutral-700 dark:text-red-400 dark:hover:bg-red-900/20"
                            title="Hapus">
                            @include('_admin._layout.icons.trash')
                        </button>
                    </div>
                @endforeach
            </div>
            <template id="agenda-item-template">
                <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,1fr)_130px_130px_auto] gap-2 rounded-lg border border-gray-200 p-3 dark:border-neutral-700 js-agenda-item-row">
                    <input type="hidden" name="agenda_items[__INDEX__][id]" value="">
                    <select name="agenda_items[__INDEX__][material_id]"
                        class="js-select2 py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                        <option value="">- Pilih materi -</option>
                        @foreach ($field['options'] as $optionValue => $text)
                            <option value="{{ $optionValue }}">{{ $text }}</option>
                        @endforeach
                    </select>
                    <input name="agenda_items[__INDEX__][starts_at]" value="" type="text"
                        class="flatpickr-time py-2.5 sm:py-3 px-4 block w-full border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                        placeholder="Mulai">
                    <input name="agenda_items[__INDEX__][ends_at]" value="" type="text"
                        class="flatpickr-time py-2.5 sm:py-3 px-4 block w-full border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                        placeholder="Selesai">
                    <button type="button"
                        class="js-remove-agenda-item size-10 inline-flex items-center justify-center rounded-lg border border-gray-200 text-red-600 hover:bg-red-50 dark:border-neutral-700 dark:text-red-400 dark:hover:bg-red-900/20"
                        title="Hapus">
                        @include('_admin._layout.icons.trash')
                    </button>
                </div>
            </template>
        </div>
    @elseif ($type === 'select')
        @if (($field['select2_tags'] ?? false) && $value && !array_key_exists((string) $value, $field['options']))
            @php
                $field['options'] = [$value => $value] + $field['options'];
            @endphp
        @endif
        <div data-field-name="{{ $name }}">
            <x-admin.select :label="$field['label']" :name="$name" :options="$field['options']" :value="$value" :required="$field['required'] ?? false"
                class="{{ !empty($field['select2']) || !empty($field['select2_tags']) ? 'js-select2' : '' }}"
                data-select2-tags="{{ !empty($field['select2_tags']) ? '1' : '0' }}" />
        </div>
    @elseif ($type === 'checkbox')
        <div class="space-y-2" data-field-name="{{ $name }}">
            <input type="hidden" name="{{ $name }}" value="0">
            <div class="text-sm text-gray-600 dark:text-neutral-200">{{ $field['label'] }}</div>
            <label for="{{ $name }}" class="inline-flex items-center cursor-pointer">
                <input id="{{ $name }}" name="{{ $name }}" type="checkbox" value="1" class="peer sr-only"
                    {{ (bool) $value ? 'checked' : '' }}>
                <span
                    class="relative h-6 w-11 rounded-full bg-gray-200 transition after:absolute after:left-0.5 after:top-0.5 after:size-5 after:rounded-full after:bg-white after:transition peer-checked:bg-blue-600 peer-checked:after:translate-x-5 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 peer-focus:ring-offset-2 dark:bg-neutral-700 dark:peer-focus:ring-offset-neutral-900"></span>
            </label>
        </div>
    @elseif ($type === 'money')
        <div data-field-name="{{ $name }}">
            <x-admin.input :label="$field['label']" :name="$name" type="text" :value="$value" :required="$field['required'] ?? false"
                class="js-money" inputmode="numeric" />
        </div>
    @else
        @if ($type === 'number')
            <div data-field-name="{{ $name }}">
                <x-admin.input :label="$field['label']" :name="$name" :type="$type" :value="$value" :required="$field['required'] ?? false" step="1" />
            </div>
        @elseif ($type === 'datetime-local')
            <div data-field-name="{{ $name }}">
                <x-admin.input :label="$field['label']" :name="$name" type="text" :value="$value" :required="$field['required'] ?? false"
                    class="flatpickr-datetime" />
            </div>
        @else
            <div data-field-name="{{ $name }}">
                <x-admin.input :label="$field['label']" :name="$name" :type="$type" :value="$value" :required="$field['required'] ?? false" />
            </div>
        @endif
    @endif
@endforeach

<div class="md:col-span-2 flex items-center justify-end gap-2 mt-2">
    <x-admin.button href="{{ route($page['route_prefix'] . '.index') }}" color="outline-secondary">
        Batal
    </x-admin.button>
    <x-admin.button type="submit">
        Simpan
    </x-admin.button>
</div>
