@extends('layouts.main')

@section('header-title', 'Editing ' . $costumer->user->name)

@section('main')

    @include('main.customers.shared.fields')

@endsection
