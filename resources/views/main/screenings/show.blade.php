@extends('layouts.main')

@section('header-title', 'Screening of ' . $screening->movie->title)

@section('main')

    @include('main.screenings.shared.fields')

    <div class="w-full flex justify-between mt-5 ">
        <div class="overflow-hidden rounded-xl border-4 border-rose-950 flex w-max ml-5">
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


        <a href="" class=" bg-rose-900 rounded-3xl border-4 border-rose-950 mr-5 fit-content p-5">
            <div class="flex justify-center items-center text-2xl">Realizar Compra</div>
        </a>
    </div>



    <div class="flex w-full justify-center">
        <div class="w-96 h-8 bg-black rounded-3xl flex items-center justify-center mt-5 mb-5">
            <div class="text-white text-xl font-normal font-['Khula']">Ecrã</div>
        </div>
    </div>

    @dump($seats)

    <div class="flex w-full justify-center">
        <table>
            <thead>
                <tr>
                    <th></th>
                    @foreach ($seats as $seat)
                        <th class="text-2xl">{{ $seat->seat_number }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($seats as $seat)
                    <tr>
                        
                        <td class="text-2xl">{{ $seat->row}}</td>
                        @foreach ($seat->row as $row_index=>$row)
                        
                            <td>
                                <div class="ml-2 mr-2">
                                    <x-menu.menu-icon href="rwar">
                                        <x-slot:icon>
                                            @include('components.seatA')
                                        </x-slot:icon>
                                    </x-menu.menu-icon>
                                </div>

                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>



@endsection
