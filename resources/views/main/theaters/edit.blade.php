@extends('layouts.main')

@section('header-title', 'Editing ' . $theater->name)

@section('main')



    <form action="{{route('theaters.update',['theater'=>$theater])}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('main.theaters.shared.fields', ['mode' => 'edit'])
    
    </form>

@endsection
