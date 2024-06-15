<div {{ $attributes }}>
    <div class="w-max h-max overflow-hidden rounded-xl border-4 border-rose-950">
        <table class="table-auto">
            <thead>
                <tr class="border-b-2 border-b-gray-400 bg-stone-900 ">
                    <th class="px-2 py-2 text-center">ID</th>
                    <th class="px-2 py-2 text-center">Customer Name</th>
                    <th class="px-2 py-2 text-center">NumT.</th>
                    <th class="px-2 py-2 text-center">Date</th>
                    <th class="px-2 py-2 text-center">Type</th>
                    <th class="px-2 py-2 text-center">View</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchases as $purchase)
                    <tr class="border-b border-b-gray-400 bg-zinc-800">
                            <td class="px-2 py-2 text-center">{{ $purchase->id }}</td>
                            <td class="px-2 py-2 text-center ">{{ $purchase->customer_name }}</td>
                            <td class="px-2 py-2 text-center ">{{ $purchase->tickets->count()}}</td>
                            <td class="px-2 py-2 text-center">{{ $purchase->date }}</td>
                            <td class="px-2 py-2 text-center">{{ $purchase->payment_type }}</td>
                            <td>
                                <x-table.icon-show class="ps-3 px-0.5"
                                href="{{ route('purchases.show', ['purchase' => $purchase]) }}"/>
                            </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
