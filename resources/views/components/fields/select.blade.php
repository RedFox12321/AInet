@php
    $selectedValue = array_key_exists($value, $options) ? $value : $defaultValue;
@endphp

<div class= "flex flex-wrap fit-content justify-center ">
    <label class="text-4xl text-center w-full font-semibold">
        {{ $label }}
    </label>
    <select id="id_{{ $name }}" name="{{ $name }}"
        class="appearance-none block
            mt-1 fit-content
            bg-white bg-stone-800
            ring-rose-950
            text-black dark:text-white
            @error($name)
                border-red-500 dark:border-red-500
            @else
                border-gray-300 dark:border-gray-700
            @enderror
            focus:border-rose-800
            focus:ring-rose-800
            rounded-md shadow-sm
            disabled:rounded-none disabled:shadow-none
            disabled:border-t-transparent disabled:border-x-transparent
            disabled:border-dashed
            disabled:bg-none
            disabled:opacity-100
            disabled:select-none"
            autofocus="autofocus"
            @required($required)
            @disabled($readonly)
        >
        @foreach ($options as $key => $value)
            <option value="{{ $key }}" @selected($selectedValue == $key)>{{ $value }}</option>
        @endforeach
    </select>
    @error( $name )
        <div class="text-sm text-red-500">
            {{ $message }}
        </div>
    @enderror
</div>
