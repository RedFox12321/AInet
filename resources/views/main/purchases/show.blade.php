@extends('layouts.main')

@section('header-title', 'Purchase of ' . $purchase->customer_name)

@section('main')

    @include('main.purchases.shared.fields')

@endsection
