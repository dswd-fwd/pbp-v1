@props(['options', 'question_id', 'answers' => [], 'other_answers' => []])

<div class="grid gap-2">
    @foreach (json_decode($options, true) as $index => $option)
        <label class="flex items-center space-x-2" wire:key="option-{{ $index }}">
            <input 
                type="radio" 
                value="{{ $option['id'] }}" 
                class="border-gray-300 rounded text-sky-600 focus:ring-sky-400"
                {{ $attributes }}
            >
            <span>{{ $option['option_text'] }}</span>
        </label>

        {{-- @if (isset($option['sub_options']) && !empty($option['sub_options']))
            <div>
                @foreach($option['sub_options'] as $index => $sub_option)
                    <label class="flex items-center ml-8 space-x-2" wire:key="sub_option-{{ $index }}">
                        <input 
                            type="radio" 
                            class="border-gray-300 rounded text-sky-600 focus:ring-sky-400"
                        >
                        <span>{{ $sub_option['sub_option_text'] }}</span>
                    </label>
                @endforeach
            </div>
        @endif --}}

        @if ($option['has_other'])
            @if (isset($answers[$question_id]) && $answers[$question_id] == $option['id'])
                <x-form.input 
                    wire:model.live="other_answers.{{ $question_id }}" 
                    placeholder="Please specify"
                />
            @endif
        @endif
    @endforeach
</div>
