@props(['value'])

<label {{ $attributes->merge(['class' => 'mt-5 block font-medium text-xl font-[Khula] text-stone-600 dark:text-stone-300']) }}>
    {{ $value ?? $slot }}
</label>
