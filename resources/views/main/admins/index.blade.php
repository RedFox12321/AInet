@extends('layouts.main')

@section('header-title', 'Admins')

@section('main')

    @php
        $defaultStrokeColor = '#731824';
    @endphp

    <div class="flex justify-center mt-10 flex-col items-center">

        <a href="{{ route('admins.create') }}" class="flex w-max h-max">
            <x-button-round>
                Create new admin
            </x-button-round>
        </a>

        <x-admins.filter-card :filterAction="route('admins.index')" :resetUrl="route('admins.index')" />
    </div>

    <div class="flex flex-wrap justify-center flex-col">
        <div class="h-max w-full flex fit-content justify-center m-10">
            <x-admins.table :admins="$admins" />
        </div>
        <div class="">
            {{ $admins->links() }}
        </div>
    </div>
@endsection
