@extends('_admin._layout.app')

@section('title', 'Tambah ' . $meta['title'])

@section('content')
    @include('_admin.event-contents._assets')

    <x-admin.page-header :title="'Tambah ' . $meta['title']" :subtitle="$resource === 'agenda_groups' ? 'Buat section lalu masukkan materi dan jamnya.' : null" :backUrl="route($page['route_prefix'] . '.index')" />

    <x-admin.card fit>
        <form class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4" navigate-form
            action="{{ route($page['route_prefix'] . '.create') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('_admin.event-contents._form')
        </form>
    </x-admin.card>
@endsection
