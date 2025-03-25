<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Livewire\Volt\Component;
use Livewire\Attributes\{Validate, Layout};
use App\Models\{Section, Question, Option, SubOption, Answer, AnswerOption, AnswerSubOption, HEA, ReasonForAbsence, Confirmation, FamilyProfile};

new
#[Layout('components.layouts.frontend-app')]
class extends Component {

    public $user;
    public $section;
    public $answers = [];
    public $other_answers = [];
    public $answers_with_child = [];
    public $option_id;
    public $multiple_answers = [];
    public $single_multiple_answer=[];

    public $final_answers = [];
    public $final_answers_checkbox = [];

    public $existing_answers = [];

    public $current_option;

    // User Related
    public $heas;
    public $reason_for_absences;
    public $confirmations;
    public $user_family_members;
    public $family_members = [];

    public function mount()
    {
        if (!auth()->check()) {
            $this->redirect(route('respondent-profile'), navigate: true);
        }
        
        $this->user = Auth::user();
        $this->heas = HEA::get();
        $this->reason_for_absences = ReasonForAbsence::get();
        $this->confirmations = Confirmation::get();
        $this->user_family_members = $this->user->familyMembers()->get();

        // Family Members
        $this->family_members = $this->user->familyMembers()
            ->get()
            ->map(function ($member) {
                return [
                    'id' => $member->id,
                    'birth_registered' => $member->birth_registered ?: '',
                    'registered_voter' => $member->registered_voter ?: '',
                    'voted_last_six_years' => $member->voted_last_six_years ?: '',
                    'has_internet_access' => $member->has_internet_access ?: '',
                ];
            })->toArray();
    }

    public function submitAnswer()
    {
        $user = Auth::user();

        foreach ($this->family_members as $member) {
            FamilyProfile::find($member['id'])->update(
                [
                    'birth_registered' => $member['birth_registered'] ?: null,
                    'registered_voter' => $member['registered_voter'] ?: null,
                    'voted_last_six_years' => $member['voted_last_six_years'] ?: null,
                    'has_internet_access' => $member['has_internet_access'] ?: null,
                ]
            );
        }

        $this->redirect(route('social-relationship-and-engagement'), navigate: true);
    }
}; ?> 

<div class="w-full max-w-4xl p-10 m-auto overflow-hidden bg-white border border-zinc-200 text-zinc-800 rounded-xl">
    <x-frontend.header :message="'POLITICAL PARTICIPATION'"/>

    <form wire:submit="submitAnswer">
        @foreach ($user_family_members as $index => $user_family_member)
            <div class="relative p-8 mt-8 space-y-6 border rounded-lg border-zinc-200">
                <x-frontend.header-description class="!text-sky-600" :message="'Family Member ' . ($index + 1)"/>
                <div class="!mt-6 grid gap-6">
                    <div class="flex gap-2">
                        <x-frontend.header-description :message="'Name:'"/>
                        <p>{{ $user_family_member->name }}</p>
                    </div>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <x-frontend.header-description :message="'Is birth registered with the civil registry office'"/>
                            <x-form.select class="!mt-2" wire:model="family_members.{{ $index }}.birth_registered">
                                @foreach ($confirmations as $confirmation)
                                    <option value="{{ $confirmation->id }}">{{ $confirmation->name }}</option>
                                @endforeach
                            </x-form.select>
                        </div>
                        <div>
                            <x-frontend.header-description :message="'Is a registered voter'"/>
                            <x-form.select class="!mt-2" wire:model="family_members.{{ $index }}.registered_voter">
                                @foreach ($confirmations as $confirmation)
                                    <option value="{{ $confirmation->id }}">{{ $confirmation->name }}</option>
                                @endforeach
                            </x-form.select>
                        </div>
                    </div>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <x-frontend.header-description :message="'Voted in the last  six years for election'"/>
                            <x-form.select class="!mt-2" wire:model="family_members.{{ $index }}.voted_last_six_years">
                                @foreach ($confirmations as $confirmation)
                                    <option value="{{ $confirmation->id }}">{{ $confirmation->name }}</option>
                                @endforeach
                            </x-form.select>
                        </div>
                        <div>
                            <x-frontend.header-description :message="'Has access to the internet'"/>
                            <x-form.select class="!mt-2" wire:model="family_members.{{ $index }}.has_internet_access">
                                @foreach ($confirmations as $confirmation)
                                    <option value="{{ $confirmation->id }}">{{ $confirmation->name }}</option>
                                @endforeach
                            </x-form.select>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="flex justify-end gap-4 mt-8">
            <div class="w-full">
                <a wire:navigate href="{{ route('education') }}">
                    <x-form.button class="max-w-40 !bg-transparent !text-neutral-800 border border-gray-300">
                        Back
                    </x-form.button>
                </a>
            </div>
            <x-form.button class="max-w-40">
                Next Page
            </x-form.button>
        </div>
    </form>

    <div class="flex justify-center mt-16">
        <x-form.progress-indicator :start="1" :end="10" :current="7" />
    </div>
</div>