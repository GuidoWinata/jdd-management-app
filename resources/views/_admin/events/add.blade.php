@extends('_admin._layout.app')

@section('title', 'Tambah Event')

@section('content')
    <x-admin.page-header title="Tambah Event" :backUrl="route('admin.events.index')" />

    <x-admin.card fit>
        <form class="p-4" navigate-form action="{{ route('admin.events.create') }}" method="POST">
            @csrf
            @include('_admin.events._form')
        </form>
    </x-admin.card>
@endsection
