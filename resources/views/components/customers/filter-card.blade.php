<form action="{{ $filterAction }}" method="get">

    <div class="m-10 flex items-center justify-center">
        <x-card-round>
            <x-slot:content>
                <div class="flex w-full h-full items-center space-x-16 px-5" >

                        <x-fields.input name="search" placeHolder="ID/Name"/>

                        <x-button-round>
                            <button>Search</button>
                        </x-button-round>
                </div>
            </x-slot>
        </x-card-round>

    </div>

</form>