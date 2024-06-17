@extends('layouts.main')

@section('header-title', 'Movie - ' . $movie->title)

@section('main')

    <div class="flex justify-center p-8 bg-stone-700">
        <div class="w-full max-w-5xl grid grid-cols-2 grid-rows-2 gap-8">
            <!-- Movie Poster Top -->
            <div class="col-span-1 h-full space-y-10">
                <div class="col-span-1 row-span-2 w-full h-max relative">
                    <div class="w-full h-max bg-white opacity-90 border-8 border-stone-300">
                        <figure class="h-full w-full flex flex-col">
                            <a class="h-full w-full flex items-center justify-center" href="{{ $movie->trailer_url }}">
                                <img class="h-full w-auto" src="{{ $movie->imageUrl }}" alt="{{ $movie->title }}">
                            </a>
                        </figure>
                    </div>

                </div>

                <div class="flex justify-between">

                    @can('update', \App\Models\Movie::class)
                        <a href="{{ route('movies.edit', ['movie' => $movie]) }}"
                            class="bg-stone-900 p-6 rounded-[45px] border-2 border-rose-900 shadow-lg flex fit-content w-max hover:text-stone-300">
                            <span class="text-3xl flex items-center mr-5">Edit</span>

                            <x-button-round class="flex items-center">
                                <svg class="w-9 h-9" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>

                            </x-button-round>
                        </a>
                    @endcan
                    @can('delete', \App\Models\Movie::class)
                        <a href="{{ route('movies.destroy', ['movie' => $movie]) }}"
                            class="bg-stone-900 p-6 rounded-[45px] border-2 border-rose-900 shadow-lg flex fit-content w-max hover:text-stone-300">
                            <span class="text-3xl flex items-center mr-5">Delete</span>

                            <x-button-round class="flex items-center">
                                <svg class="w-9 h-9" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </x-button-round>
                        </a>
                    @endcan
                </div>

            </div>

            <div class="space-y-5">
                <div class="bg-stone-900 p-8 rounded-[45px] border-2 border-rose-900 shadow-lg">
                    <h1 class="text-3xl font-bold mb-2">{{ $movie->title }}</h1>
                    <p class="mb-4 text-sm text-stone-600 dark:text-stone-300">Year: {{ $movie->year }} &nbsp;&nbsp; Genre:
                        {{ $movie->genre->name }}</p>
                    <p class="mb-4 text-sm text-stone-600 border-t-2 border-rose-900 pt-4 dark:text-stone-300 text-justify">
                        {{ $movie->synopsis }}</p>
    
                    <!-- Button -->
                    @can('viewAny', \App\Models\Screening::class)
                        <div class="mt-8 flex justify-center">
                            <a href="{{ route('screenings.index', ['search' => $movie->title]) }}">
                                <x-button-round>
                                    See all sessions
                                </x-button-round>
                            </a>
                        </div>
                    @endcan
                </div>
    
                <!-- Showtimes -->
                @can('viewAny', \App\Models\Screening::class)
                    <div class="bg-stone-900 p-8 rounded-[45px] border-2 border-rose-900 shadow-lg">
                        <h2 class="text-2xl font-semibold mb-4">Next Sessions:</h2>
                        @if ($screenings->count() == 0)
                            <p>No sessions today!</p>
                        @else
                            <ul class="list-disc list-inside">
                                <x-screenings.table :screenings="$screenings" :showName="false" :showHeader="false" :showPrivilege="false" />
                            </ul>
                        @endif
                    </div>
                @endcan
            </div>
            <!-- Movie Details -->
            


        </div>
    </div>

@endsection
