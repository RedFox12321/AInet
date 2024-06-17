<div {{ $attributes }}>
    <div class="w-max h-max overflow-hidden rounded-xl border-4 border-rose-950">
        <table class="table-auto">
            <thead>
                <tr class="border-b-2 border-b-gray-400 bg-stone-900 ">
                    <th class="px-2 py-2 text-center">ID</th>
                    @if (Auth::user()->type != 'C')
                        <th class="px-2 py-2 text-center hidden lg:table-cell">Customer Name</th>
                        <th class="px-2 py-2 text-center hidden md:table-cell">Customer Email</th>
                    @endif
                    <th class="px-2 py-2 text-center">NumT.</th>
                    <th class="px-2 py-2 text-center">Date</th>
                    <th class="px-2 py-2 text-right hidden sm:table-cell">Payment Type</th>
                    <th class="px-2 py-2 text-right">Payment Reference</th>
                    <th class="px-2 py-2 text-center">View</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchases as $purchase)
                    <tr class="@if (!$loop->last) border-b border-b-gray-400 @endif bg-zinc-800">
                        <td class="px-2 py-2 text-center">{{ $purchase->id }}</td>
                        @if (Auth::user()->type != 'C')
                            <td class="px-2 py-2 text-center hidden lg:table-cell">{{ $purchase->customer_name }}</td>
                            <td class="px-2 py-2 text-center hidden md:table-cell">{{ $purchase->customer_email }}</td>
                        @endif
                        <td class="px-2 py-2 text-center ">{{ $purchase->tickets->count() }}</td>
                        <td class="px-2 py-2 text-center">{{ $purchase->date }}</td>
                        <td class="px-2 py-2 text-center hidden sm:table-cell">{{ $purchase->payment_type }}</td>
                        <td class="px-2 py-2 text-center">{{ $purchase->payment_ref }}</td>
                        <td>
                            <x-table.icon-show class="ps-3 px-0.5"
                                href="{{ route('purchases.show', ['purchase' => $purchase]) }}" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
