@extends('layouts.main')

@section('header-title', 'Customers')

@section('main')

    <div class="flex flex-col">
        <div class="flex justify-center mt-5">

            <x-customers.filter-card :filterAction="route('customers.index')" :resetUrl="route('customers.index')" />

        </div>



        <div class="m-10 flex justify-center fit-content">
            <x-customers.table :customers="$customers" />
        </div>
        <div>
            {{ $customers->links() }}
        </div>
    </div>

@endsection
