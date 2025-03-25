<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div class="relative">
    <div class="fixed py-8 overflow-y-auto bg-white h-dvh w-80">
        <img src="{{ asset('img/dswd-building.jpg') }}" class="absolute top-0 object-cover w-full h-full -z-10 opacity-5" alt="">
        <div class="mb-8">
            <a wire:navigate href="{{ route('admin-dashboard') }}">
                <img src="{{ asset('img/DSWD-Logo.png') }}" alt="DSWD Logo" class="mx-auto max-w-36">
            </a>
        </div>

        <div class="grid gap-2">
            <a wire:navigate href="{{ route('admin-dashboard') }}">
                <div class="group flex items-center gap-4 px-6 py-2 mx-auto text-center rounded-sm max-w-60 hover:bg-gray-200 {{ Route::is('admin-dashboard') ? 'bg-gradient-to-tr from-gray-800 to-gray-900 shadow-sm' : '' }}">
                    <div class="grid w-10 h-8 bg-gray-700 border border-gray-100 rounded-sm place-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-white size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
                        </svg>
                    </div>
                    <span class="font-medium {{ Route::is('admin-dashboard') ? 'text-white' : 'text-zinc-800' }}">
                        Dashboard
                    </span>
                </div>
            </a>
            <a wire:navigate href="{{ route('admin-profiling-list') }}">
                <div class="group flex items-center gap-4 px-6 py-2 mx-auto text-center rounded-sm max-w-60 hover:bg-gray-200 {{ Route::is('admin-profiling-list') ? 'bg-gradient-to-tr from-gray-800 to-gray-900 shadow-sm' : '' }}">
                    <div class="grid w-10 h-8 bg-gray-700 border border-gray-100 rounded-sm place-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-white size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                        </svg>
                    </div>
                    <span class="font-medium {{ Route::is('admin-profiling-list') ? 'text-white' : 'text-zinc-800' }}">
                        Profiling List
                    </span>
                </div>
            </a>
            <a wire:navigate href="{{ route('admin-form-builder') }}">
                <div class="group flex items-center gap-4 px-6 py-2 mx-auto text-center rounded-sm max-w-60 hover:bg-gray-200 {{ Route::is('admin-form-builder') || Route::is('admin-add-section') || Route::is('admin-edit-section') || Route::is('admin-question-option') ? 'bg-gradient-to-tr from-gray-800 to-gray-900 shadow-sm' : '' }}">
                    <div class="grid w-10 h-8 bg-gray-700 border border-gray-100 rounded-sm place-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-white size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
                        </svg>
                    </div>
                    <span class="font-medium {{ Route::is('admin-form-builder') || Route::is('admin-add-section') || Route::is('admin-edit-section') || Route::is('admin-question-option') ? 'text-white' : 'text-zinc-800' }}">
                        Form Builder
                    </span>
                </div>
            </a>
        </div>
    </div>
</div>
