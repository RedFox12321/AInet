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
                @can('admin')
                    @foreach ($employees as $employee)
                        <tr
                            class="@if (!$loop->last) border  border-b-gray-400 border-r-0 @endif bg-zinc-800">
                            <td class="px-2 py-2 text-left">{{ $employee->id }}</td>
                            <td class="px-2 py-2 text-left">{{ $employee->name }}</td>
                            <td class="px-2 py-2 text-left">{{ $employee->email }}</td>
                            <td>
                                <x-table.icon-show class="ps-3 px-0.5"
                                    href="{{ route('employees.show', ['employee' => $employee]) }}" />
                            </td>


                            {{-- @if ($showEdit) --}}
                            {{-- @can('update', $movie) --}}
                            <td>
                                <x-table.icon-edit class="px-0.5" href="{{ route('employees.edit', ['employee' => $employee]) }}" />
                            </td>
                            {{-- @else
                            <td></td>
                        @endcan
                    @endif
                    @if ($showDelete)
                        @can('delete', $movie) --}}
                            <td>
                                <x-table.icon-delete class="px-0.5"
                                    action="{{ route('employees.destroy', ['employee' => $employee]) }}" />
                            </td>
                            {{-- @else
                            <td></td>
                        @endcan
                    @endif --}}
                        </tr>
                    @endforeach
                @endcan
            </tbody>
        </table>
    </div>

</div>
