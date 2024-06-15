@extends('layouts.main')

@section('header-title', 'Theaters')

@section('main')

<div class="flex flex-wrap justify-around">
    <div class="h-max w-max flex fit-content justify-left m-10">

        <x-theaters.filter-card
        :filterAction="route('theaters.index')"
        :resetUrl="route('theaters.index')"
        :name="old('search',$filterByName)"
        :theaters="$theaters->pluck('name', 'name')->toArray()"
        />
            
        {{-- <x-fields.select name="genre" label="Genre"
                     value=App\Models\Genre
                    :options="$listGenre"/> --}}

    </div>

    <div class="flex flex-col">
        <div class="m-10 flex fit-content">
            <x-theaters.table :theaters="$theaters"/>
        </div>
        <div>
            {{ $theaters->links() }}
        </div>
    </div>
    
</div>

@endsection
