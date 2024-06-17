@extends('layouts.main')

@section('header-title', 'Purchase of ' . $purchase->customer_name)

@section('main')


    <div class="mt-10 flex justify-center items-center flex-col">
        <div class="w-max h-max overflow-hidden rounded-xl border-4 border-rose-950">
            <table class="table-auto">
                <thead>
                    <tr class="border-b-2 border-b-gray-400 bg-stone-900 ">
                        <th class="px-2 py-2 text-center">ID</th>
                        <th class="px-2 py-2 text-center hidden lg:table-cell">Name</th>
                        <th class="px-2 py-2 text-center hidden md:table-cell">Email</th>
                        <th class="px-2 py-2 text-center">Num T.</th>
                        <th class="px-2 py-2 text-center">Date</th>
                        <th class="px-2 py-2 text-right hidden sm:table-cell">Payment Type</th>
                        <th class="px-2 py-2 text-right">Payment Reference</th>
                    </tr>
                </thead>
                <tbody>

                    <tr class="border-b border-b-gray-400 bg-zinc-800">
                        <td class="px-2 py-2 text-center">{{ $purchase->id }}</td>
                        <td class="px-2 py-2 text-center hidden lg:table-cell">{{ $purchase->customer_name }}</td>
                        <td class="px-2 py-2 text-center hidden md:table-cell">{{ $purchase->customer_email }}</td>
                        <td class="px-2 py-2 text-center ">{{ $purchase->tickets->count() }}</td>
                        <td class="px-2 py-2 text-center">{{ $purchase->date }}</td>
                        <td class="px-2 py-2 text-center hidden sm:table-cell">{{ $purchase->payment_type }}</td>
                        <td class="px-2 py-2 text-center">{{ $purchase->payment_ref }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
