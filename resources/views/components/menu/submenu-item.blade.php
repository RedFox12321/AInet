@if($selectable)
    @if($selected)
        <a class="px-3 py-4 border-b-2 border-b-rose-400 dark:border-b-rose-500
                text-sm font-medium leading-5 inline-flex h-auto font-['Khula']
                text-stone-900 dark:text-stone-100
                group-hover:bg-rose-500 dark:group-hover:bg-rose-500
                hover:text-stone-700 dark:hover:text-stone-600
                focus:outline-none focus:border-rose-700 dark:focus:border-rose-300
                hover:bg-rose-300 dark:hover:bg-rose-300"
            @if ($form)
                href="#"
                onclick="event.preventDefault();
                document.getElementById({{ $form }}).submit();"
            @else
                href="{{ $href }}"
            @endif>
            {{ $content }}
        </a>
    @else
        <a class="px-3 py-4 border-b-2 border-transparent
                text-sm font-medium leading-5 inline-flex h-auto font-['Khula']
                text-stone-500 dark:text-stone-400
                group-hover:bg-rose-500 dark:group-hover:bg-rose-500
                hover:border-stone-300 dark:hover:border-stone-700
                hover:text-stone-700 dark:hover:text-stone-600
                focus:outline-none focus:border-stone-300 dark:focus:border-stone-700
                focus:text-stone-700 dark:focus:text-stone-300
                hover:bg-rose-300 dark:hover:bg-rose-300"
            @if ($form)
                href="#"
                onclick="event.preventDefault();
                document.getElementById({{ $form }}).submit();"
            @else
                href="{{ $href }}"
            @endif>
            {{ $content }}
        </a>
    @endif
@else
    <a class="px-3 py-4 border-b-2 border-transparent
                text-sm font-medium leading-5 inline-flex h-auto font-['Khula']
                text-stone-500 dark:text-stone-400
                group-hover:bg-rose-500 dark:group-hover:bg-rose-500
                hover:text-stone-700 dark:hover:text-stone-600
                focus:outline-none
                focus:text-stone-700 dark:focus:text-stone-300
                hover:bg-rose-300 dark:hover:bg-rose-300"
            @if ($form)
                href="#"
                onclick="event.preventDefault();
                document.getElementById('{{ $form }}').submit();"
            @else
                href="{{ $href }}"
            @endif>
        {{ $content }}
    </a>
@endif
