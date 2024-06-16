@extends('layouts.main')

@section('header-title', 'Editing ' . $user->name)

@section('main')

    @include('main.users.shared.fields')

@endsection
