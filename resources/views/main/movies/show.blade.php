@extends('layouts.main')

@section('header-title', 'Movie - ' . $movie->title)

@section('main')

    <div class="flex justify-center p-8 bg-stone-700">
        <div class="w-full max-w-5xl grid grid-cols-2 grid-rows-2 gap-8">
            <!-- Movie Poster Top -->
            <div class="col-span-1 row-span-2 w-full h-full relative">
                <div class="w-full h-full absolute bg-white opacity-90 border-8 border-stone-300">
                    <figure class="h-full w-full flex flex-col">
                        <a class="h-full w-full flex items-center justify-center" href="{{ $movie->trailer_url }}">
                            <img class="h-full w-auto" src="{{ $movie->imageUrl }}" alt="{{ $movie->title }}">
                        </a>
                    </figure>
                </div>
            </div>

            <!-- Movie Details -->
            <div class="bg-stone-900 p-8 rounded-[45px] border-2 border-rose-900 shadow-lg">
                <h1 class="text-3xl font-bold mb-2">{{ $movie->title }}</h1>
                <p class="mb-4 text-sm text-stone-600 dark:text-stone-300">Year: {{ $movie->year }} &nbsp;&nbsp; Genre:
                    {{ $movie->genre->name }}</p>
                <p class="mb-4 text-sm text-stone-600 border-t-2 border-rose-900 pt-4 dark:text-stone-300 text-justify">
                    {{ $movie->synopsis }}</p>

                <!-- Button -->
                <div class="mt-8 flex justify-center">
                    <a href="{{ route('screenings.index', ['search' => $movie->title]) }}">
                        <x-button-round>
                            See all sessions
                        </x-button-round>
                    </a>
                </div>
            </div>

            <!-- Showtimes -->
            <div class="bg-stone-900 p-8 rounded-[45px] border-2 border-rose-900 shadow-lg">
                <h2 class="text-2xl font-semibold mb-4">Next Sessions:</h2>
                <ul class="list-disc list-inside">
                    <x-screenings.table :screenings="$screenings" :showHeader="false" :showPrivilege="false" />
                </ul>
            </div>
        </div>
    </div>

@endsection
