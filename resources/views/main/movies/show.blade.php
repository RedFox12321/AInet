@extends('layouts.main')

@section('header-title', 'Movie - ' . $movie->title)

@section('main')

    @include('main.movies.shared.fields')
    <div class="w-[490px] h-[720px] relative">
        <div class="w-full h-full left-10 top-10 absolute bg-white/opacity-10 border-8 border-stone-300 blur-none">
        
            <figure class="h-full w-full flex flex-col p-auto ">
                <a class="h-full w-full items-center items-center"
                    href="{{ route('movies.show', ['movie' => $movie]) }}">
                    <img class="h-full aspect-auto"
                        src="{{ $movie->imageUrl }}">
                </a>
            </figure>
           
        
        </div>
      </div>

@endsection
