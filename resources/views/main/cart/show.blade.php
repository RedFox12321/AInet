@extends('layouts.main')

@section('header-title', 'Cart')

@section('main')

<div class="flex justify-center">

    <div class="h-max m-10">
        <x-card-round>
            <x-slot:content>
                <div class="flex justify-between items-center">
                    <span class="text-4xl m-3">Email:</span>
                    <x-fields.input
                    name="email"
                    type="email"
                    placeHolder="exemplo@email.com"/>  
                </div>
            </x-slot:content>
        </x-card-round>

        <div class="flex justify-center mt-10">
            <x-button-round>
                <button>Buy Ticket(s)</button>
            </x-button-round>
        </div>
       



    </div>
        
    

    <div class="mt-10 p-2 bg-white dark:bg-stone-800 overflow-hidden
                shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
        @empty($cart)
            <h3 class="text-xl w-96 text-center">Cart is Empty</h3>
        @else
        
        

        <div class="flex justify-center text-2xl p-5">Cart:</div>
        <div class="font-base text-sm text-gray-700 dark:text-gray-300">
            {{-- <x-disciplines.table :disciplines="$cart"
                :showView="false"
                :showEdit="false"
                :showDelete="false"
                :showAddCart="false"
                :showRemoveFromCart="true"
                /> --}}

                <div class="pl-4 pr-4">
                    <x-cart.table :cart="$cart"/>
                </div>


        </div>
        <div class="mt-5">
            <div class="flex justify-between space-x-12 items-end">
                <div>
                    <h3 class="mb-4 text-xl"></h3>
                    <form action="{{ route('cart.confirm') }}" method="post">
                        @csrf
                            {{-- <x-field.input name="student_number" label="Student Number" width="lg"
                                            :readonly="false"
                                            value="{{ old('student_number', Auth::User()?->student?->number ) }}"/> --}}
                            {{-- <x-button element="submit" type="dark" text="Confirm" class="mt-4"/> --}}
                    </form>
                </div>
                <div>
                    <form action="{{ route('cart.destroy') }}" method="post">
                        @csrf
                        @method('DELETE')
                        {{-- <x-button element="submit" type="danger" text="Clear Cart" class="mt-4"/> --}}
                    </form>
                </div>
            </div>
        </div>
        @endempty
    </div>
</div>
@endsection
