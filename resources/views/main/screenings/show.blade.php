@extends('layouts.main')

@section('header-title', 'Screening of ' . $screening->movie->title)

@section('main')

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

        @can('useCart')
            <a href="{{ route('cart.show') }}" class=" bg-rose-900 rounded-3xl border-4 border-rose-950 mr-5 fit-content p-5">
                <div class="flex justify-center items-center text-2xl">Proceed to payment</div>
            </a>
        @endcan
    </div>



    <div class="flex w-full justify-center">
        <div class="w-96 h-8 bg-black rounded-3xl flex items-center justify-center mt-5 mb-5">
            <div class="text-white text-xl font-normal font-['Khula']">Ecrã</div>
        </div>
    </div>



    <div class="flex w-full justify-center">
        <table>
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
                            @if ($seat == null)
                                <td class="ml-2 mr-2">
                                    @php
                                        $isTaken = $seatsTaken->contains($seat->id);
                                    @endphp
                                    <div>
                                        @can('useCart')
                                            @if ($isTaken)
                                                @include('components.seatA', ['taken' => true])
                                            @else
                                                <form method="POST"
                                                    action="{{ route('cart.add', ['screening' => $screening, 'seat' => $seat]) }}">
                                                    @csrf
                                                    <button type="submit" name="add_cart">
                                                        @include('components.seatA')
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            @include('components.seatA')
                                        @endcan
                                    </div>
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
