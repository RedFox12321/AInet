<div {{ $attributes->merge(['class' => 'relative group flex flex-col me-0 sm:me-1 lg:me-2']) }}>
    @if($selectable)
        @if($selected)
            <button data-submenu="{{$uniqueName}}"
            class="grow inline-flex items-center h-16
                 px-3 sm:px-0.5 md:px-1 lg:px-2 pt-1
                text-4xl font-medium font-['Khula'] text-stone-500 dark:text-stone-900
                border-b-2 border-transparent hover:text-stone-700 dark:hover:text-stone-700
                focus:outline-none focus:text-stone-700 dark:focus:text-stone-600
                hover:rounded-lg
                hover:bg-rose-300 dark:hover:bg-rose-300 sm:hover:bg-rose-300 dark:sm:hover:bg-rose-300">
        @else
            <button data-submenu="{{$uniqueName}}"
            class="grow inline-flex items-center h-16
                 px-3 sm:px-0.5 md:px-1 lg:px-2 pt-1
                text-4xl font-medium font-['Khula'] text-stone-500 dark:text-stone-900
                border-b-2 border-transparent hover:text-stone-700 dark:hover:text-stone-700
                hover:rounded-lg
                focus:outline-none focus:text-stone-700 dark:focus:text-stone-600
                hover:bg-rose-300 dark:hover:bg-rose-300 sm:hover:bg-rose-300 dark:sm:hover:bg-rose-300">
        @endif
    @else
        <button data-submenu="{{$uniqueName}}"
            class="grow inline-flex items-center h-16
                px-3 sm:px-0.5 md:px-1 lg:px-2 pt-1
                text-4xl font-medium font-['Khula'] text-stone-500 dark:text-stone-900 hover:rounded-lg
                border-b-2 border-transparent hover:text-stone-700 dark:hover:text-stone-700
                focus:outline-none focus:text-stone-700 dark:focus:text-stone-600
                hover:bg-rose-300 dark:hover:bg-rose-300 sm:hover:bg-rose-300 dark:sm:hover:bg-rose-300">
    @endif
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
    <div id="{{$uniqueName}}" class="sm:absolute sm:left-0 sm:top-14 sm:origin-top-left
                w-full sm:w-48 bg-white dark:bg-stone-900
                grid grid-cols-1
                sm:rounded-md sm:ring-1 sm:ring-black sm:ring-opacity-5 sm:shadow-lg
                h-0 sm:h-auto
                invisible sm:invisible sm:group-hover:visible
                ps-6 sm:ps-0">
        {{ $slot }}
    </div>
</div>
