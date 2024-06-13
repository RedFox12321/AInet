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
    $widthClass = match($width) {
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
    }
@endphp
<div {{ $attributes->merge(['class' => "$widthClass"]) }}>
    <input id="id_{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ $value }}" placeholder="{{ $placeHolder }}"
    class="w-full h-full pl-8 pr-4 top-0 left-0 
    text-4xl font-normal font-['Khula'] 
    focus:ring-2 rounded-[45px]
    text-black placeholder-stone-700
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
            autofocus="autofocus"
            @required($required)
            @disabled($readonly)
        >

    @error( $name )
        <div class="text-sm text-red-500">
            {{ $message }}
        </div>
    @enderror
</div>

{{-- <form action="" method="get">

    <div class="w-[706px] h-20 relative rounded-[45px] mt-5">
        <div class="w-[706px] h-20 absolute bg-zinc-300 bg-opacity-90 rounded-[45px]"></div>
        <input type="text" placeholder="Título do Filme"
            class="w-[706px] h-20 pl-8 pr-4 absolute top-0 left-0 bg-transparent text-black bg-opacity-25 text-4xl font-normal font-['Khula'] focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-[45px]">

        <button>
            <svg class="absolute right-8 top-1/4" width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18.7495 34.3745C22.8935 34.3745 26.8678 32.7283 29.7981 29.7981C32.7283 26.8678 34.3745 22.8935 34.3745 18.7495C34.3745 14.6055 32.7283 10.6313 29.7981 7.701C26.8678 4.77074 22.8935 3.12454 18.7495 3.12454C14.6055 3.12454 10.6313 4.77074 7.701 7.701C4.77074 10.6313 3.12454 14.6055 3.12454 18.7495C3.12454 22.8935 4.77074 26.8678 7.701 29.7981C10.6313 32.7283 14.6055 34.3745 18.7495 34.3745ZM33.2683 30.6152L43.7464 41.0933L41.0933 43.7464L30.6152 33.2683C26.8906 36.3122 22.1386 37.8083 17.3419 37.4471C12.5453 37.0858 8.07097 34.8949 4.84428 31.3275C1.61759 27.7601 -0.11462 23.089 0.00589142 18.2803C0.126403 13.4716 2.09042 8.89309 5.49175 5.49175C8.89309 2.09042 13.4716 0.126403 18.2803 0.00589142C23.089 -0.11462 27.7601 1.61759 31.3275 4.84428C34.8949 8.07097 37.0858 12.5453 37.4471 17.3419C37.8083 22.1386 36.3122 26.8906 33.2683 30.6152Z" fill="black"/>
            </svg>
        </button>
 

        </div>

</form> --}}
