@extends('layouts.main')

@section('header-title', 'Ticket for ' . $ticket->screening->movie->title)

@section('main')

    @include('main.tickets.shared.fields')

@endsection
