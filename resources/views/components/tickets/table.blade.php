<div {{ $attributes }}>
    <div class="w-max h-max overflow-hidden rounded-xl border-4 border-rose-950">
        <table class="table-auto">
            <thead>
                <tr class="border-b-2 border-b-gray-400 bg-stone-900 ">
                    <th class="px-2 py-2 text-center">ID</th>
                    @if (Auth::user()->type != 'C')
                        <th class="px-2 py-2 text-center hidden xl:table-cell">Customer Name</th>
                    @endif
                    <th class="px-2 py-2 text-center lg:table-cell">Movie</th>
                    <th class="px-2 py-2 text-center">Seat</th>
                    <th class="px-2 py-2 text-center">Theater</th>
                    <th class="px-2 py-2 text-right md:table-cell">Date</th>
                    <th class="px-2 py-2 text-left">Time</th>
                    <th class="px-2 py-2 text-center">Status</th>
                    <th class="px-2 py-2 text-center">View</th>
                    @can('update', \App\Models\Ticket::Class)
                        <th class="px-2 py-2 text-right">Invalidate</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                    <tr class="border-b border-b-gray-400 bg-zinc-800">
                        <td class="px-2 py-2 text-center">{{ $ticket->id }}</td>
                        @if (Auth::user()->type != 'C')
                            <td class="px-2 py-2 text-center hidden xl:table-cell">
                                {{ $ticket->purchase->customer_name }}
                        @endif
                        </td>
                        <td class="px-2 py-2 text-center hidden lg:table-cell">{{ $ticket->screening->movie->title }}
                        </td>
                        <td class="px-2 py-2 text-center">
                            {{ $ticket->seat->row }}-{{ $ticket->seat->seat_number }}
                        </td>
                        <td class="px-2 py-2 text-center">
                            {{ $ticket->screening->theater->name}}
                        </td>
                        <td class="px-2 py-2 text-right hidden md:table-cell">{{ $ticket->screening->date }}</td>
                        <td class="px-2 py-2 text-left">{{ $ticket->screening->start_time }}</td>
                        <td class="px-2 py-2 text-center">{{ $ticket->status }}</td>
                        <td class="px-2 py-2 text-center">
                            <x-table.icon-show class="ps-3 px-0.5"
                                href="{{ route('tickets.show', ['ticket' => $ticket]) }}" />
                        </td>
                        @can('update', \App\Models\Ticket::Class)
                            @if ($ticket->status == 'valid')
                                <td class="px-2 py-2 text-right">
                                    <form method="POST" action="{{ route('tickets.update', ['ticket' => $ticket]) }}">
                                        @csrf
                                        @method('PUT')
                                        <input name="status" value="invalid" class="hidden">
                                        <button type="submit">
                                            <x-table.icon-minus class="ps-3 px-0.5" />
                                        </button>
                                    </form>
                                </td>
                            @else
                                <td></td>
                            @endif
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
