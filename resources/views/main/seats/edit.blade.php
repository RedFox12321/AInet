@extends('layouts.main')

@section('header-title', 'Editing seat ' . $seat->seat_number)

@section('main')

    @include('main.seats.shared.fields')

@endsection
