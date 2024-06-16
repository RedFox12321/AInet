<div {{ $attributes }}>
    <div class="overflow-hidden rounded-xl border-4 border-rose-950">
        <table class="table-auto">
            <thead>
                <tr class="border-b-2 border-b-gray-400 bg-stone-900 ">
                    <th class="px-2 py-2 text-left">Name</th>
                    <th class="px-2 py-2 hidden md:table-cell text-center">Theater</th>
                    <th class="px-2 py-2 hidden lg:table-cell text-center">Date</th>
                    <th class="px-2 py-2 text-left">Start Time</th>
                    <th class="px-2 py-2 text-center"></th>
                    @can('update', \App\Models\Screening::class)
                        <th class="px-2 py-2 text-center"></th>
                    @endcan
                    @can('delete', \App\Models\Screening::class)
                        <th class="px-2 py-2 text-center"></th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($screenings as $screening)
                    <tr class="border-b border-b-gray-400 bg-zinc-800">
                        <td class="px-2 py-2 text-left">{{ $screening->movie->title }}</td>
                        <td class="px-2 py-2 text-center hidden md:table-cell">{{ $screening->theater->name }}</td>
                        <td class="px-2 py-2 text-right hidden lg:table-cell">{{ $screening->date }}</td>
                        <td class="px-2 py-2 text-left">{{ $screening->start_time }}</td>
                        <td>
                            <x-table.icon-show class="ps-3 px-0.5"
                                href="{{ route('screenings.show', ['screening' => $screening]) }}" />
                        </td>
                        @can('update', \App\Models\Screening::class)
                            <td>
                                <x-table.icon-edit class="px-0.5 flex justify-center"
                                    href="{{ route('screenings.edit', ['screening' => $screening]) }}" />
                            </td>
                        @endcan
                        @can('delete', \App\Models\Screening::class)
                            <td>
                                <x-table.icon-delete class="px-0.5 flex justify-center"
                                    action="{{ route('screenings.destroy', ['screening' => $screening]) }}" />
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
