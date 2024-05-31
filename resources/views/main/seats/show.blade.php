@extends('layouts.main')

@section('header-title', 'Seat ' . $seat->seat_number)

@section('main')

    @include('main.seats.shared.fields')

@endsection
