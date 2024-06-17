@extends('layouts.main')

@section('header-title', 'New user')

@section('main')

<div class="flex justify-center items-center h-screen mt-3">
    <div class="bg-stone-900 p-8 rounded-[45px] border-2 border-rose-900 shadow-lg">
        <header>
            <h2 class="text-3xl font-semibold font-[Khula] text-stone-900 dark:text-stone-300">
                Create Employee
            </h2>
            <p class="mt-1 text-xl font-[Khula] text-stone-800 dark:text-stone-300  mb-6">
                Click on "Submit" button to store the information.
            </p>
        </header>
        <form action="{{ route('admins.store', ['admin' => $user]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('main.employees.shared.fields', ['mode' => 'create'])
        </form>
    </div>
</div>

@endsection
