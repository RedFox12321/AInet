@extends('layouts.main')

@section('header-title', 'Screenings')

@section('main')

    <div class="flex flex-wrap justify-around">
        <div class="h-max w-max flex fit-content justify-left m-10">

            <x-screenings.filter-card
            :filterAction="route('screenings.index')"
            :resetUrl="route('screenings.index')"
            :title="old('search',$filterByTitleSynopsis)"
            :theater="old('theater', $filterByTheater)"
            :genre="old('genre',$filterByGenre)"
            :date="old('date',$filterByDate)"
            :genres="$genres->pluck('name','code')->toArray()"
            :theaters="$theaters->pluck('name', 'name')->toArray()"
            />
                
            {{-- <x-fields.select name="genre" label="Genre"
                         value=App\Models\Genre
                        :options="$listGenre"/> --}}

        </div>

        <div class="m-10">
            <x-screenings.table :screenings="$screenings"/>
        </div>
        <div class="mt-4">
            {{ $screenings->links() }}
        </div>
    </div>

@endsection
