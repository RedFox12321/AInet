@extends('layouts.main')

@section('header-title', 'Movies')

@section('main')

    @php
        $defaultStrokeColor = '#731824';
    @endphp

<div class="flex justify-center mt-5 flex-col items-center">


   
    <x-movies.filter-card :filterAction="route('movies.index')" :resetUrl="route('movies.index')" :title="old('title', $filterByTitleSynopsis)" :genre="old('genre', $filterByGenre)" :genres="$genres->pluck('name', 'code')->toArray()" />


        <a href="{{route('movies.create')}}" class="flex w-max h-max">
            <x-button-round>
                Create new movie
            </x-button-round>    
        </a>
</div>

<div class="flex flex-wrap justify-center flex-col">
    <div class="h-max w-full flex fit-content justify-center mt-10 mb-10">
        <x-movies.table :movies="$movies" />
    </div>
    <div class="">
        {{ $movies->links() }}
    </div>
</div>
@endsection
