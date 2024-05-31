@extends('layouts.main')

@section('header-title', 'Editing ' . $movie->title)

@section('main')

    @include('main.movies.shared.fields')

@endsection
