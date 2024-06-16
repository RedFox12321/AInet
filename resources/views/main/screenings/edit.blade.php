@extends('layouts.main')

@section('header-title', 'Editing screening of ' . $screening->theater->name)

@section('main')


    <div class="w-full flex justify-between mt-5 ">
        <div class="overflow-hidden rounded-xl border-4 border-rose-950 flex h-max mt-10 ml-5">
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
@endsection
