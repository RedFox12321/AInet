@extends('layouts.main')

@section('header-title', 'Login')

@section('main')
    <div class="flex justify-center items-center h-screen">
        <div class="w-full max-w-md p-8 space-y-8 bg-stone-900 border-black rounded-lg shadow-md">
            <div class="mb-4 text-sm text-stone-600 dark:text-stone-300">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-auth.input-label for="email" :value="__('Email')" />
                    <x-auth.text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required autofocus />
                    <x-auth.input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button>
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
@endsection
