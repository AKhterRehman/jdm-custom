@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-[#d3cec1]']) }}>
    {{ $value ?? $slot }}
</label>
