@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'border-gray-300 dark:border-gray-700 dark:bg-stone-800 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-rose-600 focus:ring-rose-900 dark:focus:ring-rose-800 rounded-md shadow-sm',
]) !!}>
