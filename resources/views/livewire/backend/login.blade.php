<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new
#[Layout('components.layouts.frontend-app')]
class extends Component {

    #[Validate('required|email')]
    public $email = '';
    #[Validate('required')]
    public $password = '';
    
    public function authenticate()
    {
        $this->validate();

        if(Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            return $this->redirect(route('admin-dashboard'), navigate: true);
        } else {
            $this->reset('password');
            $this->addError('error-login', 'Invalid credentials.');
        }
    }
}; ?>

<div class="w-full max-w-xl m-auto overflow-hidden bg-white border lg:max-w-5xl border-zinc-200 rounded-xl">
    <div class="grid h-full lg:grid-cols-2">
        <div class="px-8 py-12 sm:py-16 sm:px-10">
            <div class="space-y-8">
                <img src="{{ asset('img/DSWD-Logo.png') }}" alt="DSWD Logo" class="max-w-36">
                <h1 class="text-2xl font-semibold lg:text-3xl">Pamilya sa Bagong Pilipinas</h1>
                <form wire:submit="authenticate">
                    <div class="grid gap-3">
                        <x-form.label>Email</x-form.label>
                        <x-form.input wire:model="email" placeholder="Enter your email" :error="$errors->has('email')"></x-form.input>
                        @error('email')
                            <x-form.error :message="$message" />
                        @enderror
                        <x-form.label>Password</x-form.label>
                        <x-form.input wire:model="password" placeholder="Enter your password" type="password" :error="$errors->has('password')"></x-form.input>
                        @error('password')
                            <x-form.error :message="$message" />
                        @enderror
                        <x-form.button>Log in</x-form.button>
                        @if(session('success'))
                            <x-form.session-success>{{ session('success') }}</x-form.session-success>
                        @endif
                    </div>
                </form>
            </div>
            <footer class="mt-8 text-sm sm:mt-16 text-zinc-800">
                &copy; Copyright 2025 DSWD. All Rights Reserved.
            </footer>
        </div>
        <div class="hidden py-5 pr-5 lg:block">
            <img src="{{ asset('img/asian-mother.webp') }}" alt="Asian Mother" class="object-cover h-full rounded-xl brightness-75">
        </div>
    </div>
</div>
