<form action="{{ $filterAction }}" method="get">
    {{-- @include('components.fields.search') --}}

    <div class="mt-5 h-max w-max">
        <div class="mb-5">
            <x-fields.input name="search" placeHolder="Movie Title"/>
        </div>

        <div class="mt-10 w-full flex flex-0 justify-center items-end mb-5 fit-content">
            <x-button-round>
                <button>Search</button>
            </x-button-round>
        </div>


    </div>

</form>
