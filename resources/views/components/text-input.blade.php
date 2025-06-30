@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-20 rounded-md shadow-sm']) }}>
