<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Hidehalo\Nanoid\Client;
use App\Models\{Religion, CivilStatus, IPMembership, Disability, HEA, Occupation, OccupationClass, CriticalIllness, Confirmation, ExtensionName, FamilyMember, RelationshipToFamily, User, FamilyProfile};

new
#[Layout('components.layouts.frontend-app')]
class extends Component {

    public $user;
    public $family_members = [];

    public $religions;
    public $civil_statuses;
    public $ip_memberships;
    public $disabilities;
    public $heas;
    public $occupations;
    public $occupations_classes;
    public $critical_illnesses;
    public $confirmations;
    public $extension_names;
    public $relationship_to_families;

    public function mount()
    {
        if (!auth()->check()) {
            $this->redirect(route('respondent-profile'), navigate: true);
        }
        
        if (Auth::check()) {
            $this->user = Auth::user();

            // Fetch the user's family members using the relationship
            $this->family_members = $this->user->familyMembers()
                ->get()
                ->map(function ($member) {
                    return [
                        'uuid' => $member->uuid,
                        'first_name' => $member->first_name,
                        'middle_name' => $member->middle_name,
                        'last_name' => $member->last_name,
                        'extension_id' => $member->extension_name_id ?: '',
                        'sex' => $member->sex,
                        'civil_status_id' => $member->civil_status_id,
                        'birth' => $member->birth,
                        'relationship_to_the_head_id' => $member->relationship_to_family_id,
                        'relationship_to_the_head_other' => $member->relationship_to_family_other,
                        'occupation_id' => $member->occupation_id ?: '',
                        'occupation_other' => $member->occupation_other,
                        'occupation_class_id' => $member->occupation_class_id ?: '',
                        'disability_id' => $member->disability_id,
                        'disability_other' => $member->disability_other,
                        'critical_illness_id' => $member->critical_illness_id,
                        'critical_illness_other' => $member->critical_illness_other,
                        'solo_parent_id' => $member->solo_parent,
                    ];
                })->toArray();

            // If no family members exist, add a default one
            if (empty($this->family_members)) {
                $this->addFamilyMember();
            }
        }

        $this->religions = Religion::get();
        $this->civil_statuses = CivilStatus::get();
        $this->ip_memberships = IPMembership::get();
        $this->disabilities = Disability::get();
        $this->heas = HEA::get();
        $this->occupations = Occupation::get();
        $this->occupations_classes = OccupationClass::get();
        $this->critical_illnesses = CriticalIllness::get();
        $this->confirmations = Confirmation::get();
        $this->extension_names = ExtensionName::get();
        $this->relationship_to_families = RelationshipToFamily::get();
    }


        public function addFamilyMember()
        {
            $this->family_members[] = [
                'first_name' => '',
                'middle_name' => '',
                'last_name' => '',
                'extension_id' => '',
                'sex' => '',
                'civil_status_id' => '',
                'birth' => '',
                'relationship_to_the_head_id' => '',
                'relationship_to_the_head_other' => '',
                'occupation_id' => '',
                'occupation_other' => '',
                'occupation_class_id' => '',
                'disability_id' => '',
                'disability_other' => '',
                'critical_illness_id' => '',
                'critical_illness_other' => '',
                'solo_parent_id' => '',
            ];
        }

        public function removeFamilyMember($index)
        {
            if ($index > 0) {
                unset($this->family_members[$index]);
                $this->family_members = array_values($this->family_members);
            }
        }

