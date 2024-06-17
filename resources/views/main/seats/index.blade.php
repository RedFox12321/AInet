@extends('layouts.main')

@section('header-title', 'Seats')

@section('main')

<div class="flex flex-wrap justify-around">
    <div class="h-max w-max flex fit-content justify-left m-10">

        <div class="flex flex-col items-center ">
            {{-- <a href="https://www.youtube.com/watch?v=xvFZjo5PgG0" class="flex w-max h-max mb-5">
                <x-button-round>
                    Create new seat
                </x-button-round>    
            </a> --}}

        <x-seats.filter-card
        :filterAction="route('seats.index')"
        :resetUrl="route('seats.index')"
        :theater="old('theater', $filterByTheater)"
        :theaters="$theaters->pluck('name', 'name')->toArray()"
        />

    </div>

    </div>
    <div class="flex flex-col">
        <div class="m-10 w-max h-max">
            <x-seats.table :seats="$seatsByNumbers" :numbers="$numbers" :rows="$rows"/>
        </div>
        <div>
            {{-- {{ $seatsByNumbers->links() }} --}}
        </div>
    </div>
    
</div>

@endsection
