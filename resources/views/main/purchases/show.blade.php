@extends('layouts.main')

@section('header-title', 'Purchase of ' . $purchase->customer->user->name)

@section('main')

    @include('main.purchases.shared.fields')

@endsection
