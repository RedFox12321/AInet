@extends('layouts.main')

@section('header-title', 'Theater - ' . $theater->name)

@section('main')

    <form action="{{ route('theaters.update', ['theater' => $theater]) }}" method="GET">
        @csrf
        @include('main.theaters.shared.fields', ['mode' => 'show'])

    </form>

@endsection
