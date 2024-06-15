<div {{ $attributes }}>
    <div class="overflow-hidden rounded-xl border-4 border-rose-950">
        <table class="table-auto">
            <thead>
                <tr class="border-b-2 border-b-gray-400 bg-stone-900 ">
                    <th class="px-2 py-2 text-left">Theater Name</th>
                    <th class="px-2 py-2 text-center">View</th>
                    <th class="px-2 py-2 text-center">Edit</th>
                    <th class="px-2 py-2 text-center">Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($theaters as $theater)
                    <tr class="border-b border-b-gray-400 bg-zinc-800">
                        <td class="px-2 py-2 text-left">{{ $theater->name }}</td>
                        <td>
                            <x-table.icon-show class="px-0.5 flex justify-center"
                            href="{{ route('theaters.show', ['theater' => $theater]) }}"/>
                        </td>

                            <td>
                                <x-table.icon-edit class="px-0.5 flex justify-center"
                                href="{{ route('theaters.edit', ['theater' => $theater]) }}"/>
                            </td>
                            <td>
                                <x-table.icon-delete class="px-0.5 flex justify-center"
                                action="{{ route('theaters.destroy', ['theater' => $theater]) }}"/>
                            </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
