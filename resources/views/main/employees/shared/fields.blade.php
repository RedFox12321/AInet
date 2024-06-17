<div class="mt-5 h-max w-max">

    <x-card-round>
        <x-slot:content>
            <div class="h-full flex flex-wrap items-center">
                <div class="w-full flex justify-center px-5">
                    <div>
                        <x-fields.image name="image_file" label="Employee Image" width="md" deleteTitle="Delete Image"
                            :deleteAllow="$mode == 'edit' && $employee->imageExists" deleteForm="form_to_delete_image" imageUrl="{{ $employee->photo_filename }}"
                            :readonly="$mode == 'show'" />
                    </div>
                    <div class="mx-5">
                        <div class="text-2xl flex w-full justify-center mb-3">Name</div>
                        <x-fields.input name="name" :readonly="$mode == 'show'" value="{{ old('name', $employee->name) }}" />
                        <div class="text-2xl flex w-full justify-center mb-3">E-mail</div>
                        <x-fields.input name="name" :readonly="$mode == 'show'" value="{{ old('name', $employee->email) }}" />
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
                <button type="submit">Save Employee</button>
            </x-button-round>
        </div>
    @endif

</div>
