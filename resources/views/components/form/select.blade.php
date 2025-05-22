@props(['error' => false])

<select 
    {{ $attributes->merge(['class' => "bg-white text-neutral-600 w-full px-4 mt-1 border rounded-md h-11 appearance-none pr-10 disabled:bg-gray-100 " . ($error ? '!border-red-500' : 'border-zinc-300')]) }} 
    {{ $attributes }}
>
    <option value="" disabled selected></option>
    {{ $slot }}
</select>

<style>
    select {
        background-image: url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M5.23 7.79a1 1 0 011.414 0L10 11.586l3.353-3.797a1 1 0 111.495 1.34l-4 4.5a1 1 0 01-1.495 0l-4-4.5a1 1 0 010-1.34z" clip-rule="evenodd" /></svg>') ;
        background-position: right 1rem center;
        background-repeat: no-repeat;
        background-size: 1rem;
    }
</style>
