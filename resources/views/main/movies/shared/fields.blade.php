<div class="mt-5 h-max w-max">

    <x-card-round>
        <x-slot:content>
            <div class="h-full flex flex-wrap items-center">
                <div class="w-full flex justify-center px-5">
                    <div>
                        <div class="text-2xl flex w-full justify-center mb-3">Change Name</div>
                        <x-fields.input name="title" value="{{old('title',$movie->title)}}" />
                        <x-fields.image name="image_file" label="Movie Image" width="md" deleteTitle="Delete Image"
                            :deleteAllow="($mode == 'edit') && ($movie->imageExists)" deleteForm="form_to_delete_image" imageUrl="{{$movie->poster_filename}}" :readonly="($mode == 'show')" />
                    </div>
                    <div class="mx-5">
                        <div class="text-2xl flex w-full my-3">Change Genre</div>
                        <x-fields.select name="genre" :options="$genres->pluck('name', 'code')->toArray()" label="_" value=" {{old('genre', $movie->genre->code)}} "/>
                        <div class="text-2xl flex w-full my-3">Change Synopsis</div>
                        <x-fields.text-area name="synopsis" value="{{old('synopsis',$movie->synopsis)}}" />
                            <div class="text-2xl flex w-full my-3">Change Url</div>
                        <x-fields.input name="trailer_url" value="{{old('trailer_url',$movie->trailer_url)}}" />
                            <div class="text-2xl flex w-full my-3">Change Year</div>
                        <x-fields.input name="year" value="{{old('year',$movie->year)}}" />
                    </div>
                </div>
            </div>

        </x-slot>
    </x-card-round>

    @if ($mode == 'edit')
        <div class="mt-10 w-full flex flex-0 justify-center items-end mb-5 fit-content">
            <x-button-round>
                <button>Submit Changes</button>
            </x-button-round>
        </div>
    @endif

</div>
