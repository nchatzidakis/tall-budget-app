@extends('layouts.app')

@section('content')
    <x-theme.layout.card>
        <x-slot:title>{{ __('Update Expense') }}</x-slot:title>

        <form action="{{ route('expense.update', [tenant(), $expense->id]) }}" method="POST">
            @method('PUT')
            @include('tenant.expense.form')
        </form>


        <form method="post" action="{{ route('expense.destroy', [tenant(), $expense->id]) }}" class="inline-block">
            @csrf
            @method('DELETE')
            <button class="block-inline text-sm text-red-600 border border-red-600 rounded px-2 py-1 mx-2 mb-2 whitespace-nowrap">
                <i class="fa-solid fa-trash"></i>
                {{ __('Delete') }}
            </button>
        </form>

    </x-theme.layout.card>
@endsection
