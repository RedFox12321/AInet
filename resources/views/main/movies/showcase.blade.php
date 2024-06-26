@extends('layouts.main')

@section('header-title', 'Movies')

@section('main')

    <div class="flex justify-center mt-5">

        <x-movies.filter-card :filterAction="route('movies.showcase')" :resetUrl="route('movies.showcase')" :title="old('title', $filterByTitleSynopsis)" :genre="old('genre', $filterByGenre)" :genres="$genres->pluck('name', 'code')->toArray()" />

    </div>

    @can('view-any', App\Models\Movie::class)
    <div class="w-full flex justify-center">
        <a class="text-white opacity-90 text-5xl font-semibold font-['Khula']" href="{{ route('movies.index') }}">
            <x-button-round>
                See movie list
            </x-button-round>
        </a>
    </div>
    
    @endcan

    <div class="mt-10 mb-3 ml-16 text-white opacity-90 text-5xl font-semibold font-['Khula']">
        Movies on display:
    </div>

    <div class="mx-10 mb-10">
        <x-card-round>
            <x-slot:content>
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-7 px-7 py-7 items-start justify-center">
                    @each('main.movies.shared.card', $movies, 'movie')
                </div>
            </x-slot>
        </x-card-round>
    </div>

    <div class="flex mt-4 justify-center">
        {{ $movies->links() }}
    </div>




@endsection
