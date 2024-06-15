@extends('layouts.main')

@section('header-title', 'Tickets')

@section('main')

<div class="flex flex-wrap justify-around">
    <div class="h-max w-max flex fit-content justify-left m-10">

        <x-tickets.filter-card
        :filterAction="route('tickets.index')"
        :resetUrl="route('tickets.index')"
        :title="old('search',$filterByIdName)"
        />
            
        {{-- <x-fields.select name="genre" label="Genre"
                     value=App\Models\Genre
                    :options="$listGenre"/> --}}

    </div>

    <div class="flex flex-col">
        <div class="m-10 flex fit-content">
            <x-tickets.table :tickets="$tickets"/>
        </div>
        <div>
            {{ $tickets->links() }}
        </div>
    </div>
    
</div>


@endsection
