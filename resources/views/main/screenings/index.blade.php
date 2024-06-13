@extends('layouts.main')

@section('header-title', 'Screenings')

@section('main')

    <div class="justify-left mt-10 ml-10">

        <x-screenings.filter-card 
        :filterAction="route('screenings.index')"
        :resetUrl="route('screenings.index')"
        :title="old('title',$filterByTitleSynopsis)"
        :theater="old('theater', $filterByTheater)"
        :genre="old('genre',$filterByGenre)"
        :date="old('date',$filterByDate)"
        :genres="$genres->pluck('name')->toArray()"
        :theaters="$theaters->pluck('id','name')->toArray()"
        >
            
        </x-screenings.filter-card>

        {{-- <x-fields.select name="genre" label="Genre"
                     value=App\Models\Genre
                    :options="$listGenre"/> --}}

    </div>
@endsection
