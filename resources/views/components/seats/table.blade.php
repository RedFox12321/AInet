<div {{ $attributes }}>
    <div class="overflow-hidden rounded-xl border-4 border-rose-950">
        <table class="table-auto">
            <thead>
                <tr class="border-b-2 border-b-gray-400 bg-stone-900 ">
                    <th class="px-2 py-2 text-left">Row</th>
                    <th class="w-full px-2 py-2 text-center" colspan="{{ count($numbers) }}">Seat Numbers</th>

                @foreach($numbers as $number)
                @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $row)
                    <tr class="border-b border-b-gray-400 bg-zinc-800">
                        <th class="px-2 py-2 text-left">{{ $row }}</th>
                        @foreach ($numbers as $number)
                            <td class="px-2 py-2 text-center">{{ $number }}</td>
                        @endforeach
                    </tr>



                    @foreach ($seats as $seat)
                        <td>
                            {{-- <x-table.icon-show class="ps-3 px-0.5" href="{{ route('seats.show', ['seat' => $seat]) }}" /> --}}
                        </td>
                    @endforeach
                    {{--
                    @if ($showEdit)
                        @can('update', $seat)
                            <td>
                                <x-table.icon-edit class="px-0.5"
                                href="{{ route('seats.edit', ['seat' => $seat]) }}"/>
                            </td>
                        @else
                            <td></td>
                        @endcan
                    @endif
                    @if ($showDelete)
                        @can('delete', $seat)
                            <td>
                                <x-table.icon-delete class="px-0.5"
                                action="{{ route('seats.destroy', ['seat' => $seat]) }}"/>
                            </td>
                        @else
                            <td></td>
                        @endcan
                    @endif
                    @can('use-cart')
                        @if ($showAddToCart)
                            <td>
                                <x-table.icon-add-cart class="px-0.5"
                                    method="post"
                                    action="{{ route('cart.add', ['seat' => $seat]) }}"/>
                            </td>
                        @endif
                        @if ($showRemoveFromCart)
                            <td>
                                <x-table.icon-minus class="px-0.5"
                                    method="delete"
                                    action="{{ route('cart.remove', ['seat' => $seat]) }}"/>
                            </td>
                        @endif
                    @endcan --}}
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</div>
