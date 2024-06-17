<div {{ $attributes }}>
    <div class="w-max h-max overflow-hidden rounded-xl border-4 border-rose-950">
        <table class="table-auto">
            <thead>
                <tr class="border-b-2 border-b-gray-400 bg-stone-900 ">
                    <th class="px-2 py-2 text-left">Code</th>
                    <th class="px-2 py-2 text-center hidden md:table-cell">Name</th>
                    <th class="px-2 py-2 text-center hidden lg:table-cell">Genre</th>
                    <th class="px-2 py-2 text-center">Year</th>
                    <th class="px-2 py-2 text-center"></th>
                {{-- @if ($showEdit) --}}
                    <th></th>
                {{-- @endif --}}
                {{-- @if ($showDelete) --}}
                <th></th>
                {{-- @endif --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($movies as $movie)
                    <tr class="@if (!$loop->last) border-b border-b-gray-400 @endif bg-zinc-800">
                            <td class="px-2 py-2 text-left">{{ $movie->id }}</td>
                            <td class="px-2 py-2 text-center hidden md:table-cell">{{ $movie->title }}</td>
                            <td class="px-2 py-2 text-right hidden lg:table-cell">{{ $movie->genre->name }}</td>
                            <td class="px-2 py-2 text-left">{{ $movie->year }}</td>
                            <td>
                                <x-table.icon-show class="ps-3 px-0.5"
                                href="{{ route('movies.show', ['movie' => $movie]) }}"/>
                            </td>

                    
                    {{-- @if ($showEdit) --}}
                        {{-- @can('update', $movie) --}}
                            <td>
                                <x-table.icon-edit class="px-0.5"
                                href="{{ route('movies.edit', ['movie' => $movie]) }}"/>
                            </td>
                        {{-- @else
                            <td></td>
                        @endcan
                    @endif
                    @if ($showDelete)
                        @can('delete', $movie) --}}
                            <td>
                                <x-table.icon-delete class="px-0.5"
                                action="{{ route('movies.destroy', ['movie' => $movie]) }}"/>
                            </td>
                        {{-- @else
                            <td></td>
                        @endcan
                    @endif --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