        public function submitFamilyMember()
        {
            $user = $this->user;
            $client = new Client();

            // Get all existing family member UUIDs for this user
            $existingFamilyMembers = FamilyProfile::where('user_id', $user->id)->pluck('uuid')->toArray();
            
            $incomingFamilyMemberUUIDs = [];

            foreach ($this->family_members as $member) {
                // Ensure a uuid exists using your custom UUID generator
                if (!isset($member['uuid']) || empty($member['uuid'])) {
                    // Get Respondent's UUID prefix (user's UUID)
                    $respondentUuid = $user->uuid; // Example: 03-24-2025-3887

                    // Count existing family members for this user and increment by 1 for the new one
                    $count = FamilyProfile::where('user_id', $user->id)->count() + 1;

                    // Ensure the count is always 2 digits
                    $countFormatted = str_pad($count, 2, '0', STR_PAD_LEFT);

                    // Generate Family Member UUID (correct format)
                    // Just append the formatted count after the user's UUID
                    $member['uuid'] = "{$respondentUuid}-{$countFormatted}";
                }

                // Store UUID to track which ones are still valid
                $incomingFamilyMemberUUIDs[] = $member['uuid'];

                // Store or update family member record
                FamilyProfile::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'uuid' => $member['uuid'], // Unique identifier
                    ],
                    [
                        'first_name' => $member['first_name'],
                        'middle_name' => $member['middle_name'],
                        'last_name' => $member['last_name'],
                        'name' => trim("{$member['first_name']} " . 
                            (!empty($member['middle_name']) ? strtoupper(substr($member['middle_name'], 0, 1)) . '. ' : '') . // Middle initial with dot
                            "{$member['last_name']}" . 
                            ($member['extension_id'] && ($ext = $this->extension_names->firstWhere('id', $member['extension_id'])?->name) && strtoupper($ext) !== 'N/A' 
                                ? " {$ext}" 
                                : ''
                            )
                        ),
                        // 'name' => trim("{$member['first_name']} {$member['middle_name']} {$member['last_name']}" . 
                        //     ($member['extension_id'] && ($ext = $this->extension_names->firstWhere('id', $member['extension_id'])?->name) && strtoupper($ext) !== 'N/A' 
                        //         ? " {$ext}" 
                        //         : ''
                        //     )
                        // ),
                        'extension_name_id' => !empty($member['extension_id']) ? $member['extension_id'] : null,
                        'sex' => $member['sex'],
                        'civil_status_id' => $member['civil_status_id'],
                        'birth' => $member['birth'],
                        'relationship_to_family_id' => $member['relationship_to_the_head_id'],
                        'relationship_to_family_other' => $member['relationship_to_the_head_other'],
                        'occupation_id' => !empty($member['occupation_id']) ? $member['occupation_id'] : null,
                        'occupation_other' => $member['occupation_other'],
                        'occupation_class_id' => !empty($member['occupation_class_id']) ? $member['occupation_class_id'] : null,
                        'disability_id' => !empty($member['disability_id']) ? $member['disability_id'] : null,
                        'disability_other' => $member['disability_other'],
                        'critical_illness_id' => !empty($member['critical_illness_id']) ? $member['critical_illness_id'] : null,
                        'critical_illness_other' => $member['critical_illness_other'],
                        'solo_parent' => $member['solo_parent_id'],
                    ]
                );

                // Generate QR code for family member
                $fileName = "{$member['uuid']}.png";
                $path = public_path("img/qr_code/{$fileName}");

                // Ensure directory exists
                if (!file_exists(public_path('img/qr_code'))) {
                    mkdir(public_path('img/qr_code'), 0777, true);
                }

                // Generate and save QR code
                file_put_contents($path, QrCode::format('png')->size(250)->errorCorrection('H')->generate($member['uuid']));
            }

            // Find and delete family members that were removed
            $deletedMembers = FamilyProfile::where('user_id', $user->id)
                ->whereNotIn('uuid', $incomingFamilyMemberUUIDs)
                ->get();

            foreach ($deletedMembers as $deletedMember) {
                $fileName = "{$deletedMember->uuid}.png";
                $path = public_path("img/qr_code/{$fileName}");

                // Delete QR code if it exists
                if (file_exists($path)) {
                    unlink($path);
                }

                // Delete family member record
                $deletedMember->delete();
            }

            // Redirect to the next page
            $this->redirect(route('housing-water-sanitation'), navigate: true);
        }
}; ?>

