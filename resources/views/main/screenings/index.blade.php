@extends('layouts.main')

@section('header-title', 'Screenings')

@section('main')

    <div class="flex flex-wrap">
        <div class="h-max w-max flex fit-content justify-left m-10">

            <x-screenings.filter-card 
            :filterAction="route('screenings.index')"
            :resetUrl="route('screenings.index')"
            :title="old('title',$filterByTitleSynopsis)"
            :theater="old('theater', $filterByTheater)"
            :genre="old('genre',$filterByGenre)"
            :date="old('date',$filterByDate)"
            :genres="$genres->pluck('name','code')->toArray()"
            :theaters="$theaters->pluck('name','id')->toArray()"
            >
                
            </x-screenings.filter-card>
    
    
    
            {{-- <x-fields.select name="genre" label="Genre"
                         value=App\Models\Genre
                        :options="$listGenre"/> --}}
    
        </div>
        
        <div class="justify-right items-right mt-5">
            <x-screenings.table :screenings="$screenings">
            </x-screenings.table>
        </div>
    </div>
    
@endsection
