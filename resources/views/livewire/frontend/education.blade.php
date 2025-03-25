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

    // User Education Family 
    public $heas;
    public $reason_for_absences;
    public $confirmations;
    public $user_family_members;
    public $family_members = [];
    
    // User Education
    public $h_e_a_id = '';
    public $attending_school = '';
    public $year_level = '';
    public $reason_for_absence_id = '';
    public $not_attending_school_reason = '';
    public $read_and_write = '';
    
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
        $this->section = Section::with('questions.options.subOptions')->where('name', 'EDUCATION')->first();
        
        // User Education
        $this->h_e_a_id = $this->user->h_e_a_id ?: '';
        $this->attending_school = $this->user->attending_school ?: '';
        $this->year_level = $this->user->year_level ?: '';
        $this->reason_for_absence_id = $this->user->reason_for_absence_id ?: '';
        $this->not_attending_school_reason = $this->user->not_attending_school_reason ?: '';
        $this->read_and_write = $this->user->read_and_write ?: '';

        // Family Members Education
        $this->family_members = $this->user->familyMembers()
            ->get()
            ->map(function ($member) {
                return [
                    'id' => $member->id,
                    'h_e_a_id' => $member->h_e_a_id ?: '',
                    'attending_school' => $member->attending_school ?: '',
                    'year_level' => $member->year_level,
                    'reason_for_absence_id' => $member->reason_for_absence_id ?: '',
                    'not_attending_school_reason' => $member->not_attending_school_reason,
                    'read_and_write' => $member->read_and_write ?: '',
                ];
            })->toArray();
        
        // Initialize answer-related arrays
        $this->answers = [];
        $this->other_answers = [];

        // Retrieve user's existing answers
        $this->existing_answers = Answer::where('user_id', $this->user->id)
            ->whereIn('question_id', $this->section->questions->pluck('id'))
            ->with('answerOptions.answerSubOptions')
            ->get();
        
        if(!$this->existing_answers->isEmpty()) {
            foreach ($this->existing_answers as $user_answer) {
                $answer_option = $user_answer->answerOptions->first();
                if(!$answer_option) return;
                $option = Option::find($answer_option->option_id);
                $question_is_multiple = Question::find($user_answer->question_id)->is_multiple;

                $this->answers[$user_answer->question_id] = $option->id;

                // Multiple Answer
                if ($question_is_multiple) {
                    $this->multiple_answers[$user_answer->question_id] = AnswerOption::where('answer_id', $user_answer->id)
                        ->pluck('option_id')
                        ->mapWithKeys(fn($id) => [$id => true]) 
                        ->toArray();

                    $this->final_answers_checkbox[$user_answer->question_id] = AnswerOption::where('answer_id', $user_answer->id)
                        ->get()
                        ->mapWithKeys(fn($option) => [
                            $option->option_id => [
                                'question_id' => $user_answer->question_id,
                                'option_id' => $option->option_id,
                                'option_has_other' => $option->has_other,
                                'option_has_other_text' => $option->other_text,
                            ]
                        ])
                        ->toArray();
                }

                // Select Only
                if (!$option->has_other && !$option->has_child && !$option->is_multiple) {
                    $this->final_answers[$user_answer->question_id] = [
                        'question_id' => $user_answer->question_id, 
                        'option_has_other' => 0, 
                        'option_id' => $option->id, 
                        'option_has_other_text' => null, 
                        'option_has_sub_option' => 0, 
                        'option_child_id' => 0, 
                        'option_child_has_other' => 0,  
                        'option_child_has_other_text' => null,
                        'option_child_multiple_select' => [],
                    ];
                } 
                // Select + Other
                elseif ($option->has_other && !$option->has_child && !$option->is_multiple) {
                    $this->final_answers[$user_answer->question_id] = [
                        'question_id' => $user_answer->question_id, 
                        'option_has_other' => 1, 
                        'option_id' => $option->id, 
                        'option_has_other_text' => $answer_option->other_text, 
                        'option_has_sub_option' => 0, 
                        'option_child_id' => 0, 
                        'option_child_has_other' => 0,  
                        'option_child_has_other_text' => null,
                        'option_child_multiple_select' => [],
                    ];
                }
                // Select + Select
                elseif (!$option->has_other && $option->has_child && !$option->is_multiple) {
                    $this->final_answers[$user_answer->question_id] = [
                        'question_id' => $user_answer->question_id,
                        'option_has_other' => 0,
                        'option_id' => $option->id,
                        'option_has_sub_option' => 1,
                        'option_child_id' => $answer_option->answerSubOptions->first()->sub_option_id,
                        'option_child_has_other' => $option->subOptions->find($answer_option->answerSubOptions->first()->sub_option_id)->has_other,
                        'option_child_has_other_text' => $answer_option->answerSubOptions->first()->other_text,
                    ];

                    $this->answers_with_child[$user_answer->question_id] = $answer_option->answerSubOptions->first()->sub_option_id;
                }

                elseif (!$option->has_other && $option->has_child && $option->is_multiple) {
                    $this->final_answers[$user_answer->question_id] = [
                        'question_id' => $user_answer->question_id,
                        'option_has_other' => 0,
                        'option_id' => $option->id,
                        'option_has_sub_option' => 1,
                        'option_child_id' => null, // Not used in multiple select
                        'option_child_has_other' => null,
                        'option_child_has_other_text' => null,
                        'option_child_multiple_select' => $answer_option->answerSubOptions->mapWithKeys(function ($subOption) use ($user_answer, $answer_option) {
                            return [
                                $subOption->sub_option_id => [ // ✅ `sub_option_id` as the index
                                    'question_id' => $user_answer->question_id, // Ensure question_id is captured
                                    'option_has_other' => Option::find($answer_option->option_id)->has_child,
                                    'option_has_other_text' => $subOption->other_text,
                                ],
                            ];
                        })->toArray(),
                    ];

                    $this->single_multiple_answer = $answer_option->answerSubOptions->pluck('sub_option_id')->toArray();
                }
            }
        }
    }

    public function hydrateSection()
    {
        $this->section->load('questions.options.subOptions');
    }
    
    public function updatedMultipleAnswers()
    {
        $this->multiple_answers = array_filter(
            array_map(fn($item) => array_filter($item), $this->multiple_answers)
        );
    }

    public function submitAnswer()
    {
        $user = Auth::user();

        $user->update([
            'h_e_a_id' => $this->h_e_a_id ?: null,
            'attending_school' => $this->attending_school ?: null,
            'year_level' => $this->year_level ?: null,
            'reason_for_absence_id' => $this->reason_for_absence_id ?: null,
            'not_attending_school_reason' => $this->not_attending_school_reason ?: null,
            'read_and_write' => $this->read_and_write ?: null,
        ]);

        foreach ($this->family_members as $member) {
            FamilyProfile::find($member['id'])->update(
                [
                    'h_e_a_id' => $member['h_e_a_id'] ?: null,
                    'attending_school' => $member['attending_school'] ?: null,
                    'year_level' => $member['year_level'],
                    'reason_for_absence_id' => $member['reason_for_absence_id'] ?: null,
                    'not_attending_school_reason' => $member['not_attending_school_reason'],
                    'read_and_write' => $member['read_and_write'] ?: null,
                ]
            );
        }

        // Handle single-answer questions
        foreach ($this->final_answers as $question_id => $answerData) {
            // Step 1: Save or update the main Answer record
            $answer = Answer::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'question_id' => $question_id,
                ],
                []
            );

            // Step 2: Remove previous AnswerOptions and their sub-options
            $answer->answerOptions()->each(function ($answerOption) {
                $answerOption->answerSubOptions()->delete();
                $answerOption->delete();
            });
            
            // Step 3: Handle the selected option for this question
            if (!empty($answerData['option_id'])) {
                $answerOption = AnswerOption::create([
                    'answer_id' => $answer->id,
                    'option_id' => $answerData['option_id'],
                    'other_text' => $answerData['option_has_other_text'] ?? null,
                ]);
                
                // Step 4: Handle sub-options (if any)
                if (!empty($answerData['option_has_sub_option'])) {
                    // Delete existing sub-options for this answer option
                    AnswerSubOption::where('answer_option_id', $answerOption->id)->delete();
                    // If multiple sub-options exist, insert each one
                    if (!empty($answerData['option_child_multiple_select'])) {
                        foreach ($answerData['option_child_multiple_select'] as $key => $value) {
                            AnswerSubOption::create([
                                'answer_option_id' => $answerOption->id,
                                'sub_option_id' => $key, 
                                'other_text' => $value['option_has_other_text'] ?? null,
                            ]);
                        }
                    } 
                    // If only a single sub-option exists, insert it
                    elseif (!empty($answerData['option_child_id'])) {
                        AnswerSubOption::create([
                            'answer_option_id' => $answerOption->id,
                            'sub_option_id' => $answerData['option_child_id'], 
                            'other_text' => $answerData['option_child_has_other_text'] ?? null,
                        ]);
                    }
                }
            }
        }

        // Handle multiple-answer (checkbox) questions
        foreach ($this->final_answers_checkbox as $question_id => $checkboxOptions) {
            
            // Step 1: Save or update the main Answer record
            $answer = Answer::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'question_id' => $question_id,
                ],
                []
            );

            // Step 2: Remove previous AnswerOptions
            $answer->answerOptions()->each(function ($answerOption) {
                $answerOption->delete(); // Sub-options not needed for checkboxes
            });

            // Step 3: Handle multiple selected options (CheckBoxes)
            foreach ($checkboxOptions as $option_id => $checkboxData) {
                AnswerOption::create([
                    'answer_id' => $answer->id,
                    'option_id' => $option_id,
                    'other_text' => $checkboxData['option_has_other_text'] ?? null,
                ]);
            }
        }

        $this->redirect(route('political-participation'), navigate: true);
    }

    public function updateSelection(
        $question_id, 
        $option_has_other = null, 
        $option_id, 
        $option_has_other_text = null, 
        $option_has_sub_option = null, 
        $option_child_id = null, 
        $option_child_has_other = null,  
        $option_child_has_other_text = null,
        $option_child_multiple_id = null
    ) {
        $this->current_option = $this->final_answers[$question_id]['option_id'] ?? null;
        // Ensure `final_answers` is an array
        $this->final_answers = $this->final_answers ?? [];

        // Ensure `option_child_multiple_select` is an array
        if (!isset($this->final_answers[$question_id]['option_child_multiple_select'])) {
            $this->final_answers[$question_id]['option_child_multiple_select'] = [];
        }

        // If checkbox is checked (selected)
        if ($option_child_multiple_id) {
            if (!isset($this->final_answers[$question_id]['option_child_multiple_select'][$option_child_multiple_id])) {
                // Store full details as associative array (not just ID)
                $this->final_answers[$question_id]['option_child_multiple_select'][$option_child_multiple_id] = [
                    'question_id' => $question_id,
                    'option_has_other' => $option_has_other,
                    'option_has_other_text' => $option_has_other_text,
                ];
            } else {
                // If already exists, remove it (uncheck action)
                unset($this->final_answers[$question_id]['option_child_multiple_select'][$option_child_multiple_id]);
            }
        }

        // Maintain other fields for `final_answers`
        $this->final_answers[$question_id] = array_merge(
            $this->final_answers[$question_id] ?? [],
            compact(
                'question_id', 'option_has_other', 'option_id', 
                'option_has_other_text', 'option_has_sub_option', 
                'option_child_id', 'option_child_has_other', 
                'option_child_has_other_text'
            )
        );

        // Clear Select
        if($this->current_option != $option_id) {
            $this->final_answers[$question_id]['option_child_multiple_select'] = [];
            $this->reset('single_multiple_answer');
            unset($this->answers_with_child[$question_id]);
        }

        // Remove `other_answers` if not needed
        if (
            (!$option_has_other && !$option_has_sub_option) || 
            (!$option_child_has_other && $option_child_id)
        ) {
            unset($this->other_answers[$question_id]);
        }

        // Remove from answers_with_child if no sub-option exists
        if (!$option_has_sub_option) {
            unset($this->answers_with_child[$question_id]);
        }
    }

    public function updateCheckboxSelection(
        $question_id, 
        $option_id, 
        $option_has_other = null,
        $option_has_other_text = null, 
    ) 
    {
        if (isset($this->multiple_answers[$question_id][$option_id])) {
            // Add option to the correct question_id
            $this->final_answers_checkbox[$question_id][$option_id] = [
                'question_id' => $question_id,
                'option_id' => $option_id,
                'option_has_other' => $option_has_other,
                'option_has_other_text' => $option_has_other_text,
            ];
        } else {
            // Remove option if unchecked
            unset($this->final_answers_checkbox[$question_id][$option_id]);

            // Remove question entry if no options are left
            if (empty($this->final_answers_checkbox[$question_id])) {
                unset($this->final_answers_checkbox[$question_id]);
            }
        }
    }

    public function smwoInput(
        $question_id, 
        $option_id, 
        $option_has_other_text = null,
    )
    {
        $this->final_answers[$question_id]['option_child_multiple_select'][$option_id]['option_has_other_text'] = $option_has_other_text;
    } 
}; ?> 

