@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300
dark:border-gray-700 dark:bg-stone-800 dark:text-gray-300 focus:border-black
focus:ring-rose-900 rounded-[45px] shadow-sm']) !!}>
