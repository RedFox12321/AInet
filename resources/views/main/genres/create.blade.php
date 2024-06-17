@extends('layouts.main')

@section('header-title', 'New genre')

@section('main')

    <div class="flex justify-center items-center h-screen mt-3">
        <div class="bg-stone-900 p-8 rounded-[45px] border-2 border-rose-900 shadow-lg">
            <header>
                <h2 class="text-3xl font-semibold font-[Khula] text-stone-900 dark:text-stone-300">
                    Create Genre
                </h2>
                <p class="mt-1 text-xl font-[Khula] text-stone-800 dark:text-stone-300  mb-6">
                    Click on "Submit" button to store the information.
                </p>
            </header>
            <form action="{{ route('genres.store', ['genre' => $genre]) }}" method="POST">
                @csrf
                @include('main.genres.shared.fields', ['mode' => 'create'])
            </form>
        </div>
    </div>

@endsection
