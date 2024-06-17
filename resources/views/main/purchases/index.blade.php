@extends('layouts.main')

@section('header-title', 'Purchases')

@section('main')

    <div class="flex flex-wrap justify-around">
        <div class="h-max w-max flex fit-content justify-left m-10">
            @php
                $placeHolder = 'ID\\Customer Name';
            @endphp

            @if (Auth::user()->type == 'C')
                @php
                    $placeHolder = 'ID';
                @endphp
            @endif
            <x-purchases.filter-card :filterAction="route('purchases.index')" :resetUrl="route('purchases.index')" :seachField="old('search', $filterByIdName)" :payField="old('payType', $filterByType)"
                :placeHolder="$placeHolder" />
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
