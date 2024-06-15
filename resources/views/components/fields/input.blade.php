{{--
    NOTE: we've used the match to define multiple versions of width class,
    to ensure that all specific width related classes are defined statically
    on the source code - this guarantees that the Tailwind builder
    detects the corresponding class.
    If we had used dynamically generated classes (e.g. "w-{{ $width }}") then
    the builder would not detect concrete values.
    Check documentation about dynamic classes:
    https://tailwindcss.com/docs/content-configuration#dynamic-class-names
--}}
@php
    $widthClass = match ($width) {
        'full' => 'w-full',
        'xs' => 'w-20',
        'sm' => 'w-32',
        'md' => 'w-64',
        'lg' => 'w-96',
        'xl' => 'w-[48rem]',
        '1/3' => 'w-1/3',
        '2/3' => 'w-2/3',
        '1/4' => 'w-1/4',
        '2/4' => 'w-2/4',
        '3/4' => 'w-3/4',
        '1/5' => 'w-1/5',
        '2/5' => 'w-2/5',
        '3/5' => 'w-3/5',
        '4/5' => 'w-4/5',
    };
@endphp
<div {{ $attributes->merge(['class' => "$widthClass"]) }}>
    <input id="id_{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ $value }}"
        placeholder="{{ $placeHolder }}"
        class="w-full h-full pl-8 pr-4 top-0 left-0
        text-4xl font-normal font-['Khula'] focus:ring-2
        text-black dark:text-gray-200
        bg-white dark:bg-neutral-800
        placeholder-stone-700 dark:placeholderbg-stone-200
        @error($name)
            border-red-500 dark:border-red-500
        @else
            border-gray-300 dark:border-gray-700
        @enderror
        focus:border-indigo-500 dark:focus:border-rose-900
        focus:ring-indigo-500 dark:focus:ring-rose-900
        rounded-full shadow-sm
        disabled:rounded-none disabled:shadow-none
        disabled:border-t-transparent disabled:border-x-transparent
        disabled:border-dashed
        disabled:opacity-100
        disabled:select-none"
        autofocus="autofocus" @required($required) @disabled($readonly)>

    @error($name)
        <div class="text-sm text-red-600">
            {{ $message }}
        </div>
    @enderror
</div>
