<?php

use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Models\Section;
use App\Models\Question;
use App\Models\Option;
use App\Models\SubOption;

new
#[Layout('components.layouts.backend-app')]
class extends Component {
    
    public $question;
    public $question_text;
    public $question_multiple_option = 0;
    public $section;
    public $section_title = '';
    public $question_field = '';
    public $questions = [];
    public int $select_other = 0;
    public int $sub_option = 0;
    public int $multiple_option = 0;
    public $sub_option_texts = [];
    public $option_text = '';

    public function mount($id){
        $this->question = Question::with('options.subOptions')->find($id);
        $this->question_text = $this->question->question_text;
        $this->question_multiple_option = $this->question->is_multiple;
    }

    public function updatedSelectOther($value)
    {
        if ($value == 1) {
            $this->sub_option = 0;
            $this->multiple_option = 0;
        }
    }

    public function updatedSubOption($value)
    {
        if ($value == 0) {
            $this->multiple_option = 0;
        }
    }

    public function editQuestion()
    {
        $this->validate([
            'question_text' => 'required|min:3',
        ]);

        $this->question->update([
            'is_multiple' => $this->question_multiple_option,
            'question_text' => $this->question_text,
        ]);

        $this->dispatch('question-section', 'Saved.');
    }

    public function addSubOption()
    {
        $this->sub_option_texts[] = collect(['sub_option_text' => '', 'has_other' => 0]);
    }

    public function deleteSubOptions($index)
    {
        unset($this->sub_option_texts[$index]);
        $this->sub_option_texts = array_values($this->sub_option_texts);
    }

    public function toggleOtherSubOptions($index)
    {
        $this->sub_option_texts[$index]['has_other'] = 
            $this->sub_option_texts[$index]['has_other'] == 1 ? 0 : 1;
    }


    public function saveSettings()
    {
        // Validate the main option first
        $this->validate([
            'option_text' => 'required|min:2',
        ]);
        
        if ($this->sub_option == 1) {
            foreach ($this->sub_option_texts as $index => $sub_option_text) {
                $this->validate([
                    "sub_option_texts.{$index}.sub_option_text" => 'required|min:3',
                ], [
                    "sub_option_texts.{$index}.sub_option_text.required" => "Please provide a text for Sub Option #" . ($index + 1),
                    "sub_option_texts.{$index}.sub_option_text.min" => "Sub Option #" . ($index + 1) . " text must be at least 3 characters long.",
                ]);
            }
        }

        // Create the Option record
        $option = Option::create([
            'question_id' => $this->question->id,
            'option_text' => $this->option_text,
            'has_other' => $this->select_other,
            'has_child' => $this->sub_option,
            'is_multiple' => $this->multiple_option,
        ]);

        // If sub options are enabled, create SubOption records
        if ($this->sub_option == 1 && $this->sub_option_texts) {
            foreach ($this->sub_option_texts as $sot) {
                SubOption::create([
                    'option_id' => $option->id,
                    'sub_option_text' => $sot['sub_option_text'],
                    'has_other' => $sot['has_other'],
                ]);
            }
        } else {
            // Update the Option record if no sub options
            $option->update([
                'has_child' => 0,
                'is_multiple' => 0,
            ]);
        }

        $this->reset([
            'option_text',
            'sub_option_texts',
        ]);

        $this->fill([
            'select_other' => 0,
            'sub_option' => 0,
            'multiple_option' => 0,
        ]);


        // Dispatch the success message
        $this->dispatch('setting-section', 'Saved.');
    }

    public function deleteOption($id)
    {
        Option::find($id)->delete();
        $this->dispatch('setting-section', 'Saved.');
    }

    public function deleteSOption($id)
    {
        SubOption::find($id)->delete();
        $this->dispatch('setting-section', 'Saved.');
    }
}; ?>

