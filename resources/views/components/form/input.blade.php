@props(['error' => false])

<div class="block w-full">
    <input 
    {{ $attributes->merge(['class' => "text-nuetral-600 w-full px-4 border rounded-md h-11 !focus:border-sky-400 " . ($error ? '!border-red-500' : 'border-zinc-300')]) }} 
    {{ $attributes }}
    >
</div>

