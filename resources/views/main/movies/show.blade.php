@extends('layouts.main')

@section('header-title', 'Movie - ' . $movie->title)

@section('main')

    @include('main.movies.shared.fields')

@endsection