<div class="w-full max-w-4xl p-10 m-auto overflow-hidden bg-white border border-zinc-200 text-zinc-800 rounded-xl">
    <x-frontend.header :message="$section->name"/>
        
    <div class="relative p-8 mt-8 space-y-6 border rounded-lg border-zinc-200">
        <x-frontend.header-description class="!text-sky-600" :message="'Respondent'"/>
        <div class="!mt-6 grid gap-6">
            <div class="flex gap-2">
                <x-frontend.header-description :message="'Name:'"/>
                <p>{{ $user->name }}</p>
            </div>
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <x-frontend.header-description :message="'What is the highest educational attainment?:'"/>
                    <x-form.select class="!mt-2" wire:model="h_e_a_id" required>
                        @foreach ($heas as $hea)
                            <option value="{{ $hea->id }}">{{ $hea->name }}</option>
                        @endforeach
                    </x-form.select>
                </div>
                <div>
                    <x-frontend.header-description :message="'Is currently attending school?:'"/>
                    <x-form.select class="!mt-2" wire:model="attending_school" required>
                        @foreach ($confirmations as $confirmation)
                            <option value="{{ $confirmation->id }}">{{ $confirmation->name }}</option>
                        @endforeach
                    </x-form.select>
                </div>
            </div>
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <x-frontend.header-description :message="'If yes, what grade or year?:'"/>
                    <x-form.input class="!mt-2 w-full" wire:model="year_level"/>
                </div>
                <div x-data="{ reasonText: '' }"
                    x-init="
                        if ($wire.not_attending_school_reason) {
                            reasonText = 'Other';
                        }
                    ">
                    <x-frontend.header-description :message="'If no, why not attending school?'" />
                    <x-form.select class="!mt-2" wire:model="reason_for_absence_id" required
                        @change="
                            reasonText = $event.target.selectedOptions[0].text;
                            if (reasonText !== 'Other') {
                                $wire.set('not_attending_school_reason', null);
                            }
                        ">
                        @foreach ($reason_for_absences as $reason_for_absence)
                            <option value="{{ $reason_for_absence->id }}">{{ $reason_for_absence->name }}</option>
                        @endforeach
                    </x-form.select>
                
                    <div x-show="reasonText === 'Other' || $wire.not_attending_school_reason" class="mt-2">
                        <p class="text-sm text-red-500">Please specify the reason</p>
                        <x-form.input class="!mt-2"
                            wire:model="not_attending_school_reason"
                            x-bind:required="reasonText === 'Other'"/>
                    </div>
                </div>
            </div>
            <div class="grid gap-6">
                <div>
                    <x-frontend.header-description :message="'Can read and write a simple message in any language or dialect?:'"/>
                    <x-form.select class="!mt-2" wire:model="read_and_write" required>
                        @foreach ($confirmations as $confirmation)
                            <option value="{{ $confirmation->id }}">{{ $confirmation->name }}</option>
                        @endforeach
                    </x-form.select>
                </div>
            </div>
        </div>
    </div>

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
                        {{-- 'h_e_a_id' => $member->h_e_a_id,
                        'attending_school' => $member->attending_school,
                        'year_level' => $member->year_level,
                        'reason_for_absence_id' => $member->reason_for_absence_id,
                        'not_attending_school_reason' => $member->not_attending_school_reason,
                        'read_and_write' => $member->read_and_write, --}}
                        <x-frontend.header-description :message="'What is the highest educational attainment?:'"/>
                        <x-form.select class="!mt-2" wire:model="family_members.{{ $index }}.h_e_a_id" required>
                            @foreach ($heas as $hea)
                                <option value="{{ $hea->id }}">{{ $hea->name }}</option>
                            @endforeach
                        </x-form.select>
                    </div>
                    <div>
                        <x-frontend.header-description :message="'Is currently attending school?:'"/>
                        <x-form.select class="!mt-2" wire:model="family_members.{{ $index }}.attending_school" required>
                            @foreach ($confirmations as $confirmation)
                                <option value="{{ $confirmation->id }}">{{ $confirmation->name }}</option>
                            @endforeach
                        </x-form.select>
                    </div>
                </div>
                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <x-frontend.header-description :message="'If yes, what grade or year?:'"/>
                        <x-form.input class="!mt-2 w-full" wire:model="family_members.{{ $index }}.year_level"/>
                    </div>
                    <div x-data="{ reasonText: '' }"
                        x-init="
                            if ($wire.family_members[{{ $index }}].not_attending_school_reason) {
                                reasonText = 'Other';
                            }
                        ">
                        <x-frontend.header-description :message="'If no, why not attending school?'" />
                        <x-form.select class="!mt-2" wire:model="family_members.{{ $index }}.reason_for_absence_id" required
                            @change="
                                reasonText = $event.target.selectedOptions[0].text;
                                if (reasonText !== 'Other') {
                                    $wire.set('family_members.{{ $index }}.not_attending_school_reason', null);
                                }
                            ">
                            @foreach ($reason_for_absences as $reason_for_absence)
                                <option value="{{ $reason_for_absence->id }}">{{ $reason_for_absence->name }}</option>
                            @endforeach
                        </x-form.select>
                    
                        <div x-show="reasonText === 'Other' || $wire.family_members[{{ $index }}].not_attending_school_reason" class="mt-2">
                            <p class="text-sm text-red-500">Please specify the reason</p>
                            <x-form.input class="!mt-2"
                                wire:model="family_members.{{ $index }}.not_attending_school_reason"
                                x-bind:required="reasonText === 'Other'"/>
                        </div>
                    </div>
                </div>
                <div class="grid gap-6">
                    <div>
                        <x-frontend.header-description :message="'Can read and write a simple message in any language or dialect?:'"/>
                        <x-form.select class="!mt-2" wire:model="family_members.{{ $index }}.read_and_write" required>
                            @foreach ($confirmations as $confirmation)
                                <option value="{{ $confirmation->id }}">{{ $confirmation->name }}</option>
                            @endforeach
                        </x-form.select>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    <form wire:submit="submitAnswer">
        <div class="mt-8">
            <ol class="ml-5 space-y-6 list-decimal">
                @foreach($section->questions as $index => $question)
                    <li wire:key="questions-{{ $index }}">
                        {{-- Single Answer --}}
                        @if(!$question->is_multiple)
                            <div>
                                <span class="font-bold">{{ $question->question_text }}</span>
                                <div class="mt-4">
                                    <div class="grid gap-2">
                                        @foreach ($question->options as $index => $option)
                                            @php
                                                $opt = $question->options[$index];
                                                // Single Answer / Single Answer + Other
                                                $s_so = !$opt->is_multiple && !$opt->has_child;
                                                // Single Answer + Single Answer with Other
                                                $sswo = !$opt->is_multiple && $opt->has_child;
                                                // Single Aswer + Multiple Answer with other
                                                $smwo = $opt->is_multiple && $opt->has_child;
                                            @endphp
                                            @if($s_so)
                                                <label class="flex items-center space-x-2" wire:key="option-{{ $index }}">
                                                    <input 
                                                        type="radio" 
                                                        value="{{ $option['id'] }}" 
                                                        class="border-gray-300 rounded text-sky-600 focus:ring-sky-400"
                                                        wire:model.change="answers.{{ $question->id }}"
                                                        wire:change="updateSelection({{ $question->id }}, {{ $option['has_other'] }}, {{ $option['id'] }}, null, 0, 0, 0, null, 0, null)"
                                                    >
                                                    <span>{{ $option['option_text'] }}</span>
                                                </label>
                                        
                                                @if ($option['has_other'])
                                                    @if (isset($answers[$question->id]) && $answers[$question->id] == $option['id'])
                                                        <x-form.input 
                                                            wire:model.live="final_answers.{{ $question->id }}.option_has_other_text" 
                                                            wire:input="updateSelection({{ $question->id }}, {{ $option['has_other'] }}, {{ $option['id'] }}, $event.target.value, 0, 0, 0, null, 0, null)"
                                                            placeholder="Please specify"
                                                        />
                                                    @endif
                                                @endif
                                            @endif
                                            @if ($sswo)
                                                <label class="flex items-center space-x-2" wire:key="option-{{ $index }}">
                                                    <input 
                                                        type="radio" 
                                                        value="{{ $option['id'] }}" 
                                                        class="border-gray-300 rounded text-sky-600 focus:ring-sky-400"
                                                        wire:model.change="answers.{{ $question->id }}"
                                                        wire:change="updateSelection({{ $question->id }}, {{ $option['has_other'] }}, {{ $option['id'] }}, null, 1, null, null, null, 0)"

                                                    >
                                                    <span>{{ $option['option_text'] }}</span>
                                                </label>

                                                @if (isset($option->subOptions) && !empty($option->subOptions))
                                                    <div>
                                                        @foreach($option->subOptions as $sub_option)
                                                            <label class="flex items-center ml-8 space-x-2" wire:key="sub_option-{{ $index }}">
                                                                <input 
                                                                    type="radio" 
                                                                    value="{{ $sub_option['id'] }}"
                                                                    class="border-gray-300 rounded text-sky-600 focus:ring-sky-400"
                                                                    wire:model.change="answers_with_child.{{ $question->id }}"
                                                                    wire:change="updateSelection({{ $question->id }}, {{ $option['has_other'] }}, {{ $option['id'] }}, null, 1, {{ $sub_option['id'] }}, {{ $sub_option['has_other'] }}, null, 0, null)"
                                                                    {{ !in_array($sub_option->option_id, $answers) ? 'disabled' : '' }}
                                                                >
                                                                <span>{{ $sub_option['sub_option_text'] }}</span>
                                                            </label>
                                                            @if ($sub_option['has_other'])
                                                                @if (isset($final_answers[$question->id]['option_child_id']) && in_array($final_answers[$question->id]['option_child_id'], $answers_with_child) && $final_answers[$question->id]['option_child_has_other'])
                                                                    <div class="my-2">
                                                                        <x-form.input 
                                                                            wire:model.live="final_answers.{{ $question->id }}.option_child_has_other_text"
                                                                            wire:input="updateSelection({{ $question->id }}, {{ $option['has_other'] }}, {{ $option['id'] }}, null, 1, {{ $sub_option['id'] }}, {{ $sub_option['has_other'] }}, event.target.value, 0, null)"
                                                                            placeholder="Please specify"
                                                                        />
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                            @endif
                                            @if ($smwo)
                                            <div>
                                                <div class="">
                                                    <div class="grid gap-2">
                                                        <label class="flex items-center space-x-2" wire:key="option-{{ $index }}">
                                                            <input 
                                                                type="radio" 
                                                                value="{{ $option['id'] }}" 
                                                                class="border-gray-300 rounded text-sky-600 focus:ring-sky-400"
                                                                wire:model.change="answers.{{ $question->id }}"
                                                                wire:change="updateSelection({{ $question->id }}, 0, {{ $option['id'] }}, null, 1, null, null, null, null, null)"
                                                            >
                                                            <span>{{ $option['option_text'] }}</span>
                                                        </label>
            
                                                        @if (isset($option->subOptions) && !empty($option->subOptions))
                                                            <div>
                                                                @foreach($option->subOptions as $sub_option)
                                                                    <label class="flex items-center ml-8 space-x-2" wire:key="sub_option-{{ $index }}">
                                                                        <input 
                                                                            type="checkbox" 
                                                                            value="{{ $sub_option['id'] }}"
                                                                            class="border-gray-300 rounded text-sky-600 focus:ring-sky-400"
                                                                            wire:model.change="single_multiple_answer"
                                                                            wire:change="updateSelection({{ $question->id }}, {{$sub_option['has_other']}}, {{ $option['id'] }}, null, 1, null, null, null, {{ $sub_option->id }}, null)"
                                                                            {{ !in_array($sub_option->option_id, $answers) ? 'disabled' : '' }}
                                                                        >
                                                                        <span>{{ $sub_option['sub_option_text'] }}</span>
                                                                    </label>
                                                                    @if ($sub_option['has_other'])
                                                                        @if (isset($final_answers[$question->id]['option_child_multiple_select'][$sub_option['id']]) && $final_answers[$question->id]['option_child_multiple_select'][$sub_option['id']]['option_has_other'])
                                                                            <div class="my-2">
                                                                                <x-form.input 
                                                                                    wire:model.live="final_answers.{{ $question->id }}.option_child_multiple_select.{{ $sub_option['id'] }}.option_has_other_text"
                                                                                    wire:input="smwoInput({{$question->id}}, {{ $sub_option['id'] }}, event.target.value)"
                                                                                    placeholder="Please specify"
                                                                                />
                                                                            </div>
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{-- Multiple --}}
                        @if($question->is_multiple)
                            <div>
                                <span class="font-bold">{{ $question->question_text }}</span>
                                <div class="mt-4">
                                    <div class="grid gap-2">
                                        @foreach ($question->options as $index => $option)
                                            @php
                                                $opt = $question->options[$index];
                                                // Single Answer / Single Answer + Other
                                                $s_so = !$opt->is_not_multiple && !$opt->has_child;
                                                // Single Answer + Single Answer with Other
                                                $sswo = !$opt->is_not_multiple && $opt->has_child;
                                                // // Multiple
                                                // $multiple = $opt->is_not_multiple;
                                            @endphp
                                            @if($s_so)
                                                <label class="flex space-x-2" wire:key="option-{{ $question['id'] }}-{{ $index }}">
                                                    <input 
                                                        type="checkbox" 
                                                        value="{{ $option['id'] }}" 
                                                        class="relative border-gray-300 rounded text-sky-600 focus:ring-sky-400"
                                                        wire:model.change="multiple_answers.{{ $question['id'] }}.{{ $option['id'] }}" 
                                                        wire:change="updateCheckboxSelection({{ $question->id }}, {{ $option['id'] }}, {{ $option['has_other'] }}, null)"
                                                    >
                                                    <span>{{ $option['option_text'] }}</span>
                                                </label>
                                                @if ($option['has_other'])
                                                    @if (isset($multiple_answers[$question->id][$option['id']]) && $multiple_answers[$question->id][$option['id']] == $option['id'])
                                                        {{-- @dump($final_answers_checkbox, $question->id, $option['id']) --}}
                                                        <x-form.input 
                                                            wire:model.live.debounce.250ms="final_answers_checkbox.{{ $question->id }}.{{$option['id']}}.option_has_other_text" 
                                                            {{-- wire:input="updateCheckboxSelection({{ $question->id }}, {{ $option['has_other'] }}, {{ $option['id'] }}, $event.target.value, 0, 0, 0, null)" --}}
                                                            {{-- wire:input="updateCheckboxSelection({{ $question->id}}, {{ $option['id']}}, {{ $option['has_other'] }}, $event.target.value)" --}}
                                                            placeholder="Please specify"
                                                        />
                                                    @endif
                                                @endif
                                            @endif
                                            @if ($sswo)
                                                <label class="flex items-center space-x-2" wire:key="option-{{ $index }}">
                                                    <input 
                                                        type="checkbox" 
                                                        value="{{ $option['id'] }}" 
                                                        class="border-gray-300 rounded text-sky-600 focus:ring-sky-400"
                                                        wire:model.change="answers.{{ $question->id }}"
                                                        wire:change="updateCheckboxSelection({{ $question->id }}, {{ $option['has_other'] }}, {{ $option['id'] }}, null, 1, null, null, null)"
                                                    >
                                                    <span>{{ $option['option_text'] }}</span>
                                                </label>

                                                @if (isset($option->subOptions) && !empty($option->subOptions))
                                                    <div>
                                                        @foreach($option->subOptions as $sub_option)
                                                            <label class="flex items-center ml-8 space-x-2" wire:key="sub_option-{{ $index }}">
                                                                <input 
                                                                    type="checkbox" 
                                                                    value="{{ $sub_option['id'] }}"
                                                                    class="border-gray-300 rounded text-sky-600 focus:ring-sky-400"
                                                                    wire:model.change="answers_with_child.{{ $question->id }}"
                                                                    wire:change="updateCheckboxSelection({{ $question->id }}, {{ $option['has_other'] }}, {{ $option['id'] }}, null, 1, {{ $sub_option['id'] }}, {{ $sub_option['has_other'] }}, null)"
                                                                    {{ !in_array($sub_option->option_id, $answers) ? 'disabled' : '' }}
                                                                >
                                                                <span>{{ $sub_option['sub_option_text'] }}</span>
                                                            </label>
                                                            @if ($sub_option['has_other'])
                                                                @if (isset($final_answers[$question->id]['option_child_id']) && in_array($final_answers[$question->id]['option_child_id'], $answers_with_child) && $final_answers[$question->id]['option_child_has_other'])
                                                                    <div class="my-2">
                                                                        <x-form.input 
                                                                            wire:model.live.debounce.250ms="other_answers.{{ $question->id }}"
                                                                            wire:input="updateCheckboxSelection({{ $question->id }}, {{ $option['has_other'] }}, {{ $option['id'] }}, null, 1, {{ $sub_option['id'] }}, {{ $sub_option['has_other'] }}, event.target.value)"
                                                                            placeholder="Please specify"
                                                                        />
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ol>
        </div>
        <div class="flex justify-end gap-4 mt-8">
            <div class="w-full">
                <a wire:navigate href="{{ route('mental-health-and-wellbeing') }}">
                    <x-form.button class="max-w-40 !bg-transparent !text-neutral-800 border border-gray-300" type="button">
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
        <x-form.progress-indicator :start="1" :end="10" :current="6" />
    </div>
</div>