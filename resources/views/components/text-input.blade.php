@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-600 transition-colors']) }}>
