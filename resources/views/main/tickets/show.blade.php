@extends('layouts.main')

@section('header-title', 'Ticket for ' . $ticket->screening->movie->title)

@section('main')

    @include('main.tickets.shared.fields')

    <div class="mt-10 flex justify-center items-center flex-col">

        <div class="w-max h-max overflow-hidden rounded-xl border-4 border-rose-950">
            <table class="table-auto">
                <thead>
                    <tr class="border-b-2 border-b-gray-400 bg-stone-900 ">
                        <th class="px-2 py-2 text-center">ID</th>
                        <th class="px-2 py-2 text-center">Customer Name</th>
                        <th class="px-2 py-2 text-center">Movie</th>
                        <th class="px-2 py-2 text-center">Seat</th>
                        <th class="px-2 py-2 text-center">Theater</th>
                        <th class="px-2 py-2 text-right">Date</th>
                        <th class="px-2 py-2 text-left">Time</th>
                        <th class="px-2 py-2 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>

                    <tr class="bg-zinc-800">
                        <td class="px-2 py-2 text-center">{{ $ticket->id }}</td>
                        <td class="px-2 py-2 text-center ">{{ $ticket->purchase->customer_name }}</td>
                        <td class="px-2 py-2 text-center ">{{ $ticket->screening->movie->title }}</td>
                        <td class="px-2 py-2 text-center ">{{ $ticket->seat->row }}-{{ $ticket->seat->seat_number }}
                        </td>
                        <td class="px-2 py-2 text-center">{{ $ticket->screening->theater->name }}</td>
                        <td class="px-2 py-2 text-right">{{ $ticket->screening->date }}</td>
                        <td class="px-2 py-2 text-left">{{ $ticket->screening->start_time }}</td>
                        <td class="px-2 py-2 text-center">{{ $ticket->status }}</td>
                    </tr>
                </tbody>
            </table>


        </div>
        @can('update', \App\Models\Ticket::Class)
            @if ($ticket->status == 'valid')
                <div class="px-2 py-2">
                    <form method="POST" action="{{ route('tickets.update', ['ticket' => $ticket]) }}">
                        @csrf
                        @method('PUT')
                        <button type="submit" name="status" value="invalid">
                            <x-button-round class="ps-3 px-0.5">
                                Invalidar Bilhete
                            </x-button-round>
                        </button>
                    </form>
                </div>
            @else
            @endif
        @endcan

    </div>

@endsection
