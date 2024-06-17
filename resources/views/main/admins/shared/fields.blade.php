<div class="mt-5 h-max w-max">

    <x-card-round>
        <x-slot:content>
            <div class="h-full flex flex-wrap items-center">
                <div class="w-full flex justify-center px-5">
                    <div>
                        <x-fields.image name="image_file" label="Admin Image" width="md" deleteTitle="Delete Image"
                            :deleteAllow="$mode == 'edit' && $user->imageExists" deleteForm="form_to_delete_image" imageUrl="{{ $user->photo_filename }}"
                            :readonly="$mode == 'show'" />
                    </div>
                    <div class="mx-5">
                        <div class="text-2xl flex w-full justify-center mb-3">Name</div>
                        <x-fields.input name="name" :readonly="$mode == 'show'" value="{{ old('name', $user->name) }}" />
                        <div class="text-2xl flex w-full justify-center mb-3">E-mail</div>
                        <x-fields.input name="name" :readonly="$mode == 'show'" value="{{ old('name', $user->email) }}" />
                    </div>
                </div>
            </div>
        </x-slot>
    </x-card-round>

    @if ($mode == 'edit')
        <div class="mt-10 w-full flex flex-0 justify-center items-end mb-5 fit-content">
            <x-button-round>
                <button type="submit">Submit Changes</button>
            </x-button-round>
        </div>
    @endif
    @if ($mode == 'create')
        <div class="mt-10 w-full flex flex-0 justify-center items-end mb-5 fit-content">
            <x-button-round>
                <button type="submit">Save Admin</button>
            </x-button-round>
        </div>
    @endif

</div>
