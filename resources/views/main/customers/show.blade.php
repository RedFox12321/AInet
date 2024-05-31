@extends('layouts.main')

@section('header-title', 'Customer - ' . $customer->user->name)

@section('main')

    @include('main.customers.shared.fields')

@endsection
