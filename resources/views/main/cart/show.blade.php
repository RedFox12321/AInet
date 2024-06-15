@extends('layouts.main')

@section('header-title', 'Cart')

@section('main')

    <div class="flex justify-around flex-wrap">

        <div class="h-max m-10 w-max">
            <form action="{{ route('cart.confirm') }}" method="POST">
                @csrf
                <x-card-round>
                    <x-slot:content>
                        <div class="flex py-3 items-center">
                            <span class="text-4xl m-3">Name:</span>
                            <x-fields.input name="name" type="text" placeHolder="A name" :readonly="false"
                                value="{{ old('name', Auth::User()?->name) }}" />
                        </div>
                        <div class="flex py-3 items-center">
                            <span class="text-4xl m-3">Email:</span>
                            <x-fields.input name="email" type="email" placeHolder="exemplo@email.com" :readonly="false"
                                value="{{ old('email', Auth::User()?->email) }}" />
                        </div>
                        <div class="flex py-3 items-center">
                            <span class="text-4xl m-3">NIF:</span>
                            <x-fields.input name="nif" type="text" placeHolder="123456789" :readonly="false"
                                width="2/5" value="{{ old('nif', Auth::User()?->customer?->nif) }}" />
                        </div>
                    </x-slot:content>
                </x-card-round>
                <div class="flex justify-center mt-10"></div>
                <x-card-round>
                    <x-slot:content>
                        <div class="flex flex-row">
                            <div class="flex py-3 justify-between items-center">
                                <x-fields.select name="payType" label="Payment Type" :options="$payment_types"
                                    value="{{ old('payType', Auth::User()?->customer?->payment_type) }}" />
                            </div>
                            <div class="flex py-3 justify-between items-center flex-col">
                                <span class="text-4xl m-3">Payment Reference:</span>
                                <x-fields.input name="payRef" type="text" placeHolder="email/number" width="lg"
                                    :readonly="false" value="{{ old('payRef', Auth::User()?->customer?->payment_ref) }}" />
                            </div>
                        </div>
                    </x-slot:content>
                </x-card-round>
                <div class="flex justify-center mt-10"></div>
                <div class="flex justify-center">
                    <x-button-round>
                        <button>Buy</button>
                    </x-button-round>
                </div>
            </form>
            <div class="mt-10 flex justify-center">
                <form action="{{ route('cart.destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <x-button-round>
                        <button>Clear cart</button>
                    </x-button-round>
                </form>
            </div>
        </div>



        <div
            class="m-10 w-full md:2/3 lg:w-1/2 h-full p-2 bg-white dark:bg-stone-800
                shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50 flex justify-center items-center">
            @empty($cart)
                <h3 class="text-xl w-max h-max">Cart is Empty</h3>
            @else
                <div class="flex justify-center text-2xl p-5">Cart:</div>
                <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                    <div class="pl-4 pr-4">
                        <x-cart.table :cart="$cart" />
                    </div>
                </div>
            @endempty
        </div>
    </div>
@endsection
