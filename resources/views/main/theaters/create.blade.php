@extends('layouts.main')

@section('header-title', 'New theater')

@section('main')

    @include('main.theaters.shared.fields', ['mode' => 'create'])

@endsection
