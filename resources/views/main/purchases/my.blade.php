@extends('layouts.main')

@section('header-title', 'Purchases')

@section('main')

    <div class="flex flex-wrap justify-around">
        <div class="h-max w-max flex fit-content justify-left m-10">

            <x-purchases.filter-card :filterAction="route('purchases.my')" :resetUrl="route('purchases.my')" :title="old('search', $filterById)" placeHolder="ID" />

        </div>

        <div class="flex flex-col">
            <div class="m-10 flex fit-content">
                <x-purchases.table :purchases="$purchases" />
            </div>
            <div>
                {{ $purchases->links() }}
            </div>
        </div>

    </div>

@endsection
