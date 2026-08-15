@extends('_admin._layout.app')

@section('title', 'Edit Event')

@section('content')
    <x-admin.page-header :title="'Edit Event: ' . $data->name" :backUrl="route('admin.events.index')" />

    <x-admin.card fit>
        <form class="p-4" navigate-form action="{{ route('admin.events.doUpdate', $data->id) }}" method="POST">
            @csrf
            @include('_admin.events._form')
        </form>
    </x-admin.card>
@endsection
