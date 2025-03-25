<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Models\Section;

new
#[Layout('components.layouts.backend-app')]
class extends Component {

    public $sections;
    
    public function mount()
    {
        $this->sections = Section::get();
    }
}; ?>

<div class="mt-12">
    <div class="flex justify-end">
        <x-button_link :href="route('admin-add-section')">Add</x-button_link>
    </div>
    @if(session('success'))
        <p 
            x-data="{ status: true}"
            x-init="setTimeout(() => status = false, 5000)"
            x-show="status"
            class="mt-2 text-green-600"
        >
            {{ session('success') }}
        </p>
    @endif
    <div class="min-w-full mt-4 overflow-hidden overflow-x-auto align-middle rounded-md ">
        <table class="min-w-full">
            <thead>
                <tr class="font-semibold text-white bg-gradient-to-tr from-gray-800 to-gray-900">
                    <th class="px-6 py-3 text-left" scope="col">Title</th>
                    <th class="px-6 py-3 text-left" scope="col">Created At</th>
                    <th class="px-6 py-3 text-left" scope="col">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        use Carbon\Carbon;
                    @endphp
                    @foreach ($sections as $section)
                    <tr class="bg-white hover:bg-gray-100">
                        <td class="px-6 py-4 text-gray-900 whitespace-nowrap">
                            <p class="text-gray-600 truncate">{{ \Illuminate\Support\Str::limit($section->name, 50, '...') }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                            <p class="text-gray-600 truncate">{{ Carbon::parse($section->created_at)->format('D, F j, Y') }}</p>
                        </td>
                        <td class="px-6 py-4 font-medium whitespace-nowrap">
                            <div class="flex gap-4">
                                <a wire:navigate href="{{ route('admin-edit-section', $section->id) }}">
                                    <div class="px-2 py-1 bg-white border rounded-md border-zinc-200 hover:bg-gray-200">✏️</div>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
