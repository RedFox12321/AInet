@extends('layouts.main')

@section('header-title', 'Movies')

@section('main')


    <div class="flex justify-center mt-5">


        @include('components.fields.search-movie')

    </div>

    <div class="mt-10 mb-3 ml-16 text-white opacity-90 text-5xl font-semibold font-['Khula']">
        Filmes em cartaz:
    </div>

    <div class="mx-10 mb-10">
        <x-card-round>
            <x-slot:content>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-7 px-7 py-7 items-start justify-center">
                    @each('main.movies.shared.card', $movies, 'movie')
                </div>
            </x-slot>
        </x-card-round>
    </div>
    




@endsection
