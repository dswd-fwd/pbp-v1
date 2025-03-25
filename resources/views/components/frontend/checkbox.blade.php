@props(['options' => [], 'name' => '', 'layout' => 'row'])

<div class="{{ $layout === 'column' ? 'flex flex-col' : 'flex space-x-4' }}">
    @foreach ($options as $option)
        <label class="flex isspace-x-2">
            <input 
                type="checkbox" 
                name="{{ $name . '[]' }}" 
                value="{{ $option }}" 
                class="border-gray-300 rounded text-sky-600 focus:ring-sky-400"
            >
            <span>{{ $option }}</span>
        </label>
    @endforeach
</div>
