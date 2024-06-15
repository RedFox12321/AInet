@extends('layouts.main')

@section('header-title', 'Genres')

@section('main')

<div class="flex flex-wrap justify-around">
    <div class="h-max w-max flex fit-content justify-left m-10">

        <x-genres.filter-card
        :filterAction="route('genres.index')"
        :resetUrl="route('genres.index')"
        :name="old('search',$filterByName)"
        :genres="$genres->pluck('name', 'name')->toArray()"
        />
            
        {{-- <x-fields.select name="genre" label="Genre"
                     value=App\Models\Genre
                    :options="$listGenre"/> --}}

    </div>

    <div class="flex flex-col">
        <div class="m-10 flex fit-content">
            <x-genres.table :genres="$genres"/>
        </div>
        <div>
            {{ $genres->links() }}
        </div>
    </div>
    
</div>

@endsection
