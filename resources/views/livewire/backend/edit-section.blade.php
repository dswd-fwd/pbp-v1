<?php

use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Models\Section;
use App\Models\Question;

new
#[Layout('components.layouts.backend-app')]
class extends Component {
    
    public $section;
    public $section_title = '';
    public $question_field = '';
    public $questions = [];

    public function mount($id)
    {
        $this->section = Section::find($id);
        $this->section_title = $this->section->name;
        $this->questions = $this->section
            ->questions()
            ->withCount('options')
            ->get()
            ->map(fn($question) => [
                'id' => $question->id,
                'question_text' => $question->question_text,
            ])
            ->toArray();
    }
    
    public function editSection()
    {
        $section = $this->section;
        
        $this->validate([
            'section_title' => 'required|min:3'
        ]);
        
        $this->section->update([
            'name' => $this->section_title,
        ]);

        $this->dispatch('edited-section', 'Saved.');
    }

    public function addQuestion()
    {
        $this->validate([
            'question_field' => 'required|min:3'
        ]);

        $question = Question::create([
            'question_text' => $this->question_field,
            'section_id' => $this->section->id,
            'is_multiple' => 0,
        ]);

        $this->questions[] = ['id' => $question->id, 'question_text' => $question->question_text];
        $this->reset('question_field');

        $this->dispatch('question-section', 'Saved.');
    }

    public function deleteQuestion($id, $index)
    {
        // Get the question instance from the array
        $question = Question::find($id);

        // Delete the question from the database
        if ($question) {
            $question->delete();
        }

        // Remove from the questions array
        unset($this->questions[$index]);
        $this->questions = array_values($this->questions);

        $this->dispatch('question-section', 'Saved.');
    }

}; ?>

<div class="mt-12">
    <div class="w-full max-w-4xl p-8 m-auto mt-12 bg-white rounded-lg ">
        <form wire:submit="editSection">
            <div class="space-y-2 rounded-md">
                <x-form.label>Section Title</x-form.label>
                <x-form.input class="mt-2" wire:model="section_title"/>
                @error('section_title')
                    <x-form.error :message="$message" />
                @enderror
                <div class="flex flex-col items-end">
                    <x-form.button type="submit" class="max-w-40">Edit</x-form.button>
                    <!-- Listen for the event and display success message -->
                    <div x-data="{ status: false, message: '' }" x-on:edited-section.window="status = true; message = $event.detail; setTimeout(() => status = false, 5000)">
                        <template x-if="status">
                            <p class="mt-2 text-green-600">
                                <span x-text="message"></span>
                            </p>
                        </template>
                    </div>
                </div>
            </div>
        </form>
    </div>
    {{-- Adding Question --}}
    <div class="w-full max-w-4xl p-8 m-auto mt-12 bg-white rounded-lg ">
        <form wire:submit="addQuestion">
            <div class="space-y-2 rounded-md">
                <x-form.label>Add Questions</x-form.label>
                <x-form.input class="mt-2" wire:model="question_field"/>
                @error('question_field')
                    <x-form.error :message="$message" />
                @enderror
                <div class="flex flex-col items-end">
                    <x-form.button class="max-w-40">Add</x-form.button>
                    <!-- Listen for the event and display success message -->
                    <div x-data="{ status: false, message: '' }" x-on:question-section.window="status = true; message = $event.detail; setTimeout(() => status = false, 5000)">
                        <template x-if="status">
                            <p class="mt-2 text-green-600">
                                <span x-text="message"></span>
                            </p>
                        </template>
                    </div>
                </div>
            </div>
        </form>
        <div class="mt-4">
            <x-form.label>Questions</x-form.label>
            <div class="grid gap-2 mt-2">
                @foreach ($questions as $index => $question)
                    <div wire:key="question-{{ $index }}">
                        <p>{{ $index+1 }}. {{ $question['question_text'] }}</p>
                        <div class="space-x-2 text-sm">
                            <a wire:navigate href="{{ route('admin-question-option', [$question['id']])  }}" class="text-blue-500 cursor-pointer hover:text-blue-600">Add Options</a>
                            <button class="text-red-500 cursor-pointer hover:text-red-600" type="button" wire:click="deleteQuestion({{$question['id']}}, {{$index}})">Delete</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>