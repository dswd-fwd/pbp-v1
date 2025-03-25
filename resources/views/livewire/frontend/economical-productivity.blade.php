<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Livewire\Volt\Component;
use Livewire\Attributes\{Validate, Layout};
use App\Models\{Section, Question, Option, SubOption, Answer, AnswerOption, AnswerSubOption, HEA, ReasonForAbsence, Confirmation, FamilyProfile, UserEconomicalActivity, OtherSourceAnswer, CodeSKill, Interviewer};
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
    public $code_skills;
    public $interviewers;
    public $interviewer_id;
    public $family_members = [];
    public $family_members_skills = [];
    public $entrepreneurial_activities = [
        'Crop Farming and Gardening',
        'Livestock and Poultry Raising',
        'Fishing',
        'Forestry and Hunting',
        'Wholesale and Retail',
        'Manufacturing',
        'Community, Social, Recreational and Personal Services',
        'Transportation, Storage and Communication Services',
        'Mining and Quarrying',
        'Construction',
        'Punta sa urban cities (begging)',
        'Activities Not Elsewhere Classified',
    ];
    public $entrepreneurial_answer = [];
    public $other_sources = [
        'Receipts, gifts, support, relief and other forms of assistance including those from OFWs',
        'Receipts, gifts, support and assistance from other families/entities in the country',
        'Support received from the Philippine Government',
        'Others, specify:',
    ];
    public $other_sources_answer = [];

    public $modalOpen = false;
    public $signature;

    // Salaries and Wages
    public $employment_last_six_months = '';
    public $income_cash = '';
    public $income_kind = '';

    // Skills
    public $code_skill_current_id = '';
    public $code_skill_current_other = '';
    public $code_skill_acquire_id = '';
    public $code_skill_acquire_other = '';
    public $remarks = '';
    public $certified = '';

    public function mount()
    {
        if (!auth()->check()) {
            $this->redirect(route('respondent-profile'), navigate: true);
        }

        $this->user = Auth::user();
        $this->heas = HEA::get();
        $this->interviewers = Interviewer::get();
        $this->section = Section::with('questions.options.subOptions')->where('name', 'ECONOMIC PRODUCTIVITY')->first();
        $this->reason_for_absences = ReasonForAbsence::get();
        $this->code_skills = CodeSkill::get();
        $this->confirmations = Confirmation::get();
        $this->user_family_members = $this->user->familyMembers()->get();

        // User Salary, wages, and skills
        $this->employment_last_six_months = $this->user->employment_last_six_months ?: '';
        $this->income_cash = $this->user->income_cash ?: '';
        $this->income_kind = $this->user->income_kind ?: '';
        $this->code_skill_current_id = $this->user->code_skill_current_id ?: '';
        $this->code_skill_current_other = $this->user->code_skill_current_other ?: '';
        $this->code_skill_acquire_id = $this->user->code_skill_acquire_id ?: '';
        $this->code_skill_acquire_other = $this->user->code_skill_acquire_other ?: '';
        $this->remarks = $this->user->remarks ?: '';
        $this->certified = $this->user->certified ?: '';

        // Family Members
        $this->family_members = $this->user->familyMembers()
            ->get()
            ->map(function ($member) {
                return [
                    'id' => $member->id,
                    'employment_last_six_months' => $member->employment_last_six_months ?: '',
                    'income_cash' => $member->income_cash ?: '',
                    'income_kind' => $member->income_kind ?: '',
                ];
            })->toArray();

        // Entrepreneurial Activities - Fetch existing data
        $this->entrepreneurial_answer = [];
        foreach ($this->entrepreneurial_activities as $index => $activity) {
            $existingData = UserEconomicalActivity::where('user_id', $this->user->id)
                ->where('activity_type', $activity)
                ->first();

            $this->entrepreneurial_answer[$index] = [
                'activity_type' => $activity, // Add this line
                'employment_last_six_months' => $existingData->employment_last_six_months ?? '',
                'income_cash' => $existingData->income_cash ?? '',
                'income_kind' => $existingData->income_kind ?? '',
            ];
        }

        // Other Sources - Fetch existing data
        $this->other_sources_answer = [];
        foreach ($this->other_sources as $index => $source_category) {
            // Fetch existing data for each source category
            $existingData = OtherSourceAnswer::where('user_id', $this->user->id)
                ->where('source_category', $source_category)
                ->first();

            // If no existing data is found, set default values
            if (!$existingData) {
                $this->other_sources_answer[$index] = [
                    'source_category' => $source_category, // Store source_category
                    'employment_last_six_months' => '',
                    'income_cash' => '',
                    'income_kind' => '',
                    'other' => '',
                ];
            } else {
                // If data is found, store it
                $this->other_sources_answer[$index] = [
                    'source_category' => $source_category, // Store source_category
                    'employment_last_six_months' => $existingData->employment_last_six_months ?? '',
                    'income_cash' => $existingData->income_cash ?: '', // Handle empty values
                    'income_kind' => $existingData->income_kind ?: '', // Handle empty values
                    'other' => $existingData->other_specify ?: '', // Handle other_specify field
                ];
            }
        }

        // Family Members Skills
        $this->family_members_skills = $this->user->familyMembers()
        ->get()
        ->map(function ($member) {
            return [
                'id' => $member->id,
                'name' => $member->name,
                'code_skill_current_id' => $member->code_skill_current_id ?: '',
                'code_skill_current_other' => $member->code_skill_current_other ?: '',
                'code_skill_acquire_id' => $member->code_skill_acquire_id ?: '',
                'code_skill_acquire_other' => $member->code_skill_acquire_other ?: '',
                'remarks' => $member->remarks ?: '',
                'certified' => $member->certified ?: '',
            ];
        })->toArray();

        $this->interviewer_id = $this->user->interviewer_id ?: '';
        
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

    public function submitAnswer()
    {
        $user = Auth::user();

        $user->update([
            'employment_last_six_months' => $this->employment_last_six_months ?: null,
            'income_cash' => $this->income_cash ?: null,
            'income_kind' => $this->income_kind ?: null,
            'code_skill_current_id' => $this->code_skill_current_id ?: null,
            'code_skill_current_other' => $this->code_skill_current_other ?: null,
            'code_skill_acquire_id' => $this->code_skill_acquire_id ?: null,
            'code_skill_acquire_other' => $this->code_skill_acquire_other ?: null,
            'remarks' => $this->remarks ?: null,
            'certified' => $this->certified ?: null,
        ]);

        foreach ($this->family_members as $member) {
            FamilyProfile::find($member['id'])->update(
                [
                    'employment_last_six_months' => $member['employment_last_six_months'] ?: null,
                    'income_cash' => $member['income_cash'] ?: null,
                    'income_kind' => $member['income_kind'] ?: null,
                ]
            );
        }

        // Handle Family Member Skills
        foreach ($this->family_members_skills as $member) {
            FamilyProfile::find($member['id'])->update(
                [
                    'code_skill_current_id' => $member['code_skill_current_id'] ?: null,
                    'code_skill_current_other' => $member['code_skill_current_other'] ?: null,
                    'code_skill_acquire_id' => $member['code_skill_acquire_id'] ?: null,
                    'code_skill_acquire_other' => $member['code_skill_acquire_other'] ?: null,
                    'remarks' => $member['remarks'] ?: null,
                    'certified' => $member['certified'] ?: null,
                ]
            );
        }

        // Handle entrepreneurial answers
        foreach ($this->entrepreneurial_answer as $answer) {
            UserEconomicalActivity::updateOrCreate(
                ['user_id' => $user->id, 'activity_type' => $answer['activity_type']], // Check by user & activity type
                [
                    'employment_last_six_months' => $answer['employment_last_six_months'] ?: null,
                    'income_cash' => $answer['income_cash'] ?: null,
                    'income_kind' => $answer['income_kind'] ?: null,
                ]
            );
        }

        // Handle Other Sources Answer
        foreach ($this->other_sources_answer as $index => $answer) {
            OtherSourceAnswer::updateOrCreate(
                ['user_id' => Auth::id(), 'source_category' => $answer['source_category']],
                [
                    'employment_last_six_months' => $answer['employment_last_six_months'] ?: null,
                    'income_cash' => $answer['income_cash'] !== '' ? $answer['income_cash'] : null,
                    'income_kind' => $answer['income_kind'] !== '' ? $answer['income_kind'] : null,
                    'other_specify' => $answer['other'] ?: null, 
                ]
            );
        }

        // Dynamic Form
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

        $this->modalOpen = true;
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

    public $signatureData;

    public function saveSignature()
    {
        $user = Auth::user();
        $fileName = "{$user->uuid}.png";
        $path = public_path("img/signature/{$fileName}"); // Directly inside public/

        // Decode base64 image
        $signature = str_replace('data:image/png;base64,', '', $this->signatureData);
        $signature = base64_decode($signature);

        // dd($signature);

        // Save the file directly in public/
        file_put_contents($path, $signature);
    }



    public function doneForm()
    {
        $user = $this->user;
        $fileName = "{$user->uuid}.png";
        $path = public_path("img/qr_code/{$fileName}"); // Directly inside public/

        // Ensure directory exists
        if (!file_exists(public_path('img/qr_code'))) {
            mkdir(public_path('img/qr_code'), 0777, true);
        }

        // Generate QR code and save
        file_put_contents($path, QrCode::format('png')->size(250)->errorCorrection('H')->generate($user->uuid));

        // Update interviewer_id
        $user->update([
            'interviewer_id' => $this->interviewer_id,
        ]);

        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        $this->redirect(route('respondent-profile'), navigate: true);
    }

}; ?> 

<div class="w-full max-w-4xl p-10 m-auto overflow-hidden bg-white border border-zinc-200 text-zinc-800 rounded-xl">
    <x-frontend.header :message="'ECONOMICAL PRODUCTIVITY'"/>

    <form wire:submit="submitAnswer">
        <div>
            <div class="mt-8">
                <p class="font-semibold text-zinc-900">1. Salaries and Wages</p>
                <p>Has any member of the family been employed in the last six months? </p>
            </div>
            <div class="w-full overflow-x-auto">
                <table class="w-full mt-8 bg-white border-collapse rounded-lg shadow-lg">
                    <thead class="text-white bg-[#0B5394] border border-white">
                        <tr class="border-b border-white">
                            <th class="p-4 text-center border-r border-white" colspan="2"></th>
                            <th class="p-4 text-center border-l border-white" colspan="2">Total Net Value of Income</th>
                        </tr>
                        <tr class="border-t border-white">
                            <th class="p-4 text-left border-r border-white whitespace-nowrap">Family Members</th>
                            <th class="p-4 text-left border-r border-white whitespace-nowrap">(Y/N)</th>
                            <th class="p-4 text-left border-r border-white whitespace-nowrap">In Cash</th>
                            <th class="p-4 text-left whitespace-nowrap">In Kind</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b hover:bg-gray-100">
                            <td class="p-4 min-w-56">{{ $user->name }}</td>
                            <td class="p-4 min-w-36">
                                <x-form.select class="" wire:model="employment_last_six_months">
                                    @foreach ($confirmations as $confirmation)
                                        <option value="{{ $confirmation->id }}">{{ $confirmation->name }}</option>
                                    @endforeach
                                </x-form.select>
                            </td>
                            <td class="p-4 min-w-36 max-w-36">
                                <x-form.input class="w-full" type="number" step="0.01" wire:model="income_cash"/>
                            </td>
                            <td class="p-4 min-w-36 max-w-36">
                                <x-form.input class="w-full" type="number" step="0.01" wire:model="income_kind"/>
                            </td>
                        </tr>
                        @foreach ($user_family_members as $index => $user_family_member)
                            <tr class="border-b hover:bg-gray-100">
                                <td class="p-4 min-w-56">{{ $user_family_member->name }}</td>
                                <td class="p-4 min-w-36">
                                    <x-form.select class="" wire:model="family_members.{{ $index }}.employment_last_six_months">
                                        @foreach ($confirmations as $confirmation)
                                            <option value="{{ $confirmation->id }}">{{ $confirmation->name }}</option>
                                        @endforeach
                                    </x-form.select>
                                </td>
                                <td class="p-4 min-w-36 max-w-36">
                                    <x-form.input class="w-full" type="number" step="0.01" wire:model="family_members.{{ $index }}.income_cash"/>
                                </td>
                                <td class="p-4 min-w-36 max-w-36">
                                    <x-form.input class="w-full" type="number" step="0.01" wire:model="family_members.{{ $index }}.income_kind"/>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <div class="mt-16">
                <p class="font-semibold text-zinc-900">2. Entrepreneurial Activities</p>
            </div>
            <div class="w-full overflow-x-auto">
                <table class="w-full mt-8 bg-white border-collapse rounded-lg shadow-lg">
                    <thead class="text-white bg-[#0B5394] border border-white">
                        <tr class="border-b border-white">
                            <th class="p-4 text-center border-r border-white" colspan="2"></th>
                            <th class="p-4 text-center border-l border-white" colspan="2">If yes, what was the total net value of income from these activities?</th>
                        </tr>
                        <tr class="border-t border-white">
                            <th class="p-4 text-left border-r border-white ">During the past six (6) months, did you or any member of your family engage as operator/worker in any of the following entrepreneurial activities?</th>
                            <th class="p-4 text-left border-r border-white whitespace-nowrap">
                                (Y/N)
                                <p class="text-xs text-[#0B5394]">
                                    ...
                                </p>
                            </th>
                            <th class="p-4 text-left border-r border-white whitespace-nowrap">
                                In Cash
                                <p class="text-xs text-[#0B5394]">
                                    ...
                                </p>
                            </th>
                            <th class="p-4 text-left whitespace-nowrap">
                                <p>Unit</p>
                                <p class="text-xs">
                                    (Per year/month)
                                </p>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entrepreneurial_activities as $index => $entrepreneurial_activity)
                            <tr class="border-b hover:bg-gray-100">
                                <td class="p-4 min-w-56">{{ $entrepreneurial_activity }}</td>
                                <td class="p-4 min-w-36">
                                    <x-form.select wire:model="entrepreneurial_answer.{{ $index }}.employment_last_six_months">
                                        @foreach ($confirmations as $confirmation)
                                            <option value="{{ $confirmation->id }}">{{ $confirmation->name }}</option>
                                        @endforeach
                                    </x-form.select>
                                </td>
                                <td class="p-4 min-w-36 max-w-36">
                                    <x-form.input class="w-full" wire:model="entrepreneurial_answer.{{ $index }}.income_cash" />
                                </td>
                                <td class="p-4 min-w-36 max-w-36">
                                    <x-form.input class="w-full" wire:model="entrepreneurial_answer.{{ $index }}.income_kind" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Other Sources --}}
        <div>
            <div class="mt-16">
                <p class="font-semibold text-zinc-900">3. Other Sources</p>
            </div>
            <div class="w-full overflow-x-auto">
                <table class="w-full mt-8 bg-white border-collapse rounded-lg shadow-lg">
                    <thead class="text-white bg-[#0B5394] border border-white">
                        <tr class="border-b border-white">
                            <th class="p-4 text-center border-r border-white" colspan="2"></th>
                            <th class="p-4 text-center border-l border-white" colspan="2">If yes, what was the total net value of income from these activities?</th>
                        </tr>
                        <tr class="border-t border-white">
                            <th class="p-4 text-left border-r border-white ">During the past six (6) months, did you or any member of your family receive support from the following categories?</th>
                            <th class="p-4 text-left border-r border-white whitespace-nowrap">
                                (Y/N)
                            </th>
                            <th class="p-4 text-left border-r border-white whitespace-nowrap">
                                In Cash
                            </th>
                            <th class="p-4 text-left whitespace-nowrap">
                                <p>In Kind</p>
                       
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($other_sources as $index => $other_source)
                            <tr class="border-b hover:bg-gray-100" wire:key="other-source-{{ $index }}">
                                <td class="p-4 min-w-56">
                                    {{ $other_source }}
                                    @if ($other_source == 'Others, specify:')
                                        <x-form.input class="w-full mt-2" wire:model="other_sources_answer.{{ $index }}.other" />
                                    @endif
                                </td>
                                <td class="p-4 min-w-36">
                                    <x-form.select wire:model="other_sources_answer.{{ $index }}.employment_last_six_months">
                                        @foreach ($confirmations as $confirmation)
                                            <option value="{{ $confirmation->id }}">{{ $confirmation->name }}</option>
                                        @endforeach
                                    </x-form.select>
                                </td>
                                <td class="p-4 min-w-36 max-w-36">
                                    <x-form.input class="w-full" wire:model="other_sources_answer.{{ $index }}.income_cash" />
                                </td>
                                <td class="p-4 min-w-36 max-w-36">
                                    <x-form.input class="w-full" wire:model="other_sources_answer.{{ $index }}.income_kind" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            </div>
        </div>

        {{-- Form --}}
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
                                                <div class="mt-4">
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

        <div>
            <div class="mt-8">
                <p class="font-semibold text-zinc-900">4. Skills of Family Members</p>
            </div>
            <div class="relative p-8 mt-8 space-y-6 border rounded-lg border-zinc-200">
                <div class="grid gap-6">
                    <div class="flex gap-2">
                        <x-frontend.header-description :message="'Name:'"/>
                        <p>{{ $user->name }}</p>
                    </div>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div x-data="{ currentSkillText: '' }" 
                            x-init="
                                if ($wire.code_skill_current_other) {
                                    currentSkillText = 'Other';
                                }
                            ">
                            <x-frontend.header-description :message="'Skills the Family Members Currently Have'"/>
                            <x-form.select class="!mt-2" wire:model="code_skill_current_id"
                                @change="
                                    currentSkillText = $event.target.selectedOptions[0].text;
                                    if (currentSkillText !== 'Other') {
                                        $wire.set('code_skill_current_other', null);
                                    }
                                ">
                                @foreach ($code_skills as $code_skill)
                                    <option value="{{ $code_skill->id }}">{{ $code_skill->name }}</option>
                                @endforeach
                            </x-form.select>
                        
                            <div x-show="currentSkillText === 'Other' || $wire.code_skill_current_other" class="mt-2">
                                <p class="text-sm text-red-500">Please specify the skill</p>
                                <x-form.input class="!mt-2" 
                                    wire:model="code_skill_current_other" 
                                    x-bind:required="currentSkillText === 'Other'"/>
                            </div>
                        </div>
                        <div>
                            <x-frontend.header-description :message="'Certified (Yes/No)'"/>
                            <x-form.select class="!mt-2" wire:model="certified">
                                @foreach ($confirmations as $confirmation)
                                    <option value="{{ $confirmation->id }}">{{ $confirmation->name }}</option>
                                @endforeach
                            </x-form.select>
                        </div>
                    </div>
                    <div class="grid gap-6 md:grid-cols-1">
                        <div x-data="{ desiredSkillText: '' }" 
                            x-init="
                                if ($wire.code_skill_acquire_other) {
                                    desiredSkillText = 'Other';
                                }
                            ">
                            <x-frontend.header-description :message="'Skills the Family Members are Willing to Acquire'"/>
                            <x-form.select class="!mt-2" wire:model="code_skill_acquire_id"
                                @change="
                                    desiredSkillText = $event.target.selectedOptions[0].text;
                                    if (desiredSkillText !== 'Other') {
                                        $wire.set('code_skill_acquire_other', null);
                                    }
                                ">
                                @foreach ($code_skills as $code_skill)
                                    <option value="{{ $code_skill->id }}">{{ $code_skill->name }}</option>
                                @endforeach
                            </x-form.select>
                        
                            <div x-show="desiredSkillText === 'Other' || $wire.code_skill_acquire_other" class="mt-2">
                                <p class="text-sm text-red-500">Please specify the skill</p>
                                <x-form.input class="!mt-2" 
                                    wire:model="code_skill_acquire_other" 
                                    x-bind:required="desiredSkillText === 'Other'"/>
                            </div>
                        </div>
                        <div>
                            <x-frontend.header-description :message="'Remarks'"/>
                            <x-form.input class="!mt-2" wire:model="remarks"/>
                        </div>
                    </div>
                </div>
            </div>
            @foreach ($family_members_skills as $index => $family_member_skills)
                <div class="relative p-8 mt-8 space-y-6 border rounded-lg border-zinc-200">
                    <div class="grid gap-6">
                        <div class="flex gap-2">
                            <x-frontend.header-description :message="'Name:'"/>
                            <p>{{ $family_member_skills['name'] }}</p>
                        </div>
                        <div class="grid gap-6 md:grid-cols-2">
                            <div x-data="{ currentSkillText: '' }" 
                                x-init="
                                    if ($wire.family_members_skills[{{ $index }}].code_skill_current_other) {
                                        currentSkillText = 'Other';
                                    }
                                ">
                                <x-frontend.header-description :message="'Skills the Family Members Currently Have'"/>
                                <x-form.select class="!mt-2" wire:model="family_members_skills.{{ $index }}.code_skill_current_id"
                                    @change="
                                        currentSkillText = $event.target.selectedOptions[0].text;
                                        if (currentSkillText !== 'Other') {
                                            $wire.set('family_members_skills.{{ $index }}.code_skill_current_other', null);
                                        }
                                    ">
                                    @foreach ($code_skills as $code_skill)
                                        <option value="{{ $code_skill->id }}">{{ $code_skill->name }}</option>
                                    @endforeach
                                </x-form.select>
                            
                                <div x-show="currentSkillText === 'Other' || $wire.family_members_skills[{{ $index }}].code_skill_current_other" class="mt-2">
                                    <p class="text-sm text-red-500">Please specify the skill</p>
                                    <x-form.input class="!mt-2" 
                                        wire:model="family_members_skills.{{ $index }}.code_skill_current_other" 
                                        x-bind:required="currentSkillText === 'Other'"/>
                                </div>
                            </div>
                            <div>
                                <x-frontend.header-description :message="'Certified (Yes/No)'"/>
                                <x-form.select class="!mt-2" wire:model="family_members_skills.{{ $index }}.certified">
                                    @foreach ($confirmations as $confirmation)
                                        <option value="{{ $confirmation->id }}">{{ $confirmation->name }}</option>
                                    @endforeach
                                </x-form.select>
                            </div>
                        </div>
                        <div class="grid gap-6 md:grid-cols-1">
                            <div x-data="{ desiredSkillText: '' }" 
                                x-init="
                                    if ($wire.family_members_skills[{{ $index }}].code_skill_acquire_other) {
                                        desiredSkillText = 'Other';
                                    }
                                ">
                                <x-frontend.header-description :message="'Skills the Family Members are Willing to Acquire'"/>
                                <x-form.select class="!mt-2" wire:model="family_members_skills.{{ $index }}.code_skill_acquire_id"
                                    @change="
                                        desiredSkillText = $event.target.selectedOptions[0].text;
                                        if (desiredSkillText !== 'Other') {
                                            $wire.set('family_members_skills.{{ $index }}.code_skill_acquire_other', null);
                                        }
                                    ">
                                    @foreach ($code_skills as $code_skill)
                                        <option value="{{ $code_skill->id }}">{{ $code_skill->name }}</option>
                                    @endforeach
                                </x-form.select>
                            
                                <div x-show="desiredSkillText === 'Other' || $wire.family_members_skills[{{ $index }}].code_skill_acquire_other" class="mt-2">
                                    <p class="text-sm text-red-500">Please specify the skill</p>
                                    <x-form.input class="!mt-2" 
                                        wire:model="family_members_skills.{{ $index }}.code_skill_acquire_other" 
                                        x-bind:required="desiredSkillText === 'Other'"/>
                                </div>
                            </div>
                            <div>
                                <x-frontend.header-description :message="'Remarks'"/>
                                <x-form.input class="!mt-2" wire:model="family_members_skills.{{ $index }}.remarks"/>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    
        <div class="flex flex-wrap justify-between gap-4 mt-8">
            <a wire:navigate href="{{ route('environmental-impacts') }}">
                <x-form.button class="max-w-40 w-full px-16 !bg-transparent !text-neutral-800 border border-gray-300">
                    Back
                </x-form.button>
            </a>
            <div>
                <x-form.button class="max-w-40 !bg-sky-600">
                    Submit Form
                </x-form.button>
            </div>
        </div>
    </form>

    <div class="flex justify-center mt-16">
        <x-form.progress-indicator :start="1" :end="10" :current="10" />
    </div>

    <div x-data="{ modalOpen: $wire.entangle('modalOpen') }"
        @keydown.escape.window="modalOpen = false"
        class="">
        <template x-teleport="body">
            <div x-show="modalOpen" class="fixed top-0 left-0 z-[99] flex items-center justify-center w-screen h-dvh px-5" x-cloak>
                <div x-show="modalOpen" 
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-300"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    @click="modalOpen=false" class="absolute inset-0 w-full h-full bg-black/40"></div>
                <div x-show="modalOpen"
                    x-trap.inert.noscroll="modalOpen"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    <div class="relative w-full max-w-2xl py-6 px-7 bg-white sm:rounded-lg overflow-auto h-[calc(100vh-5rem)]">
                        <div class="flex items-center justify-between pb-2">
                        <h3 class="text-lg font-semibold">✅ Success!</h3>
                        <button @click="modalOpen=false" class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 mt-5 mr-5 text-gray-600 rounded-full hover:text-gray-800 hover:bg-gray-50">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>  
                        </button>
                    </div>
                    <div class="relative w-auto pt-4 space-y-4">
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-200 rounded-lg shadow-md">
                                <thead class="text-white bg-sky-600">
                                    <tr>
                                        <th class="px-4 py-2 text-left">Family Members</th>
                                        <th class="px-4 py-2 text-left">ID</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-4 py-2 font-semibold">{{ $user->name }}</td>
                                        <td class="px-4 py-2 font-semibold text-sky-600">{{ $user->uuid }}</td>
                                    </tr>
                                    @foreach ($user_family_members as $family_member)
                                        <tr>
                                            <td class="px-4 py-2 text-nowrap">{{ $family_member->name }}</td>
                                            <td class="px-4 py-2 font-semibold text-sky-600">{{ $family_member->uuid }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>  
                    <div x-data="{ 
                        ctx: null, 
                        drawing: false, 
                        resizeCanvas() { 
                            if (!this.$refs.canvas) return; 
                            this.$refs.canvas.width = this.$refs.container.clientWidth - 20; 
                            this.$refs.canvas.height = 200; 
                            this.ctx = this.$refs.canvas.getContext('2d');
                        },
                        saveSignature() {
                            let signatureData = this.$refs.canvas.toDataURL('image/png');
                            @this.set('signatureData', signatureData);
                            @this.call('saveSignature');
                        }
                        }"
                        x-init="
                        $nextTick(() => {
                            resizeCanvas();
                            window.addEventListener('resize', () => { 
                                resizeCanvas(); 
                                ctx.clearRect(0, 0, $refs.canvas.width, $refs.canvas.height);
                            });
                    
                            // Helper function to get coordinates based on event type
                            function getCoordinates(e) {
                                if (e.type.startsWith('mouse')) {
                                    return { x: e.offsetX, y: e.offsetY };
                                } else if (e.type.startsWith('touch')) {
                                    const rect = $refs.canvas.getBoundingClientRect();
                                    return {
                                        x: e.touches[0].clientX - rect.left,
                                        y: e.touches[0].clientY - rect.top
                                    };
                                }
                            }
                    
                            // Start drawing (mousedown or touchstart)
                            function startDrawing(e) {
                                if (e.type.startsWith('touch')) {
                                    e.preventDefault(); // Prevent scrolling on touch devices
                                }
                                drawing = true;
                                const { x, y } = getCoordinates(e);
                                ctx.beginPath();
                                ctx.moveTo(x, y);
                            }
                    
                            // Draw while moving (mousemove or touchmove)
                            function draw(e) {
                                if (e.type.startsWith('touch')) {
                                    e.preventDefault(); // Prevent scrolling on touch devices
                                }
                                if (!drawing) return;
                                const { x, y } = getCoordinates(e);
                                ctx.lineTo(x, y);
                                ctx.stroke();
                            }
                    
                            // Stop drawing (mouseup, mouseleave, or touchend)
                            function stopDrawing() {
                                drawing = false;
                            }
                    
                            // Mouse event listeners
                            $refs.canvas.addEventListener('mousedown', startDrawing);
                            $refs.canvas.addEventListener('mousemove', draw);
                            $refs.canvas.addEventListener('mouseup', stopDrawing);
                            $refs.canvas.addEventListener('mouseleave', stopDrawing);
                    
                            // Touch event listeners
                            $refs.canvas.addEventListener('touchstart', startDrawing);
                            $refs.canvas.addEventListener('touchmove', draw);
                            $refs.canvas.addEventListener('touchend', stopDrawing);
                        });
                    
                        $watch('modalOpen', (value) => {
                            if (value) {
                                setTimeout(() => {
                                    resizeCanvas();
                                }, 50);
                            }
                        });
                    "
                        class="flex flex-col items-center justify-center w-full p-5 mt-8 text-center bg-gray-50">

                            <p class="mb-2 text-lg font-semibold">Respondent Signature</p>

                            @if (file_exists(public_path("img/signature/$user->uuid.png")))
                                <img src="{{ asset("img/signature/$user->uuid.png") }}?{{ now()->timestamp }}" alt="Signature">
                            @endif
                                                
                            <div x-ref="container" class="relative w-full max-w-lg p-2" wire:ignore>
                                <canvas x-ref="canvas" width="492" class="border border-black rounded-md shadow-md"></canvas>
                            </div>
                        
                            <div class="flex mt-2 space-x-4">
                                <x-form.button @click="ctx.clearRect(0, 0, $refs.canvas.width, $refs.canvas.height)"
                                        class="max-w-40 !bg-transparent !text-neutral-800 border border-gray-300">
                                    Clear
                                </x-form.button>
                                <x-form.button @click="saveSignature()" 
                                        class="">
                                    Save
                                </x-form.button>
                            </div>
                        </div>

                        <form wire:submit="doneForm" wire:confirm="Are you sure you're done with the form?">
                            <div class="flex flex-col items-center justify-center w-full p-5 mt-8 text-center bg-gray-50">
                                <p class="mb-2 text-lg font-semibold">Interviewer Information</p>
                                <x-form.select class="" wire:model.live="interviewer_id" wire:key="{{ $interviewer_id }}" required>
                                    @foreach ($interviewers as $interviewer)
                                        <option value="{{ $interviewer->id }}">{{ $interviewer->name }}</option>
                                    @endforeach
                                </x-form.select>
                                
                                @if ($interviewer_id)
                                    @php
                                        $interviewer = App\Models\Interviewer::find($interviewer_id);
                                        $signaturePath = $interviewer ? "img/interviewer_signature/{$interviewer->uuid}.webp" : null;
                                    @endphp
                                
                                    @if ($signaturePath && file_exists(public_path($signaturePath)))
                                        <img class="mt-8 max-w-48" src="{{ asset($signaturePath) }}?{{ now()->timestamp }}" alt="Signature">
                                    @endif
                                @endif
                            </div>
                        
                            <div class="mt-8 text-center">
                                <x-form.button class="max-w-40 !bg-sky-600">
                                    Submit
                                </x-form.button>
                            </div>     
                        </form>
                    </div>
            </div>
        </template>
    </div>
</div>