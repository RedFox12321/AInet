<a href="{{ session('last_route', url()->previous()) {{--TODO--}} }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium z-10">
    {{ $slot }}

</a>
