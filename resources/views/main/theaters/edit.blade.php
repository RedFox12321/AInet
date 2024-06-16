@extends('layouts.main')

@section('header-title', 'Editing ' . $theater->name)

@section('main')
    <div class="flex justify-center items-center h-screen">
        <div class="bg-stone-900 p-8 rounded-[45px] border-2 border-rose-900 shadow-lg">
            <header>
                <h2 class="text-3xl font-semibold font-[Khula] text-stone-900 dark:text-stone-300">
                    Edit Theater
                </h2>
                <p class="mt-1 text-xl font-[Khula] text-stone-800 dark:text-stone-300  mb-6">
                    Click on "Submit" button to store the information.
                </p>
            </header>

            <form action="{{ route('theaters.update', ['theater' => $theater]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('main.theaters.shared.fields', ['mode' => 'edit'])
            </form>
        </div>
    </div>

@endsection
