<a wire:navigate href="{{ $href }}" class="">
    <button {{ $attributes->merge(['class' => 'px-16 w-full mt-1 font-semibold text-white rounded-md cursor-pointer border-1 h-11 bg-zinc-800 hover:opacity-70']) }}>
        {{ $slot }}
    </button>
</a>
