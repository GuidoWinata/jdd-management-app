@extends('_admin._layout.app')

@section('title', 'Detail ' . $meta['title'])

@section('content')
    <x-admin.page-header :title="'Detail ' . $meta['title']" :backUrl="route($page['route_prefix'] . '.index')">
        <x-admin.button href="{{ route($page['route_prefix'] . '.update', $data->id) }}">
            @include('_admin._layout.icons.pencil')
            Edit
        </x-admin.button>
    </x-admin.page-header>

    <x-admin.card fit>
        <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            @foreach ($fields as $field)
                @php
                    $name = $field['name'];
                    $type = $field['type'];
                    $value = $data->{$name} ?? null;

                    if ($name === 'event_id') {
                        $value = $data->event_name ?? $value;
                    } elseif ($type === 'select') {
                        $value = $field['options'][$value] ?? $value;
                    } elseif (is_bool($value) || $name === 'is_active') {
                        $value = $value ? 'Aktif' : 'Nonaktif';
                    } elseif (is_array($value) || is_object($value)) {
                        $value = json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                    }
                @endphp
                <div class="{{ in_array($field['type'], ['textarea', 'editor', 'agenda-items'], true) ? 'md:col-span-2' : '' }}">
                    <p class="text-gray-500 dark:text-neutral-400">{{ $field['label'] }}</p>
                    @if ($field['type'] === 'editor' && $value)
                        <div class="mt-1 prose dark:prose-invert max-w-none text-gray-800 dark:text-neutral-200 text-sm">
                            {!! $value !!}
                        </div>
                    @elseif ($field['type'] === 'agenda-items')
                        <div class="mt-2 overflow-x-auto rounded-lg border border-gray-200 dark:border-neutral-700">
                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-50 text-left text-gray-500 dark:bg-neutral-800 dark:text-neutral-400">
                                    <tr>
                                        <th class="px-3 py-2 font-medium">Materi</th>
                                        <th class="px-3 py-2 font-medium">Mulai</th>
                                        <th class="px-3 py-2 font-medium">Selesai</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                    @forelse($data->items ?? $data->agenda_items ?? [] as $item)
                                        <tr>
                                            <td class="px-3 py-2 text-gray-800 dark:text-neutral-200">{{ $field['options'][$item->material_id] ?? $item->material_id }}</td>
                                            <td class="px-3 py-2 text-gray-600 dark:text-neutral-400">{{ substr($item->starts_at, 0, 5) }}</td>
                                            <td class="px-3 py-2 text-gray-600 dark:text-neutral-400">{{ $item->ends_at ? substr($item->ends_at, 0, 5) : '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="px-3 py-3 text-gray-500">Belum ada materi.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @elseif ($field['type'] === 'file' && $value)
                        @php
                            $imageUrl = str_starts_with($value, 'http') ? $value : \Illuminate\Support\Facades\Storage::url($value);
                        @endphp
                        <a href="{{ $imageUrl }}" target="_blank" class="inline-block mt-2">
                            <img src="{{ $imageUrl }}" alt="{{ $field['label'] }}" class="max-h-40 rounded-lg border border-gray-200 dark:border-neutral-700">
                        </a>
                    @elseif (is_string($value) && (str_starts_with(trim($value), '{') || str_starts_with(trim($value), '[')))
                        <pre class="mt-1 p-3.5 rounded-xl bg-gray-50 border border-gray-200 dark:bg-neutral-900/60 dark:border-neutral-700/60 font-mono text-xs text-gray-800 dark:text-neutral-200 overflow-x-auto whitespace-pre-wrap">{{ $value }}</pre>
                    @else
                        <p class="font-medium text-gray-800 dark:text-neutral-200 whitespace-pre-line">{{ $value ?: '-' }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </x-admin.card>
@endsection
