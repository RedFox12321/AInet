<div {{ $attributes }}>
    <div class="overflow-hidden rounded-xl border-4 border-rose-950">
        <table class="table-auto">
            <thead>
                <tr class="border-b-2 border-b-gray-400 bg-stone-900 ">
                    <th class="px-2 py-2 text-left">Code</th>
                    <th class="px-2 py-2 text-left">Genre Name</th>
                    <th class="px-2 py-2 text-center">View</th>
                    <th class="px-2 py-2 text-center">Edit</th>
                    <th class="px-2 py-2 text-center">Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($genres as $genre)
                    <tr class="border-b border-b-gray-400 bg-zinc-800">
                        <td class="px-2 py-2 text-left"> {{ $genre->code }} </td>
                        <td class="px-2 py-2 text-left">{{ $genre->name }}</td>
                        <td>
                            <x-table.icon-show class="px-0.5 flex justify-center"
                                href="{{ route('genres.show', ['genre' => $genre]) }}" />
                        </td>

                        <td>
                            <x-table.icon-edit class="px-0.5 flex justify-center"
                                href="{{ route('genres.edit', ['genre' => $genre]) }}" />
                        </td>
                        <td>
                            <x-table.icon-delete class="px-0.5 flex justify-center"
                                action="{{ route('genres.destroy', ['genre' => $genre]) }}" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
