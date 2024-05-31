@extends('layouts.main')

@section('header-title', 'Editing screening of ' . $screening->theater->name)

@section('main')

    @include('main.screenings.shared.fields')

@endsection
