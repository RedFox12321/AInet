@extends('layouts.main')

@section('header-title', 'Editing ' . $theater->name)

@section('main')

    @include('main.theaters.shared.fields')

@endsection
