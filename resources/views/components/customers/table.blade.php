<div {{ $attributes }}>
    <div class="overflow-hidden rounded-xl border-4 border-rose-950">
        <table class="table-auto">
            <thead>
                <tr class="border-b-2 border-b-gray-400 bg-stone-900 ">
                    <th class="px-2 py-2 text-left">ID</th>
                    <th class="px-2 py-2 text-left">Name</th>
                    <th class="px-2 py-2 text-left">Status</th>
                    <th class="px-2 py-2 text-center">Change Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                    <tr class="border-b border-b-gray-400 bg-zinc-800">
                        <td class="px-2 py-2 text-left"> {{ $customer->id }} </td>
                        <td class="px-2 py-2 text-left">{{ $customer->user->name }}</td>
                        <td class="px-2 py-2 text-center">{{ $customer->user->blocked }}</td>
                        @if($customer->user->blocked==1)    
                        <td class="px-2 py-2 text-center">
                                <form method="POST"
                                    action="{{ route('customers.update', ['customer' => $customer]) }}">
                                    @csrf
                                    @method('PUT')
                                    <input value="0" class="hidden" name="blocked">
                                    <button type="submit">
                                        <x-table.icon-minus class="ps-3 px-0.5" />
                                    </button>
                                </form>
                            </td>
                        @else
                            <td class="px-2 py-2 text-center">
                                <form method="POST"
                                    action="{{ route('customers.update', ['customer' => $customer]) }}">
                                    @csrf
                                    @method('PUT')
                                    <input value="1" class="hidden" name="blocked">
                                    <button type="submit">
                                        <x-table.icon-minus class="ps-3 px-0.5" />
                                    </button>
                                </form>
                            </td>
                            @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
