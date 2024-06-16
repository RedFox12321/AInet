@extends('layouts.main')

@section('header-title', 'Editing ' . $genre->name)

@section('main')


    
<div class="w-full flex justify-between mt-5 ">
    <div class="overflow-hidden rounded-xl border-4 border-rose-950 flex h-max mt-10 ml-5">
        <table class="table-auto">
            <tbody>
                <tr class="border-b border-b-gray-400 bg-zinc-800">
                    <td class="px-2 py-2 text-left"> {{ $genre->code }} </td>
                    <td class="px-2 py-2 text-left">{{ $genre->name }}</td>
                </tr>
            </tbody>
        </table>
    </div>




    @include('main.genres.shared.fields', ['filterAction'=>route('genres.update',['genre'=>$genre])])

</div>



@endsection
