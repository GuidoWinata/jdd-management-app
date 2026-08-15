@extends('_admin._layout.app')

@section('title', 'Detail Event')

@section('content')
    <x-admin.page-header :title="$data->name" :backUrl="route('admin.events.index')">
        <x-admin.button href="{{ route('admin.events.update', $data->id) }}">
            @include('_admin._layout.icons.pencil')
            Edit
        </x-admin.button>
    </x-admin.page-header>

    <x-admin.card fit>
        <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500 dark:text-neutral-400">Slug</p>
                <p class="font-medium text-gray-800 dark:text-neutral-200">{{ $data->slug }}</p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-neutral-400">Status</p>
                <p class="font-medium text-gray-800 dark:text-neutral-200">{{ $statuses[$data->status] ?? $data->status }}</p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-neutral-400">Mulai</p>
                <p class="font-medium text-gray-800 dark:text-neutral-200">{{ $data->starts_at ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-neutral-400">Selesai</p>
                <p class="font-medium text-gray-800 dark:text-neutral-200">{{ $data->ends_at ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-neutral-400">Lokasi</p>
                <p class="font-medium text-gray-800 dark:text-neutral-200">{{ $data->location ?? '-' }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-gray-500 dark:text-neutral-400">Deskripsi</p>
                <p class="font-medium text-gray-800 dark:text-neutral-200 whitespace-pre-line">{{ $data->description ?? '-' }}</p>
            </div>
        </div>
    </x-admin.card>
@endsection
