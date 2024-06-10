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
            <div class="">
                {{-- @if (session('alert-msg'))
                    <x-alert type="{{ session('alert-type') ?? 'info' }}">
                        {!! session('alert-msg') !!}
                    </x-alert>
                @endif
                @if (!$errors->isEmpty())
                    <x-alert type="warning" message="Operation failed because there are validation errors!" />
                @endif --}}
                <div class="w-[1920px] h-36 relative flex items-center">
                    
                    <div class="w-[1920px] h-full left-0 top-0 flex justify-between items-center">

                        <x-menu.menu-icon href="{{ route('movies.index') }}">
                            @include('components.application-logo')
                        </x-menu.menu-icon>


                        <ul class="h-full flex space-x-8 z-10 items-end mr-4">
                            <li class="h-full flex justify-center items-center">
                                <x-menu.menu-icon href="{{ session('last_route', url()->previous()) }}">
                                    @include('components.menu.goback-logo', [
                                        'strokeColor' => Route::currentRouteName() /*TODO*/ == 'movies.index' ? '#E8D8C4' : '#731824',
                                    ])
                                </x-menu.menu-icon>
                            </li>
                            <li class="h-full flex justify-center items-center">
                                <x-menu.menu-icon href="{{ route('cart.show') }}">
                                    @include('components.menu.cart-logo')
                                </x-menu.menu-icon>
                            </li>
                            <li class="h-full flex justify-center items-center">
                                <x-menu.menu-icon href="{{ route('customer.index') }}">
                                    @include('components.menu.account-logo')
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

    <div class="w-[706px] h-20 relative rounded-[45px]">
        <div class="w-[706px] h-20 absolute bg-zinc-300 bg-opacity-90 rounded-[45px]"></div>
        <input type="text" placeholder="Título do Filme" class="w-[706px] h-20 pl-8 pr-4 absolute top-0 left-0 bg-transparent text-black bg-opacity-25 text-4xl font-normal font-['Khula'] focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-[45px]">
      </div>

</body>
