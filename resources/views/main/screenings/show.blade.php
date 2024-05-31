@extends('layouts.main')

@section('header-title', 'Screening of ' . $screening->movie->title)

@section('main')

    @include('main.screenings.shared.fields')

@endsection
