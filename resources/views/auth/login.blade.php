@extends('layouts.main')

@section('header-title', 'Login')

@section('main')
    <div class="flex justify-center items-center flex-col flex-grow h-screen max-h-screen">
        <div class="w-full max-w-md p-8 space-y-8 bg-stone-900 border-black rounded-lg shadow-md">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-auth.input-label for="email" :value="__('Email')" />
                    <x-auth.text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required autofocus autocomplete="username" />
                    <x-auth.input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-auth.input-label for="password" :value="__('Password')" />
                    <x-auth.text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" />
                    <x-auth.input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded bg-stone-700 border-gray-300 text-rose-600 shadow-sm focus:ring-rose-900"
                            name="remember">
                        <span class="ml-2 text-sm text-rose-400">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-rose-400 hover:text-white" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button class="ms-3">
                        {{ __('login') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        <a href="{{ __('register') }}">
            <x-secondary-button class="mt-5 items-center flex text-center">
                <p class="text-rose-400 hover:text-white">Don't have an account? </p>
                <p class="p-2 text-sm">Register</p>
            </x-secondary-button>
        </a>
    </div>

@endsection
