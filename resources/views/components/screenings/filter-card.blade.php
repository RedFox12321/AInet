
<form action="{{ $filterAction }}" method="get">
    {{-- @include('components.fields.search') --}}

    <div class="mt-5 h-96 w-[706px]">
        <x-card-round>
            <x-slot:content>
                <div class="h-full flex flex-wrap justify-between ">
                    <div class="ml-5 mt-5 w-full flex flex-wrap space-around">
                        
    
                        <div class="w-full ">
                            <span class="text-4xl font-semibold">Género:</span>
    
    
                            {{-- <x-fields.select name="genre" 
                                                   :options="$genres->pluck('name')->toArray()"
                                                   >
                       
                                   </x-fields.select> --}}
                        </div>
    
                        <div class="w-full">
                            <span class="text-4xl font-semibold">Data:</span>
    
    
                        </div>
                    </div>
                    <div class="w-full flex flex-0 justify-center items-end mb-5 fit-content">
                        <x-button-round>
                            <button>Pesquisar</button>
                        </x-button-round>
                    </div>
                </div>
            </x-slot>
        </x-card-round>
    </div>
    
</form>