<div class="mt-12">
    <div class="w-full max-w-4xl p-8 m-auto mt-12 bg-white rounded-lg">
        <div class="pb-8">
            <form wire:submit="editQuestion">
                <x-form.label class="!text-blue-600">Question Settings</x-form.label>
                <div class="grid mt-4">
                    <x-form.label>Multiple Option</x-form.label>
                    <x-form.select class="max-w-1/2" wire:model.change="question_multiple_option">
                        <option value=1>Yes</option>
                        <option value=0>No</option>
                    </x-form.select>
                </div>
                <div class="mt-4">
                    <x-form.label>Question Text</x-form.label>
                    <x-form.input class="mt-2" wire:model="question_text"/>
                </div>
                <div class="mt-4 text-end">
                    <x-form.button type="submit" class="max-w-40">Edit</x-form.button>
                    <!-- Listen for the event and display success message -->
                    <div x-data="{ status: false, message: '' }" x-on:question-section.window="status = true; message = $event.detail; setTimeout(() => status = false, 5000)">
                        <template x-if="status">
                            <p class="mt-2 text-green-600">
                                <span x-text="message"></span>
                            </p>
                        </template>
                    </div>
                </div>
            </form>
        </div>
        <form wire:submit="saveSettings">
            <div class="space-y-4">
                <p class="font-semibold text-blue-600">Option Settings</p>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <x-form.label>Other</x-form.label>
                        <x-form.select wire:model.change="select_other">
                            <option value=1>Yes</option>
                            <option value=0>No</option>
                        </x-form.select>
                    </div>
                    <div>
                        <x-form.label>Has Sub Options</x-form.label>
                        <x-form.select wire:model.change="sub_option" :disabled="(bool) $select_other || (bool) $question_multiple_option">
                            <option value=1>Yes</option>
                            <option value=0>No</option>
                        </x-form.select>
                    </div>
                    <div>
                        <x-form.label>Allow Multiple Options</x-form.label>
                        <x-form.select wire:model="multiple_option" :disabled="(bool) !$sub_option || $select_other">
                            <option value=1>Yes</option>
                            <option value=0>No</option>
                        </x-form.select>
                    </div>
                </div>
                <div>
                    <x-form.label>Option Text</x-form.label>
                    <x-form.input class="mt-2" wire:model="option_text"/>
                    @error('option_text')
                        <x-form.error :message="$message" />
                    @enderror
                </div>
                <div class="ml-16 space-y-4 {{ !$sub_option ? 'hidden' : '' }}">
                    @foreach ($sub_option_texts as $index => $sub_option_text)                    
                        <div>
                            <x-form.label>Sub Option Text</x-form.label>
                            <div class="flex items-center gap-4">
                                <x-form.input class="mt-2" wire:model="sub_option_texts.{{ $index }}.sub_option_text"/>
                                <div class="flex gap-2">
                                    <x-form.button wire:click="toggleOtherSubOptions({{ $index }})" type="button" class="mt-2 !inline-block !w-auto {{ $sub_option_text->get('has_other') ? '!bg-gray-500' : '!bg-gray-300' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </x-form.button>
                                    <x-form.button wire:click="deleteSubOptions({{ $index }})" type="button" class="!bg-red-500 mt-2 !inline-block !w-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </x-form.button>
                                </div>
                            </div>
                            @error("sub_option_texts.{$index}.sub_option_text")
                                <x-form.error :message="$message" />
                            @enderror
                        </div>
                    @endforeach
                </div>
                <div class="text-end">
                    <x-form.button wire:click="addSubOption" type="button" :hidden="!$sub_option " class="!bg-green-500 max-w-40">Add Sub Option</x-form.button>
                    <x-form.button type="submit" class="max-w-40">Submit</x-form.button>
                    <!-- Listen for the event and display success message -->
                    <div x-data="{ status: false, message: '' }" x-on:setting-section.window="status = true; message = $event.detail; setTimeout(() => status = false, 5000)">
                        <template x-if="status">
                            <p class="mt-2 text-green-600">
                                <span x-text="message"></span>
                            </p>
                        </template>
                    </div>
                </div>
            </div>
        </form>
        <div class="mt-8">
            <x-form.label>Options</x-form.label>
            <div class="mt-4">
                @foreach ($question->options as $option)
                    <ul class="pl-4 list-disc">
                        <li>{{ $option->option_text }} <button class="ml-4 text-red-500 cursor-pointer hover:text-red-600" type="button" wire:click="deleteOption({{ $option->id }})">Delete</button></li>
                    </ul>
                    
                    @foreach($option->subOption ?? collect() as $sub_option)
                        <ul class="list-disc">
                            <li class="ml-16">
                                {{ $sub_option->sub_option_text }} 
                                <button class="ml-4 text-red-500 cursor-pointer hover:text-red-600" type="button" wire:click="deleteSOption({{ $sub_option->id }})">
                                    Delete
                                </button>
                            </li>
                        </ul>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</div>

