<div class="mt-5 h-max w-max">

    <x-card-round>
        <x-slot:content>
            <div class="h-full flex flex-wrap items-center">
                <div class="text-2xl flex w-full justify-center mb-3">Name</div>

                <div class="w-full flex justify-center px-5">

                    <div>
                        <x-fields.input name="name" value="{{old('name', $theater?->name)}}" :readonly="($mode == 'show')" />

                        <x-fields.image name="image_file" label="Theater Image" width="md" deleteTitle="Delete Image"
                            :deleteAllow="($mode == 'edit') && ($theater->imageExists)" deleteForm="form_to_delete_image" :imageUrl="$theater->imageUrl" :readonly="($mode == 'show')" />


                    </div>
                </div>
            </div>

        </x-slot>
    </x-card-round>


    @if($mode == 'edit')
    <div class="mt-10 w-full flex flex-0 justify-center items-end mb-5 fit-content">
        <x-button-round>
            <button>Submit</button>
        </x-button-round>
    </div>
    @endif

</div>
