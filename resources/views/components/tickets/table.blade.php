<div {{ $attributes }}>
    <div class="w-max h-max overflow-hidden rounded-xl border-4 border-rose-950">
        <table class="table-auto">
            <thead>
                <tr class="border-b-2 border-b-gray-400 bg-stone-900 ">
                    <th class="px-2 py-2 text-center">ID</th>
                    <th class="px-2 py-2 text-center">Customer Name</th>
                    <th class="px-2 py-2 text-center">Movie</th>
                    <th class="px-2 py-2 text-center">Seat</th>
                    <th class="px-2 py-2 text-right">Date</th>
                    <th class="px-2 py-2 text-left">Time</th>
                    <th class="px-2 py-2 text-center">Status</th>
                    <th class="px-2 py-2 text-center">View</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                    <tr class="border-b border-b-gray-400 bg-zinc-800">
                            <td class="px-2 py-2 text-center">{{ $ticket->id }}</td>
                            <td class="px-2 py-2 text-center ">{{ $ticket->purchase->customer_name }}</td>
                            <td class="px-2 py-2 text-center ">{{ $ticket->screening->movie->title }}</td>
                            <td class="px-2 py-2 text-center ">{{ $ticket->seat->row   }}-{{$ticket->seat->seat_number}}</td>
                            <td class="px-2 py-2 text-right">{{ $ticket->screening->date }}</td>
                            <td class="px-2 py-2 text-left">{{ $ticket->screening->start_time }}</td>
                            <td class="px-2 py-2 text-center">{{ $ticket->status }}</td>
                            <td>
                                <x-table.icon-show class="ps-3 px-0.5"
                                href="{{ route('tickets.show', ['ticket' => $ticket]) }}"/>
                            </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
