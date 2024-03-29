@extends('layouts.app')

@section('content')
    <x-theme.layout.card>
        <x-slot:title>{{ tenant()->name }}</x-slot:title>

        {{ __('This will be the dashboard for the vertical.') }}

        <hr />

        <a href="{{ route('account.create') }}" class="bg-green-500 text-white rounded px-3 py-1 mt-2 text-sm">
            {{ __('Please create a new vertical to continue.') }}
        </a>
    </x-theme.layout.card>
@endsection
