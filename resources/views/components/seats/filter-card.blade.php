<form action="{{ $filterAction }}" method="get">
    {{-- @include('components.fields.search') --}}

    <div class="mt-5 h-max w-max">

        <x-card-round>
            <x-slot:content>
                <div class="h-full flex flex-wrap items-center">

                    <div class="w-full flex justify-left px-5">

                        <x-fields.select name="theater" :options="$theaters" label="Theater" value="{{ $theater }}"/>

                    </div>
                </div>

        </x-slot>
        </x-card-round>

        <div class="mt-10 w-full flex flex-0 justify-center items-end mb-5 fit-content">
            <x-button-round>
                <button>Search</button>
            </x-button-round>
        </div>


    </div>

</form>
