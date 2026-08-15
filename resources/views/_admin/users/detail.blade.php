@extends('_admin._layout.app')

@section('title', 'Detail Pengguna')

@php
    use App\Constants\UserConst;
@endphp

@section('content')
    <x-admin.page-header title="Detail Data Pengguna" :backUrl="route('admin.users.index')">
        <x-admin.button href="{{ route('admin.users.update', $data->id) }}">
            @include('_admin._layout.icons.pencil')
            Edit
        </x-admin.button>
    </x-admin.page-header>

    <x-admin.card fit>
        <div class="p-4">
            <div class="flex items-center gap-x-6 mb-8">
                <div
                    class="inline-flex items-center justify-center size-20 rounded-full bg-blue-100 text-blue-500 text-3xl font-bold dark:bg-blue-800/30 dark:text-blue-400">
                    {{ strtoupper(substr($data->name, 0, 1)) }}
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $data->name }}</h3>
                    <p class="text-gray-500 dark:text-neutral-400">{{ $data->email }}</p>
                    <div class="mt-2">
                        <span
                            class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-neutral-700 dark:text-neutral-200 uppercase">
                            {{ UserConst::getAccessTypes()[$data->access_type] ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div
                    class="p-4 bg-gray-50 rounded-xl dark:bg-neutral-900/40 border border-gray-100 dark:border-neutral-700/60">
                    <p class="text-xs text-gray-500 dark:text-neutral-400 uppercase tracking-wide font-semibold mb-1">
                        Dibuat Pada</p>
                    <p class="text-sm font-medium text-gray-800 dark:text-neutral-200">
                        {{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y, H:i') }}
                    </p>
                    <p class="text-xs text-gray-400 dark:text-neutral-500 mt-0.5">
                        {{ \Carbon\Carbon::parse($data->created_at)->diffForHumans() }}
                    </p>
                </div>

                @if (!empty($data->updated_at))
                    <div
                        class="p-4 bg-gray-50 rounded-xl dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/60">
                        <p
                            class="text-xs text-gray-500 dark:text-neutral-400 uppercase tracking-wide font-semibold mb-1">
                            Terakhir Diupdate</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-neutral-200">
                            {{ \Carbon\Carbon::parse($data->updated_at)->translatedFormat('d F Y, H:i') }}
                        </p>
                        <p class="text-xs text-gray-400 dark:text-neutral-500 mt-0.5">
                            {{ \Carbon\Carbon::parse($data->updated_at)->diffForHumans() }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </x-admin.card>
@endsection
