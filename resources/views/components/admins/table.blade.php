<div {{ $attributes }}>
    <div class="w-max h-max overflow-hidden rounded-xl border-4 border-rose-950">
        <table class="table-auto">
            <thead>
                <tr class="border-b-2 border-b-rose-800 bg-stone-900 ">
                    <th class="px-2 py-2 text-left ">ID</th>
                    <th class="px-2 py-2 text-center hidden md:table-cell ">Name</th>
                    <th class="px-2 py-2 text-center hidden lg:table-cell ">E-Mail</th>
                    <th class="px-2 py-2 text-center "></th>
                    {{-- @if ($showEdit) --}}
                    <th class="px-2 py-2 text-center "></th>
                    {{-- @endif --}}
                    {{-- @if ($showDelete) --}}
                    <th class="px-2 py-2 text-center "></th>
                    {{-- @endif --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($admins as $admin)
                    <tr class="@if (!$loop->last) border  border-b-gray-400 border-r-0 @endif bg-zinc-800">
                        <td class="px-2 py-2 text-left">{{ $admin->id }}</td>
                        <td class="px-2 py-2 text-left">{{ $admin->name }}</td>
                        <td class="px-2 py-2 text-left">{{ $admin->email }}</td>
                        <td>
                            <x-table.icon-show class="ps-3 px-0.5"
                                href="{{ route('admins.show', ['admin' => $admin]) }}" />
                        </td>


                        {{-- @if ($showEdit) --}}
                        {{-- @can('update', $movie) --}}
                        <td>
                            <x-table.icon-edit class="px-0.5" href="{{ route('admins.edit', ['admin' => $admin]) }}" />
                        </td>
                        {{-- @else
                            <td></td>
                        @endcan
                    @endif
                    @if ($showDelete)
                        @can('delete', $movie) --}}
                        <td>
                            <x-table.icon-delete class="px-0.5"
                                action="{{ route('admins.destroy', ['admin' => $admin]) }}" />
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
