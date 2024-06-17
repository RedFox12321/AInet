@extends('layouts.main')

@section('header-title', 'Editing screening of ' . $screening->theater->name)

@section('main')

<div class="flex justify-center items-center h-screen">
    <div class="bg-stone-900 p-8 rounded-[45px] border-2 border-rose-900 shadow-lg">
        <header>
            <h2 class="text-3xl font-semibold font-[Khula] text-stone-900 dark:text-stone-300">
                Edit Screening
            </h2>
            <p class="mt-1 text-xl font-[Khula] text-stone-800 dark:text-stone-300">
                Click on "Submit" button to store the information.
            </p>
        </header>
    <div class="w-full flex flex-col items-center">
        <div class="overflow-hidden rounded-xl border-4 border-rose-950 flex fit-content mt-5 ml-5">
            <table class="table-auto">
                <tbody>
                    <tr class="bg-zinc-800">
                        <td class="px-2 py-2 text-left">{{ $screening->movie->title }}</td>
                        <td class="px-2 py-2 text-center hidden md:table-cell">{{ $screening->theater->name }}</td>
                        <td class="px-2 py-2 text-right hidden md:table-cell">{{ $screening->date }}</td>
                        <td class="px-2 py-2 text-left hidden lg:table-cell">{{ $screening->start_time }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        @include('main.screenings.shared.fields', ['filterAction'=>route('screenings.update',['screening'=>$screening])])

    </div>
    </div>
</div>
@endsection