<div class="w-full p-10 m-auto overflow-hidden bg-white border max-w-7xl border-zinc-200 text-zinc-800 rounded-xl">
    <div class="relative">
        <img src={{ asset('img/PBP.png') }} alt="" class="max-w-24">
        <h1 class="absolute text-lg font-semibold text-center transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 md:text-xl">
            Family Profile
        </h1>
    </div>
    <div class="mt-8 space-y-4">
        <p>
            <x-frontend.description :message="'Sinu-sino ang mga miyembro ng inyong pamilya? Ang miyembro ng pamilya ay ang mga indibidwal na kaugnay sa dugo, sa bisa ng kasal o sa pamamagitan ng pag-aampon, o paninirahan sa isang tahanan. Kabilang din ang mga miyembro na hindi kadalasan naninirahan sa tahanan ngunit ang sweldo o gastusin ay kabilang sa buong kita o gastos ng pamilya, halimbawa, anak na nag-aaral sa ibang lugar pero ang allowance ay galing sa magulang, miyembro ng pamilya na OFW o nagtatrabaho sa ibang lugar na nagpapadala ng sustento. Ang mga kasama sa tirahan na hindi kaugnay sa pamilya ay hindi kabilang.'"/>
        </p>
    </div>
    <form wire:submit="submitFamilyMember">
        @foreach ($family_members as $index => $family_member)
        <div class="relative p-8 mt-8 space-y-6 border rounded-lg border-zinc-200">
            <div class="flex items-center justify-between">
                <x-frontend.header-description class="!text-sky-600" :message="'Family Member ' . ($index + 1)"/>
                @if($index > 0) 
                    <button type="button" wire:click="removeFamilyMember({{ $index }})" class="cursor-pointer hover:opacity-70">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-red-600 size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                        </svg>
                    </button>
                @endif
            </div>
            
            <div class="!mt-6 grid gap-6 xl:grid-cols-3">
                <div>
                    <x-frontend.header-description :message="'First Name:'"/>
                    <x-form.required />
                    <x-form.input class="!mt-2" wire:model="family_members.{{ $index }}.first_name" required/>
                </div>
                <div>
                    <x-frontend.header-description :message="'Middle Name:'"/>
                    <x-form.required />
                    <x-form.input class="!mt-2" wire:model="family_members.{{ $index }}.middle_name" required/>
                </div>
                <div>
                    <x-frontend.header-description :message="'Last Name:'"/>
                    <x-form.required />
                    <x-form.input class="!mt-2" wire:model="family_members.{{ $index }}.last_name" required/>
                </div>
            </div>
        
            <div class="grid gap-6 md:grid-cols-3">
                <div>
                    <x-frontend.header-description :message="'Extension Name:'"/>
                    <x-form.sm-text :message="'(optional)'" />
                    <x-form.select class="!mt-2" wire:model="family_members.{{ $index }}.extension_id">
                        @foreach ($extension_names as $extension_name)
                            <option value="{{ $extension_name->id }}">{{ $extension_name->name }}</option>
                        @endforeach
                    </x-form.select>
                </div>
        
                <div>
                    <x-frontend.header-description :message="'Sex:'"/>
                    <x-form.required />
                    <x-form.select class="!mt-2" wire:model="family_members.{{ $index }}.sex" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </x-form.select>
                </div>
            </div>
        
            <div class="grid gap-6 md:grid-cols-3">
                <div>
                    <x-frontend.header-description :message="'Civil Status:'"/>
                    <x-form.required />
                    <x-form.select class="!mt-2" wire:model="family_members.{{ $index }}.civil_status_id" required>
                        @foreach ($civil_statuses as $civil_status)
                            <option value="{{ $civil_status->id }}">{{ $civil_status->name }}</option>
                        @endforeach
                    </x-form.select>
                </div>
                <div>
                    <x-frontend.header-description :message="'Date of Birth:'"/>
                    <x-form.required />
                    <x-form.input class="!mt-2" wire:model="family_members.{{ $index }}.birth" type="date" required/>
                </div>
                <!-- Relationship to the Head of the Family -->
                <div x-data="{ relationshipText: '' }" 
                    x-init="
                        if ($wire.family_members[{{ $index }}].relationship_to_the_head_other) {
                            relationshipText = 'Other';
                        }
                    ">
                    <x-frontend.header-description :message="'Relationship to the Head of the Family:'"/>
                    <x-form.required />
                    <x-form.select class="!mt-2" wire:model="family_members.{{ $index }}.relationship_to_the_head_id" required
                        @change="
                            relationshipText = $event.target.selectedOptions[0].text;
                            if (relationshipText !== 'Other') {
                                $wire.set('family_members.{{ $index }}.relationship_to_the_head_other', null);
                            }
                        ">
                        @foreach ($relationship_to_families as $relationship_to_family)
                            <option value="{{ $relationship_to_family->id }}">{{ $relationship_to_family->name }}</option>
                        @endforeach
                    </x-form.select>

                    <div x-show="relationshipText === 'Other' || $wire.family_members[{{ $index }}].relationship_to_the_head_other" class="mt-2">
                        <p class="text-sm text-red-500">Please specify the relationship</p>
                        <x-form.input class="!mt-2" 
                            wire:model="family_members.{{ $index }}.relationship_to_the_head_other" 
                            x-bind:required="relationshipText === 'Other'"/>
                    </div>
                </div>
            </div>
        
            <div class="grid gap-6 md:grid-cols-3">
                <div x-data="{ occupationText: '' }" 
                    x-init="
                        if ($wire.family_members[{{ $index }}].occupation_other) {
                            occupationText = 'Other';
                        }
                    "
                >
                    <x-frontend.header-description :message="'Occupation:'"/>
                    <x-form.sm-text :message="'(optional)'" />
                    <x-form.select class="!mt-2" wire:model="family_members.{{ $index }}.occupation_id"
                        @change="
                            occupationText = $event.target.selectedOptions[0].text;
                            if (occupationText !== 'Other') {
                                $wire.set('family_members.{{ $index }}.occupation_other', null);
                            }
                        ">
                        @foreach ($occupations as $occupation)
                            <option value="{{ $occupation->id }}">{{ $occupation->name }}</option>
                        @endforeach
                    </x-form.select>
                    <div x-show="occupationText === 'Other' || $wire.family_members[{{ $index }}].occupation_other" class="mt-2">
                        <p class="text-sm text-red-500">Please specify your occupation</p>
                        <x-form.input class="!mt-2" wire:model="family_members.{{ $index }}.occupation_other" x-bind:required="occupationText === 'Other'"/>
                    </div>
                </div>
                
                <div>
                    <x-frontend.header-description :message="'Occupation Class:'"/>
                    <x-form.sm-text :message="'(optional)'" />
                    <x-form.select class="!mt-2" wire:model="family_members.{{ $index }}.occupation_class_id">
                        @foreach ($occupations_classes as $occupation_class)
                            <option value="{{ $occupation_class->id }}">{{ $occupation_class->name }}</option>
                        @endforeach
                    </x-form.select>
                </div>
                <div x-data="{ disabilityText: '' }" 
                    x-init="
                        if ($wire.family_members[{{ $index }}].disability_other) {
                            disabilityText = 'Other';
                        }
                    ">
                    <x-frontend.header-description :message="'Disability/ Special Needs:'"/>
                    <x-form.required />
                
                    <x-form.select class="!mt-2" wire:model="family_members.{{ $index }}.disability_id" required
                        @change="
                            disabilityText = $event.target.selectedOptions[0].text;
                            if (disabilityText !== 'Other') {
                                $wire.set('family_members.{{ $index }}.disability_other', null);
                            }
                        ">
                        @foreach ($disabilities as $disability)
                            <option value="{{ $disability->id }}">{{ $disability->name }}</option>
                        @endforeach
                    </x-form.select>
                
                    <div x-show="disabilityText === 'Other' || $wire.family_members[{{ $index }}].disability_other" class="mt-2">
                        <p class="text-sm text-red-500">Please specify the disability</p>
                        <x-form.input class="!mt-2" 
                            wire:model="family_members.{{ $index }}.disability_other" 
                            x-bind:required="disabilityText === 'Other'"/>
                    </div>
                </div>
            </div>
        
            <div class="grid gap-6 md:grid-cols-2">
                <div x-data="{ criticalIllnessText: '' }" 
                    x-init="
                        if ($wire.family_members[{{ $index }}].critical_illness_other) {
                            criticalIllnessText = 'Other';
                        }
                    ">
                    <x-frontend.header-description :message="'Critical Illness:'"/>
                    <x-form.required />

                    <x-form.select class="!mt-2" wire:model="family_members.{{ $index }}.critical_illness_id" required
                        @change="
                            criticalIllnessText = $event.target.selectedOptions[0].text;
                            if (criticalIllnessText !== 'Other') {
                                $wire.set('family_members.{{ $index }}.critical_illness_other', null);
                            }
                        ">
                        @foreach ($critical_illnesses as $critical_illness)
                            <option value="{{ $critical_illness->id }}">{{ $critical_illness->name }}</option>
                        @endforeach
                    </x-form.select>

                    <div x-show="criticalIllnessText === 'Other' || $wire.family_members[{{ $index }}].critical_illness_other" class="mt-2">
                        <p class="text-sm text-red-500">Please specify the critical illness</p>
                        <x-form.input class="!mt-2" 
                            wire:model="family_members.{{ $index }}.critical_illness_other" 
                            x-bind:required="criticalIllnessText === 'Other'"/>
                    </div>
                </div>

                <div>
                    <x-frontend.header-description :message="'Solo Parent:'"/>
                    <x-form.required />
                    <x-form.select class="!mt-2" wire:model="family_members.{{ $index }}.solo_parent_id">
                        @foreach ($confirmations as $confirmation)
                            <option value="{{ $confirmation->id }}">{{ $confirmation->name }}</option>
                        @endforeach
                    </x-form.select>
                </div>
            </div>
        </div>
        @endforeach

        <div class="flex justify-center gap-4 mt-8">
            <x-form.button class="max-w-60 !bg-sky-600" wire:click="addFamilyMember" type="button">
                Add Family Member
            </x-form.button>
        </div>
        
        <div class="flex justify-end gap-4 mt-8">
            <div class="w-full">
                <a wire:navigate href="{{ route('respondent-profile') }}">
                    <x-form.button class="max-w-40 !bg-transparent !text-neutral-800 border border-gray-300">
                        Back
                    </x-form.button>
                </a>
            </div>
            <x-form.button class="max-w-40">
                Next Page
            </x-form.button>
        </div>
        <div class="flex justify-center mt-16">
            <x-form.progress-indicator :start="1" :end="10" :current="2" />
        </div>
    </form>

</div>