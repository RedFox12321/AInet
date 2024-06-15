@extends('layouts.main')

@section('header-title', 'Purchases')

@section('main')

<div class="flex flex-wrap justify-around">
    <div class="h-max w-max flex fit-content justify-left m-10">

        <x-purchases.filter-card
        :filterAction="route('purchases.index')"
        :resetUrl="route('purchases.index')"
        :title="old('search',$filterByIdName)"
        />
            
        {{-- <x-fields.select name="genre" label="Genre"
                     value=App\Models\Genre
                    :options="$listGenre"/> --}}

    </div>

    <div class="flex flex-col">
        <div class="m-10 flex fit-content">
            <x-purchases.table :purchases="$purchases"/>
        </div>
        <div>
            {{ $purchases->links() }}
        </div>
    </div>
    
</div>

@endsection
