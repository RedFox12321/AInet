@extends('layouts.main')

@section('header-title', 'Editing ' . $genre->name)

@section('main')

    @include('main.genres.shared.fields')

@endsection
