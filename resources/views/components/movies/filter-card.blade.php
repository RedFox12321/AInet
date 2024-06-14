<form action="{{ $filterAction }}" method="get">
    {{-- @include('components.fields.search') --}}

    <div class="m-10 flex items-center justify-center">
        <x-card-round>
            <x-slot:content>
                <div class="flex w-full h-full items-center space-x-16 px-5" >

                        <x-fields.select name="genre" :options="$listGenres" label="Genre" value="genre"/>
                            
                        
                        <x-fields.input name="search" placeHolder="Movie Title" value="search"/>
                    
                        <x-button-round>
                            <button>Search</button>
                        </x-button-round>
                </div>
            </x-slot>
        </x-card-round>
        
    </div>

</form>
