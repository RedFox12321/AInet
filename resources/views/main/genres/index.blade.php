@extends('layouts.main')

@section('header-title', 'Genres')

@section('main')

    <div class="flex flex-wrap justify-around">
        <div class="h-max w-max flex fit-content justify-left m-10">

            <div class="flex flex-col items-center ">
                <a href="{{ route('genres.create') }}" class="flex w-max h-max mb-5">
                    <x-button-round>
                        Create new genre
                    </x-button-round>
                </a>

                <x-genres.filter-card :filterAction="route('genres.index')" :resetUrl="route('genres.index')" :name="old('search', $filterByName)" :genres="$genres->pluck('name', 'name')->toArray()" />

            </div>
        </div>

        <div class="flex flex-col">
            <div class="m-10 flex fit-content">
                <x-genres.table :genres="$genres" />
            </div>
            <div>
                {{ $genres->links() }}
            </div>
        </div>

    </div>

@endsection
