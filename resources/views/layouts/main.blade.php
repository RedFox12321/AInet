<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cine Magic - @yield('header-title')</title>
    <!-- Fonts Here -->

    <!-- JS & CSS Fileds -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-stone-700 text-white">
    <div>
        <main>
            <div>
                {{-- @if (session('alert-msg'))
                    <x-alert type="{{ session('alert-type') ?? 'info' }}">
                        {!! session('alert-msg') !!}
                    </x-alert>
                @endif
                @if (!$errors->isEmpty())
                    <x-alert type="warning" message="Operation failed because there are validation errors!" />
                @endif --}}
                <div class="w-full h-36 relative flex items-center">

                    <div class="w-full h-full left-0 top-0 flex justify-between items-center px-4 md:px-8 lg:px-16">

                        <div class="z-10 w-full flex space-x-2 justify-start items-end">
                            <x-menu.menu-icon href="{{ route('movies.showcase') }}">
                                <x-slot:icon>
                                    @include('components.application-logo')
                                </x-slot>
                            </x-menu.menu-icon>

                            <x-menu.menu-icon href="{{ route('screenings.index') }}" >
                                <x-slot:icon>
                                    @include('components.menu.screenings-logo')
                                </x-slot>
                            </x-menu.menu-icon>
                        </div>


                        <!-- Navigation links -->
                        <ul :class="{ 'flex': open, 'hidden': !open }"
                            class="hidden md:flex h-full space-x-8 z-10 items-end mr-4">
                            <li class="h-full flex justify-center items-center">
                                <x-menu.menu-icon
                                    href="{{ Route::currentRouteName() == 'movies.showcase' ? '' : session('last_route', url()->previous()) }}">
                                    <x-slot:icon>
                                        @include('components.menu.goback-logo', [
                                            'strokeColor' =>
                                                Route::currentRouteName() == 'movies.showcase'
                                                    ? '#731824'
                                                    : '#E8D8C4',
                                        ])
                                    </x-slot>
                                </x-menu.menu-icon>
                            </li>
                            <li class="h-full flex justify-center items-center">
                                <x-menu.menu-icon href="{{ route('cart.show') }}">
                                    <x-slot:icon>
                                        @include('components.menu.cart-logo')
                                    </x-slot>
                                </x-menu.menu-icon>
                            </li>
                            <li class="h-full flex justify-center items-center">
                                <x-menu.menu-icon href="{{ route('customers.index') }}">
                                    <x-slot:icon>
                                        @include('components.menu.account-logo')
                                    </x-slot>
                                </x-menu.menu-icon>
                            </li>
                        </ul>

                        <div class="w-full h-36 left-0 top-0 absolute bg-rose-800"></div>

                        <div
                            class="w-[99px] h-[99px] pl-[11px] pr-[9.62px] pt-2 pb-[8.50px] left-[1792px] top-[25px] absolute justify-center items-center inline-flex">
                        </div>
                        <div class="w-full h-2.5 left-0 top-[140px] z-10 absolute bg-rose-950"></div>
                    </div>
                </div>
                @yield('main')
            </div>
        </main>
    </div>

    {{-- dropdownzinho dos generos --}}



</body>
