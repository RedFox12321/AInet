<form action="{{ $filterAction }}" method="get">
    {{-- @include('components.fields.search') --}}

    <div class="m-10 flex items-center justify-center">
        <x-card-round>
            <x-slot:content>
                <div class="flex w-full h-full items-center space-x-16 px-5">

                        <x-fields.select name="genre" :options="$genres" label="Género">
                            



                        </x-fields.select>
                        
                        <x-fields.input name="search" placeHolder="Título do Filme">
                        </x-fields.input>
                    
                        <x-button-round>
                            <button>Pesquisar</button>
                        </x-button-round>
                </div>
            </x-slot>
        </x-card-round>
        
    </div>

</form>
