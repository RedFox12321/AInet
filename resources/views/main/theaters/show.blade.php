@extends('layouts.main')

@section('header-title', 'Theater - ' . $theater->name)

@section('main')

    @include('main.theaters.shared.fields')

@endsection
