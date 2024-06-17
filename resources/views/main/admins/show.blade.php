@extends('layouts.main')

@section('header-title', 'Admin - ' . $user->name)

@section('main')
    @can('admin')
    <div class="flex justify-center p-8 bg-stone-700">
        <div class="w-full max-w-5xl grid grid-cols-2 gap-8">
            <!-- Profile Picture -->
            <div class="w-full h-full relative">
                <div class="w-full h-full absolute bg-white opacity-90 border-8 border-stone-300">
                    <figure class="h-full w-full flex flex-col">
                        <img class="h-full w-auto" src="{{ $user->photo_filename }}" alt="{{ $user->name }}">
                    </figure>
                </div>
            </div>

            <!-- Profile Details -->
            <div class="bg-stone-900 p-8 rounded-[45px] border-2 border-rose-900 shadow-lg">
                <h2 class="font[Khula] text-xl">
                    Name:
                </h2>
                <p class="mb-4 text-sm text-stone-600 dark:text-stone-300">{{$user->name}}</p>
                <h2 class="font[Khula] text-xl">
                    E-mail:
                </h2>
                <p class="mb-4 text-sm text-stone-600 dark:text-stone-300">{{$user->email}}</p>
            </div>
        </div>
    </div>

    @endcan

@endsection
