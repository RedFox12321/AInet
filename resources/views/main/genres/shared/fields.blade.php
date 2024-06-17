@props([$mode])

<div class="mt-5 h-max w-max">

    <x-card-round>
        <x-slot:content>
            <div class="h-full flex flex-wrap items-center">

                @if ($mode == 'create')
                    <div class="text-2xl flex w-full justify-center mb-3">Code</div>
                    <div class="w-full flex justify-center px-5">
                        <x-fields.input name="code" :readonly="$mode == 'show'" value="{{ $genre->code }}" />
                    </div>
                @endif
                <div class="text-2xl flex w-full justify-center mb-3">Name</div>
                <div class="w-full flex justify-center px-5">
                    <x-fields.input name="name" :readonly="$mode == 'show'" value="{{ $genre->name }}" />
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
