@extends('layouts.main')

@section('header-title', 'Employees')

@section('main')

    @php
        $defaultStrokeColor = '#731824';
    @endphp

    <div class="flex justify-center mt-10 flex-col items-center">

        <a href="{{ route('employees.create') }}" class="flex w-max h-max">
            <x-button-round>
                Create new employee
            </x-button-round>
        </a>
        <x-employees.filter-card :filterAction="route('employees.index')" :resetUrl="route('employees.index')" />
    </div>

    <div class="flex flex-wrap justify-center flex-col">
        <div class="h-max w-full flex fit-content justify-center m-10">
            <x-employees.table :employees="$employees" />
        </div>
        <div class="">
            {{ $employees->links() }}
        </div>
    </div>
@endsection
