<div {{ $attributes }}>
    <div class="overflow-hidden rounded-xl border-4 border-rose-950">
        <table class="table-auto">
            <thead>
                <tr class="border-b-2 border-b-gray-400 bg-stone-900 ">
                    <th class="px-2 py-2 text-left">Name</th>
                    {{-- @if ($showCourse)
                    <th class="px-2 py-2 text-left hidden md:table-cell">Course</th>
                @endif --}}
                    <th class="px-2 py-2 text-center">Theater</th>
                    <th class="px-2 py-2 text-center">Date</th>
                    <th class="px-2 py-2 text-center">Start Time</th>
                    <th class="px-2 py-2 text-center"> </th>
                    {{-- @if ($showView)
                    <th></th>
                @endif
                @if ($showEdit)
                    <th></th>
                @endif
                @if ($showDelete)
                    <th></th>
                @endif
                @can('use-cart')
                    @if ($showAddToCart)
                        <th></th>
                    @endif
                    @if ($showRemoveFromCart)
                        <th></th>
                    @endif
                @endcan --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($screenings as $screening)
                    <tr class="border-b border-b-gray-400 bg-zinc-800">
                            <td class="px-2 py-2 text-left">{{ $screening->movie->title }}</td>
                            <td class="px-2 py-2 text-center hidden md:table-cell">{{ $screening->theater->name }}</td>
                            <td class="px-2 py-2 text-right hidden md:table-cell">{{ $screening->date }}</td>
                            <td class="px-2 py-2 text-left hidden lg:table-cell">{{ $screening->start_time }}</td>
                            <td>
                                <x-table.icon-show class="ps-3 px-0.5"
                                href="{{ route('screenings.show', ['screening' => $screening]) }}"/>
                            </td>

                    {{--
                    @if ($showEdit)
                        @can('update', $screening)
                            <td>
                                <x-table.icon-edit class="px-0.5"
                                href="{{ route('screenings.edit', ['screening' => $screening]) }}"/>
                            </td>
                        @else
                            <td></td>
                        @endcan
                    @endif
                    @if ($showDelete)
                        @can('delete', $screening)
                            <td>
                                <x-table.icon-delete class="px-0.5"
                                action="{{ route('screenings.destroy', ['screening' => $screening]) }}"/>
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
                                    action="{{ route('cart.add', ['screening' => $screening]) }}"/>
                            </td>
                        @endif
                        @if ($showRemoveFromCart)
                            <td>
                                <x-table.icon-minus class="px-0.5"
                                    method="delete"
                                    action="{{ route('cart.remove', ['screening' => $screening]) }}"/>
                            </td>
                        @endif
                    @endcan --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
