@extends('layouts.main')

@section('header-title', 'Theater - ' . $theater->name)

@section('main')

    <div class="flex justify-around">
        <form action="{{ route('theaters.update', ['theater' => $theater]) }}" method="GET">
            @csrf
            @include('main.theaters.shared.fields', ['mode' => 'show'])
    
        </form>
    
        <table class="mt-5">
            <thead>
                <tr>
                    <th></th>
                    @foreach ($numbers as $num)
                        <th class="text-2xl">{{ $num }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $row)
                    <tr>
                        <th class="text-2xl">{{ $row }}</th>
                        @foreach ($seatsByNumbers[$row] as $seat)
                            <td class="ml-2 mr-2">
                                <div>
                                    @include('components.seatA')
                                </div>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
   

@endsection
