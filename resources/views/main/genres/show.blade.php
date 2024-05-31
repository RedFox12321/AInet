@extends('layouts.main')

@section('header-title', 'Genre - ' . $genre->name)

@section('main')

    @include('main.genres.shared.fields')

@endsection
