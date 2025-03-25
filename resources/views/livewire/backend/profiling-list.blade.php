<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new
#[Layout('components.layouts.backend-app')]
class extends Component {
    //
}; ?>

<div>
    <div class="min-w-full mt-12 overflow-hidden overflow-x-auto align-middle rounded-md ">
        <table class="min-w-full">
            <thead>
                <tr class="font-semibold text-white bg-gradient-to-tr from-gray-800 to-gray-900">
                    <th class="px-6 py-3 text-left" scope="col">Title</th>
                    <th class="px-6 py-3 text-left" scope="col">Description</th>
                    <th class="px-6 py-3 text-left" scope="col">Created At</th>
                    <th class="px-6 py-3 text-left" scope="col">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                    {{-- @php
                        use Carbon\Carbon;
                    @endphp
                    @foreach ($projects as $project)
                    <tr class="bg-white hover:bg-gray-100">
                        <td class="px-6 py-4 text-gray-900 whitespace-nowrap">
                            <p class="text-gray-600 truncate">{{ \Illuminate\Support\Str::limit($project->title, 30, '...') }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                            <p class="text-gray-600 truncate">{{ \Illuminate\Support\Str::limit($project->description, 30, '...') }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                            <p class="text-gray-600 truncate">{{ Carbon::parse($project->created_at)->format('D, F j, Y') }}</p>
                        </td>
                        <td class="px-6 py-4 font-medium whitespace-nowrap">
                            <div class="flex gap-4">
                                <a wire:navigate href="{{ route('admin-form-edit', $project->id) }}">
                                    <div class="px-2 py-1 bg-white border rounded-md border-zinc-200 hover:bg-gray-200">✏️</div>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach --}}
            </tbody>
        </table>
    </div>
</div>
