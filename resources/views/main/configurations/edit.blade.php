@extends('layouts.main')

@section('header-title', 'Configurations')

@section('main')
    <div class="flex justify-center items-center h-screen">
        <div class="bg-stone-900 p-8 rounded-[45px] border-2 border-rose-900 shadow-lg">
            <header>
                <h2 class="text-3xl font-semibold font-[Khula] text-stone-900 dark:text-stone-300">
                    Configurations
                </h2>
                <p class="mt-1 text-xl font-[Khula] text-stone-800 dark:text-stone-300  mb-6">
                    Click on "Save" button to store the information.
                </p>
            </header>

            <form method="POST" action="{{ route('configurations.update', ['configuration' => $configuration]) }}">
                @csrf
                @method('PUT')
                <div>
                    <x-fields.input-label for="ticket_price" value="Ticket Price" />
                    <x-fields.input class="block mt-1 w-full" name="ticket_price" placeHolder="Ticket Price"
                        :value="$configuration->ticket_price" />
                    <x-fields.input-label for="registered_customer_ticket_discount" value="Customer Discount" />
                    <x-fields.input class="block mt-1 w-full" name="registered_customer_ticket_discount"
                        placeHolder="Customer Discount" :value="$configuration->registered_customer_ticket_discount" />
                </div>
                <div class="flex justify-end items-center mt-6">
                    <button type="submit">
                        <x-button-round>
                            Save
                        </x-button-round>
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
