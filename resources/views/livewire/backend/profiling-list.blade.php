<?php

use Livewire\Attributes\Url;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\Volt\Component;
use App\Models\User;

new
#[Layout('components.layouts.backend-app')]
class extends Component {
    use WithPagination;

    public $search = '';
    public $showReceiptModal = false;
    public $selectedUser = null;

    public function with(): array
    {
        return [
            'users' => User::where('role', 'member')
                ->where('name', 'like', '%' . $this->search . '%')
                ->with('region')
                ->paginate(10)
        ];
    }

    public function viewReceipt($userId)
    {
        $this->selectedUser = User::find($userId);
        $this->showReceiptModal = true;
    }

    public function closeModal()
    {
        $this->showReceiptModal = false;
        $this->selectedUser = null;
    }
};
?>

<div>
    <div class="mt-12">
        <div class="flex justify-end">
            <input 
                type="search" 
                class="px-4 py-2 bg-white border rounded-md border-zinc-200" 
                placeholder="Search..." 
                wire:model.live.300ms="search"
            >
        </div>

        <div class="min-w-full mt-4 overflow-hidden overflow-x-auto align-middle rounded-md">
            <table class="min-w-full">
                <thead>
                    <tr class="font-semibold text-white bg-gradient-to-tr from-gray-800 to-gray-900">
                        <th class="px-6 py-3 text-left">Name</th>
                        <th class="px-6 py-3 text-left">Birthday</th>
                        <th class="px-6 py-3 text-left">Region</th>
                        <th class="px-6 py-3 text-left">Date created</th>
                        <th class="px-6 py-3 text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php use Carbon\Carbon; @endphp
                    @foreach ($users as $user)
                    <tr class="bg-white hover:bg-gray-100">
                        <td class="px-6 py-4 text-gray-900 whitespace-nowrap">
                            <p class="text-gray-600 truncate">{{ \Illuminate\Support\Str::limit($user->name, 50 , '...') }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                            <p class="text-gray-600 truncate">{{ Carbon::parse($user->birth)->format('F j, Y') }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-900 whitespace-nowrap">
                            <p class="text-gray-600 truncate">{{ \Illuminate\Support\Str::limit($user->region->regDesc ?? 'N/A', 50 , '...') }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                            <p class="text-gray-600 truncate">{{ Carbon::parse($user->created_at)->format('D, F j, Y') }}</p>
                        </td>
                        <td class="px-6 py-4 font-medium whitespace-nowrap">
                            <div class="flex gap-4">
                                <a wire:click="viewReceipt({{ $user->id }})">
                                    <div class="px-2 py-1 bg-white border rounded-md cursor-pointer border-zinc-200 hover:bg-gray-200">✏️</div>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links('vendor.livewire.tailwind') }}
        </div>
    </div>

    {{-- Receipt Modal with Two Copies --}}
    @if ($showReceiptModal && $selectedUser)
    <div class="fixed inset-0 z-50 flex items-center justify-center" style="background-color: rgba(0,0,0,0.5);" wire:click="closeModal">
        <div class="w-full max-w-6xl p-6 py-16 font-mono text-sm bg-white rounded-lg shadow-xl">
            <div class="grid grid-cols-2 gap-4">
                {{-- DSWD Copy --}}
                <div class="relative px-4 py-8 border border-gray-300 rounded-md">
                    <div class="absolute text-2xl transform -translate-x-1/2 -top-12 left-1/2">
                        DSWD COPY
                    </div>
                    <div class="mb-4">
                        <img src="{{ asset('img/treslogos.png') }}" class="w-full mx-auto max-w-62" alt="">
                        <img src="{{ asset('img/revised_pbp_mobile.png') }}" class="w-full mx-auto my-4 max-w-80" alt="">
                    </div>
                    <div class="flex justify-center mb-2">
                        <div class="font-bold text-center">TRANSACTION RECEIPT</div>
                    </div>

                    <hr class="mb-2 border-t border-gray-400">

                    <p>Date Issued: {{ now()->format('F j, Y') }}</p>

                    <hr class="my-2 border-t border-gray-400">

                    <p><strong>Name:</strong> {{ $selectedUser->name }}</p>
                    <p><strong>Address:</strong> {{ $selectedUser->region->regDesc ?? 'N/A' }}</p>

                    <hr class="my-2 border-t border-gray-400 border-dashed">

                    <p class="mt-2">✅ This receipt verifies the profiling of the above individual under the member role category.</p>

                    <div class="flex justify-center mt-4">
                        <img class="h-48" src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=receipt-profile-{{ $selectedUser->id }}" alt="QR Code">
                    </div>

                    <hr class="mt-4 border-t border-gray-400">
                    <p class="mt-2 text-xs text-center text-gray-500">System-generated copy. No signature required.</p>
                </div>

                {{-- Individual Copy --}}
                <div class="relative px-4 py-8 border border-gray-300 rounded-md">
                    <div class="mb-4">
                        <img src="{{ asset('img/treslogos.png') }}" class="w-full mx-auto max-w-62" alt="">
                        <img src="{{ asset('img/revised_pbp_mobile.png') }}" class="w-full mx-auto my-4 max-w-80" alt="">
                    </div>
                    <div class="flex justify-center mb-2">
                        <div class="font-bold text-center">TRANSACTION RECEIPT</div>
                    </div>

                    <hr class="mb-2 border-t border-gray-400">

                    <p>Date Issued: {{ now()->format('F j, Y') }}</p>

                    <hr class="my-2 border-t border-gray-400">

                    <p><strong>Name:</strong> {{ $selectedUser->name }}</p>
                    <p><strong>Address:</strong> {{ $selectedUser->region->regDesc ?? 'N/A' }}</p>

                    <hr class="my-2 border-t border-gray-400 border-dashed">

                    <p class="mt-2">✅ This receipt verifies the profiling of the above individual under the member role category.</p>

                    <div class="flex justify-center mt-4">
                        <img class="h-48" src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=receipt-profile-{{ $selectedUser->id }}" alt="QR Code">
                    </div>

                    <hr class="mt-4 border-t border-gray-400">
                    <p class="mt-2 text-xs text-center text-gray-500">System-generated copy. No signature required.</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
