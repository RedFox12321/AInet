<div class="mt-5 h-max w-max">

    <x-card-round>
        <x-slot:content>
            <div class="h-full flex flex-wrap items-center">
                <div class="text-2xl flex w-full justify-center mb-3">Change Name</div>

                <div class="w-full flex justify-center px-5">

                    <div>
                        <x-fields.input name="name" :value="$theater->name" />

                        <x-fields.image name="image_file" label="Theater Image" width="md" deleteTitle="Delete Image"
                            :deleteAllow="($mode == 'edit') && ($theater->imageExists)" deleteForm="form_to_delete_image" :imageUrl="$theater->imageUrl" />


                        {{-- <x-fields.input name="seat" :value="$theater->seat" /> --}}
                    </div>
                </div>
            </div>

        </x-slot>
    </x-card-round>

    <div class="mt-10 w-full flex flex-0 justify-center items-end mb-5 fit-content">
        <x-button-round>
            <button>Submit Changes</button>
        </x-button-round>
    </div>


</div>
