@extends('layouts.main')

@section('header-title', 'User - ' . $user->name)

@section('main')

    @include('main.users.shared.fields')

@endsection
