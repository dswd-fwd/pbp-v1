<?php

use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Models\Section;

new
#[Layout('components.layouts.backend-app')]
class extends Component {
    
    #[Validate('required|min:3')] 
    public $section_title = '';
    
    public function addSection()
    {
        $this->validate();

        Section::create([
            'name' => $this->section_title,
        ]);
        
        session()->flash('success', 'Project successfully created.');

        return $this->redirect(route('admin-form-builder'), navigate: true);    }
}; ?>

<div class="mt-12">
    <div class="min-w-full mt-4 overflow-hidden overflow-x-auto align-middle rounded-md ">
        <div class="w-full max-w-lg m-auto bg-white border rounded-md border-zinc-200">
            <form wire:submit="addSection">
                <div class="p-16 space-y-4">
                    <div>
                        <x-form.label>Section Title</x-form.label>
                        <x-form.input class="mt-2" wire:model="section_title" placeholder="Enter section title..." :error="$errors->has('section_title')"/>
                        @error('section_title')
                            <x-form.error :message="$message" />
                        @enderror
                    </div>
                    <x-form.button>Submit</x-form.button>
                </div>
            </form>
        </div>
    </div>
</div>