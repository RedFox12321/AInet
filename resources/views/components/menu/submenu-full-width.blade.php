<div {{ $attributes->merge(['class' => 'relative sm:static group flex flex-col me-0 sm:me-1 lg:me-2']) }}>
    @if($selectable)
        @if($selected)
            <button data-submenu="{{$uniqueName}}"
                    class="grow inline-flex items-center h-16  px-3 sm:px-0.5 md:px-1 lg:px-2 pt-1
                    text-sm font-medium text-stone-500 dark:text-stone-400
                    border-b-2 border-rose-400 dark:border-rose-500
                    hover:text-stone-700 dark:hover:text-stone-300
                    focus:outline-none focus:border-rose-700 dark:focus:border-rose-300 focus:text-stone-700 dark:focus:text-stone-300
                    hover:bg-stone-100 dark:hover:bg-stone-800 sm:hover:bg-white dark:sm:hover:bg-stone-900">
                {{$content}}
                <div>
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </button>
        @else
            <button data-submenu="{{$uniqueName}}"
                class="grow inline-flex items-center h-16  px-3 sm:px-0.5 md:px-1 lg:px-2 pt-1
                text-sm font-medium text-stone-500 dark:text-stone-400
                border-b-2 border-transparent
                hover:border-stone-300 dark:hover:border-stone-700 hover:text-stone-700 dark:hover:text-stone-300
                focus:outline-none focus:border-stone-300 dark:focus:border-stone-700 focus:text-stone-700 dark:focus:text-stone-300
                hover:bg-stone-100 dark:hover:bg-stone-800 sm:hover:bg-white dark:sm:hover:bg-stone-900">
                {{$content}}
                <div>
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </button>
        @endif
    @else
        <button data-submenu="{{$uniqueName}}"
            class="grow inline-flex items-center h-16  px-3 sm:px-0.5 md:px-1 lg:px-2 pt-1
            text-sm font-medium text-stone-500 dark:text-stone-400
            border-b-2 border-transparent
            hover:text-stone-700 dark:hover:text-stone-300
            focus:outline-none focus:text-stone-700 dark:focus:text-stone-300
            hover:bg-stone-100 dark:hover:bg-stone-800 sm:hover:bg-white dark:sm:hover:bg-stone-900">
            {{$content}}
            <div>
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </div>
        </button>
    @endif

    <div id="{{$uniqueName}}" class="z-40 w-full items-center
                grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3
                gap-3 bg-white dark:bg-stone-900
                sm:absolute sm:left-0 sm:top-14 sm:origin-top-left
                sm:rounded-md sm:ring-1 sm:ring-black sm:ring-opacity-5 sm:shadow-lg
                h-0 sm:h-auto
                p-0 ps-6 sm:p-6
                invisible sm:invisible sm:group-hover:visible">
        {{ $slot }}
    </div>
</div>
