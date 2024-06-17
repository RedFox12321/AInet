@extends('layouts.main')

@section('header-title', 'Movies')

@section('main')

    @php
        $defaultStrokeColor = '#731824';
    @endphp

<div class="flex justify-center mt-5">

    <x-movies.filter-card :filterAction="route('movies.index')" :resetUrl="route('movies.index')" :title="old('title', $filterByTitleSynopsis)" :genre="old('genre', $filterByGenre)" :genres="$genres->pluck('name', 'code')->toArray()" />

</div>

<div class="flex flex-wrap justify-center flex-col">
    <div class="h-max w-full flex fit-content justify-center m-10">
        <x-movies.table :movies="$movies" />
    </div>
    <div class="">
        {{ $movies->links() }}
    </div>
</div>
@endsection
