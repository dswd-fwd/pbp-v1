<?php

use Livewire\Volt\Component;

new class extends Component {

    public $id;
    public $user;
    
    public function mount()
    {
        $this->id = request()->id;
        $role = auth()->user();
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        session()->flash('success', 'You have been logged out.');

        return $this->redirect(route('login'), navigate: true);
    }
}; ?>

<div>
    <div class="flex items-center justify-between">
        <div class="flex gap-2 text-zinc-800">
            <span>Dashboard</span>
            <span>/</span>
            <span class="font-semibold text-zinc-800">
                @switch(Route::currentRouteName())
                    @case('admin-dashboard')
                        <a wire:navigate href="{{ route('admin-dashboard') }}" class="hover:font-semibold">Home</a>
                        @break
                    @case('admin-profiling-list')
                        <a wire:navigate href="{{ route('admin-profiling-list') }}" class="hover:font-semibold">Profiling List</a>
                        @break
                    @case('admin-form-builder')
                        <a wire:navigate href="{{ route('admin-form-builder') }}" class="hover:font-semibold">Form Builder</a>
                        @break
                    @case('admin-add-section')
                        <span class="font-normal"><a wire:navigate href="{{ route('admin-form-builder') }}">Form Builder</a> / </span><span class="font-semibold">Add Section</span>
                        @break
                    @case('admin-edit-section')
                        <span class="font-normal"><a wire:navigate href="{{ route('admin-form-builder') }}">Form Builder</a> / </span><span class="font-semibold">Edit Section</span>
                        @break
                    @case('admin-question-option')
                        <span class="font-normal">
                            <a wire:navigate href="{{ route('admin-form-builder') }}">Form Builder</a> / 
                        </span>
                        <span class="font-normal">
                            <a wire:navigate href="{{ route('admin-edit-section', App\Models\Question::find($id)->section_id) }}">Edit Section</a> / 
                        </span>
                        <span class="font-semibold">Edit Question Options</span>
                        @break
                @endswitch
            </span>
        </div>
        <button wire:click="logout" class="font-semibold cursor-pointer text-zinc-800 hover:opacity-70">
            Logout
        </button>
    </div>
</div>

