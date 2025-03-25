<button {{ $attributes->merge(['class' => 'w-full px-4 mt-1 font-semibold text-white rounded-md cursor-pointer border-1 h-11 bg-zinc-800 hover:opacity-70']) }} {{ $attributes}}>
    {{ $slot}}
</button>