<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Hidehalo\Nanoid\Client;
use Illuminate\Support\Facades\Hash;
use App\Models\{Religion, CivilStatus, IPMembership, Disability, HEA, Occupation, OccupationClass, CriticalIllness, Confirmation, ExtensionName, FamilyMember, User};

new
#[Layout('components.layouts.frontend-app')]
class extends Component {

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
    public $family_members;

    // models
    public $pantawid_member = '';
    public $slp_beneficiary = '';
    public $household_id_no = '';
    public $first_name = '';
    public $middle_name = '';
    public $last_name = '';
    public $extension_id = '';
    public $region_id = '';
    public $province_id = '';
    public $municipality_id = '';
    public $barangay_id = '';
    public $contact_no = '';
    public $civil_status_id = '';
    public $religion_id = '';
    public $religion_other = '';
    public $i_p_membership_id = '';
    public $i_p_membership_other = '';
    public $hf_id = '';
    public $birth = '';
    public $sex = '';
    public $hea_id = '';
    public $fm_id = '';
    public $occupation_id = '';
    public $occupation_other = '';
    public $occupation_class_id = '';
    public $disability_id = '';
    public $disability_other = '';
    public $critical_illness_id = '';
    public $critical_illness_other = '';

    public function mount()
    {
        if (Auth::check()) {
            $user = Auth::user();
            // Populate form fields with existing data
            $this->pantawid_member = $user->pantawid_member;
            $this->slp_beneficiary = $user->slp_beneficiary;
            $this->household_id_no = $user->household_id_number;
            $this->first_name = $user->first_name;
            $this->middle_name = $user->middle_name;
            $this->last_name = $user->last_name;
            $this->extension_id = $user->extension_name_id ?: '';
            $this->region_id = $user->refregion_id;
            $this->province_id = $user->refprovince_id;
            $this->municipality_id = $user->refcitymun_id;
            $this->barangay_id = $user->refbrgy_id;
            $this->contact_no = $user->contact_number;
            $this->civil_status_id = $user->civil_status_id;
            $this->religion_id = $user->religion_id;
            $this->religion_other = $user->religion_other;
            $this->i_p_membership_id = $user->i_p_membership_id;
            $this->i_p_membership_other = $user->i_p_membership_other;
            $this->hf_id = $user->head_of_the_family;
            $this->birth = $user->birth;
            $this->sex = $user->sex;
            $this->hea_id = $user->h_e_a_id;
            $this->fm_id = $user->family_member_id;
            $this->occupation_id = $user->occupation_id ?: '';
            $this->occupation_other = $user->occupation_other;
            $this->occupation_class_id = $user->occupation_class_id ?: '';
            $this->disability_id = $user->disability_id;
            $this->disability_other = $user->disability_other;
            $this->critical_illness_id = $user->critical_illness_id;
            $this->critical_illness_other = $user->critical_illness_other;
        }

        // Fetch dropdown options
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
        $this->family_members = FamilyMember::get();
    }


    public function submitRespondentProfile()
    {
        if (Auth::check()) {
            // Use the authenticated user
            $user = Auth::user();

            // Update existing user data
            $user->update($this->getUserData());
        } else {
            // Generate a unique UUID in format 'MM-DDYYYY-4RANDOM'
            do {
                $uuid = now()->format('m-dY') . '-' . rand(1000, 9999);
            } while (User::where('uuid', $uuid)->exists()); // Ensure uniqueness

            // Create new user with generated UUID
            $user = User::create(
                array_merge([
                    'uuid' => $uuid,
                    'password' => Hash::make('password'),  // Default password for new user
                    'role' => 'member',  // Default role
                ], $this->getUserData())  // Merge other user data
            );

            // Log in the newly created user
            Auth::login($user);
        }

        // Redirect to family profile page
        $this->redirect(route('family-profile'), navigate: true);
    }

    /**
     * Prepare user data excluding password.
     */
    private function getUserData()
    {
        return [
            'pantawid_member' => $this->pantawid_member,
            'slp_beneficiary' => $this->slp_beneficiary,
            'household_id_number' => $this->household_id_no,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'name' => trim("{$this->first_name} {$this->middle_name} {$this->last_name}" . 
                ($this->extension_id && ($ext = $this->extension_names->firstWhere('id', $this->extension_id)?->name) && strtoupper($ext) !== 'N/A' 
                    ? " {$ext}" 
                    : ''
                )
            ),
            'extension_name_id' => $this->extension_id ? (int) $this->extension_id : null,
            'refregion_id' => (int) $this->region_id,
            'refprovince_id' => (int) $this->province_id,
            'refcitymun_id' => (int) $this->municipality_id,
            'refbrgy_id' => (int) $this->barangay_id,
            'contact_number' => $this->contact_no,
            'civil_status_id' => (int) $this->civil_status_id,
            'religion_id' => (int) $this->religion_id,
            'religion_other' => $this->religion_other,
            'i_p_membership_id' => (int) $this->i_p_membership_id,
            'i_p_membership_other' => $this->i_p_membership_other,
            'head_of_the_family' => (int) $this->hf_id,
            'birth' => $this->birth,
            'sex' => $this->sex,
            'h_e_a_id' => (int) $this->hea_id,
            'family_member_id' => (int) $this->fm_id,
            'occupation_id' => $this->occupation_id ? (int) $this->occupation_id : null,
            'occupation_other' => $this->occupation_other,
            'occupation_class_id' => $this->occupation_class_id ? (int) $this->occupation_class_id : null,
            'disability_id' => (int) $this->disability_id,
            'disability_other' => $this->disability_other,
            'critical_illness_id' => (int) $this->critical_illness_id,
            'critical_illness_other' => $this->critical_illness_other,
        ];
    }
}; ?>

<div class="w-full p-10 m-auto overflow-hidden bg-white border max-w-7xl border-zinc-200 text-zinc-800 rounded-xl">
    
    <div class="relative">
        <img src={{ asset('img/PBP.png') }} alt="" class="max-w-24">
        <h1 class="absolute text-lg font-semibold text-center transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 md:text-xl">
            Family Profiling Tool
        </h1>
    </div>

    <form wire:submit="submitRespondentProfile">
        <div class="mt-8 space-y-4">
            <div class="grid gap-6 md:grid-cols-3">
                <p>
                    <x-frontend.header-description :message="'Date of Interview: '"/>
                    <x-frontend.description :message="date('m-d-Y')" />
                </p>
            </div>
            <p>
                <x-frontend.header-description :message="'Salutation: '"/>
                <x-frontend.description :message="'Magandang umaga/hapon po! Ako po ay isang researcher/mananaliksik. Kami po ay gumagawa ng isang survey tungkol sa mga serbisyong na-access o na-avail nyo mula sa anumang ahensya ng gobyerno. Ang inyo pong opinion ay lubos na makakatulong sa pagrerekomenda para sa pagpapahusay ng aming mga mga serbisyo. Wala pong tama o maling sagot sa survey na ito at ang inyong mga opinyon lamang ang mahalaga sa amin. Amin pong sinisiguro na lahat ng impormasyong inyong sasabihin ay magiging strictly confidential at ang inyong mga personal na detalye, tulad ng pangalan at tirahan, ay hindi mailalathala sa aming pag-aaral at report.'"/>
            </p>
            <div class="grid gap-6 mt-8 md:grid-cols-3">
                <div>
                    <x-frontend.header-description :message="'Pantawid Member: '"/>
                    <x-form.required />
                    <x-form.select class="!mt-2" wire:model="pantawid_member" required>
                        @foreach ($confirmations as $confirmation)
                            <option value="{{ $confirmation->id }}">{{ $confirmation->name }}</option>
                        @endforeach
                    </x-form.select>
                </div>
                <div>
                    <x-frontend.header-description :message="'SLP Beneficiary: '"/>
                    <x-form.required />
                    <x-form.select class="!mt-2" wire:model="slp_beneficiary" required>
                        @foreach ($confirmations as $confirmation)
                            <option value="{{ $confirmation->id }}">{{ $confirmation->name }}</option>
                        @endforeach
                    </x-form.select>
                </div>
                <div>
                    <x-frontend.header-description :message="'Household ID No.: '"/>
                    <x-form.sm-text :message="'(optional)'" />
                    <x-form.input class="!mt-2 w-full" wire:model="household_id_no"/>
                </div>
            </div>
        </div>
        <div class="mt-16 mb-8">
            <x-frontend.header :message="'Respondent\'s Profile'"/>
        </div>

        <div class="p-8 mt-8 space-y-6 border rounded-lg border-zinc-200">
            <div class="grid gap-6 xl:grid-cols-4">
                <div>
                    <x-frontend.header-description :message="'First Name: '"/>
                    <x-form.required />
                    <x-form.input class="!mt-2" wire:model="first_name" required/>
                </div>
                <div>
                    <x-frontend.header-description :message="'Middle Name: '"/>
                    <x-form.required />
                    <x-form.input class="!mt-2" wire:model="middle_name" required/>
                </div>
                <div>
                    <x-frontend.header-description :message="'Last Name: '"/>
                    <x-form.required />
                    <x-form.input class="!mt-2" wire:model="last_name" required/>
                </div>
                <div> 
                    <x-frontend.header-description :message="'Extension Name: '"/>
                    <x-form.sm-text :message="'(optional)'" />
                    <x-form.select class="!mt-2" wire:model="extension_id">
                        @foreach ($extension_names as $extension_name)
                            <option value="{{ $extension_name->id }}">{{ $extension_name->name }}</option>
                        @endforeach
                    </x-form.select>
                </div>
            </div>
            <div class="grid gap-6 xl:grid-cols-4">
                <div>
                    <x-frontend.header-description :message="'Select Region: '"/>
                    <x-form.required />
                    <x-form.select class="!mt-2" wire:model.live="region_id" required>
                        @foreach (App\Models\Region::all() as $region)
                            <option value="{{ $region->id }}">{{ $region->regDesc }}</option>
                        @endforeach
                    </x-form.select>
                </div>
                <div>
                    <x-frontend.header-description :message="'Select Province: '"/>
                    <x-form.required />
                    <x-form.select class="!mt-2" wire:model.live="province_id" wire:key="{{ $region_id }}" required>
                        @foreach (App\Models\Region::find($region_id)?->provinces ?? [] as $province)
                            <option value="{{ $province->id }}">{{ $province->provDesc }}</option>
                        @endforeach
                    </x-form.select>
                </div>
                <div>
                    <x-frontend.header-description :message="'Select City/Municipality: '"/>
                    <x-form.required />
                    <x-form.select class="!mt-2" wire:model.live="municipality_id" wire:key="{{ $province_id }}" required>
                        @foreach (App\Models\Province::find($province_id)?->municipalities ?? [] as $municipality)
                            <option value="{{ $municipality->id }}">{{ $municipality->citymunDesc }}</option>
                        @endforeach
                    </x-form.select>
                </div>
                <div>
                    <x-frontend.header-description :message="'Select Barangay: '"/>
                    <x-form.required />
                    <x-form.select class="!mt-2" wire:model="barangay_id" required>
                        @foreach (App\Models\Municipality::find($municipality_id)?->barangay ?? [] as $barangay)
                            <option value="{{ $barangay->id }}">{{ $barangay->brgyDesc }}</option>
                        @endforeach
                    </x-form.select>
                </div>
            </div>        
            <div class="grid gap-6 md:grid-cols-3">
                <div>
                    <x-frontend.header-description :message="'Contact Number: '"/>
                    <x-form.required />
                    <x-form.input class="!mt-2" wire:model="contact_no" required />
                </div>
                <div>
                    <x-frontend.header-description :message="'Civil Status: '"/>
                    <x-form.required />
                    <x-form.select class="!mt-2" wire:model="civil_status_id" required>
                        @foreach ($civil_statuses as $civil_status)
                            <option value="{{ $civil_status->id }}">{{ $civil_status->name }}</option>
                        @endforeach
                    </x-form.select>
                </div>
                <div x-data="{ selectedReligionText: '' }"
                    x-init="
                        if ($wire.religion_other) {
                            selectedReligionText = 'Other';
                        }
                    "
                >
                    <x-frontend.header-description :message="'Religion: '"/>
                    <x-form.required />
                
                    <x-form.select class="!mt-2" wire:model="religion_id"
                        @change="
                            selectedReligionText = $event.target.selectedOptions[0].text;
                            if (selectedReligionText !== 'Other') {
                                $wire.set('religion_other', null); // Reset Livewire variable
                            }
                        " required>
                        @foreach ($religions as $religion)
                            <option value="{{ $religion->id }}">{{ $religion->name }}</option>
                        @endforeach
                    </x-form.select>
                
                    <div x-show="selectedReligionText === 'Other' || (@entangle('religion_other') && $wire.religion_other !== null && $wire.religion_other !== '')" class="mt-2">
                        <p class="text-sm text-red-500">Please specify your religion</p>
                        <x-form.input class="!mt-2" wire:model="religion_other" x-bind:required="selectedReligionText === 'Other'"/>
                    </div>
                </div>
            </div>
            <div class="grid gap-6 md:grid-cols-3">
                <div x-data="{ selectedIpClass: '' }"
                    x-init="
                        if ($wire.i_p_membership_other) {
                            selectedIpClass = 'Other';
                        }
                    "
                >
                    <x-frontend.header-description :message="'IP Membership: '"/>
                    <x-form.required />
                
                    <x-form.select class="!mt-2" wire:model="i_p_membership_id"
                        @change="
                            selectedIpClass = $event.target.selectedOptions[0].text;
                            if (selectedIpClass !== 'Other') {
                                $wire.set('i_p_membership_other', null); // Reset Livewire variable
                            }
                        " required>
                        @foreach ($ip_memberships as $ip_membership)
                            <option value="{{ $ip_membership->id }}">{{ $ip_membership->name }}</option>
                        @endforeach
                    </x-form.select>
                
                    <div x-show="selectedIpClass === 'Other' || (@entangle('i_p_membership_other') && $wire.i_p_membership_other !== null && $wire.i_p_membership_other !== '')" class="mt-2">
                        <p class="text-sm text-red-500">Please specify your IP Classification</p>
                        <x-form.input class="!mt-2" wire:model="i_p_membership_other" x-bind:required="selectedIpClass === 'Other'"/>
                    </div>
                </div>
                
                <div>
                    <x-frontend.header-description :message="'Head of the Family: '"/>
                    <x-form.required />
                    <x-form.select class="!mt-2" wire:model="hf_id" required>
                        @foreach ($confirmations as $confirmation)
                            <option value="{{ $confirmation->id }}">{{ $confirmation->name }}</option>
                        @endforeach
                    </x-form.select>
                </div>
                <div>
                    <x-frontend.header-description :message="'Date of Birth: '"/>
                    <x-form.required />
                    <x-form.input class="!mt-2" wire:model="birth" type="date" required/>  
                </div>
            </div>
            <div class="grid gap-6 md:grid-cols-3">
                <div>
                    <x-frontend.header-description :message="'Sex: '"/>
                    <x-form.required />
                    <x-form.select class="!mt-2" wire:model="sex" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </x-form.select>
                </div>
                <div>
                    <x-frontend.header-description :message="'Highest Educational Attainment: '"/>
                    <x-form.required />
                    <x-form.select class="!mt-2" wire:model="hea_id" required>
                        @foreach ($heas as $hea)
                            <option value="{{ $hea->id }}">{{ $hea->name }}</option>
                        @endforeach
                    </x-form.select>
                </div>
                <div>
                    <x-frontend.header-description :message="'Number of Family Members: '"/>
                    <x-form.required />
                    <x-form.select class="!mt-2" wire:model="fm_id" required>
                        @foreach ($family_members as $family_member)
                            <option value="{{ $family_member->id }}">{{ $family_member->name }}</option>
                        @endforeach
                    </x-form.select>
                </div>
            </div>
            <div class="grid gap-6 md:grid-cols-2">
                <div x-data="{ occupationText: '' }">
                    <x-frontend.header-description :message="'Occupation: '"/>
                    <x-form.sm-text :message="'(optional)'" />
                    <x-form.select class="!mt-2" wire:model="occupation_id"
                        @change="
                            occupationText = $event.target.selectedOptions[0].text;
                            if (occupationText !== 'Other') {
                                $wire.set('occupation_other', null); // Reset Livewire variable
                            }
                        ">
                        @foreach ($occupations as $occupation)
                            <option value="{{ $occupation->id }}">{{ $occupation->name }}</option>
                        @endforeach
                    </x-form.select>
                
                    <div x-show="occupationText === 'Other' || (@entangle('occupation_other') && $wire.occupation_other !== null && $wire.occupation_other !== '')" class="mt-2">
                        <p class="text-sm text-red-500">Please specify your occupation</p>
                        <x-form.input class="!mt-2" wire:model="occupation_other" x-bind:required="occupationText === 'Other'"/>
                    </div>
                </div>
                <div>
                    <x-frontend.header-description :message="'Occupation Class: '"/>
                    <x-form.sm-text :message="'(optional)'" />
                    <x-form.select class="!mt-2" wire:model="occupation_class_id">
                        @foreach ($occupations_classes as $occupation_class)
                            <option value="{{ $occupation_class->id }}">{{ $occupation_class->name }}</option>
                        @endforeach
                    </x-form.select>
                </div>
            </div>
            <div class="grid gap-6 md:grid-cols-2">
                <div x-data="{ disabilityText: '' }"
                    x-init="
                        if ($wire.disability_other) {
                            disabilityText = 'Other';
                        }
                    "
                >
                    <x-frontend.header-description :message="'Disability/ Special Needs: '"/>
                    <x-form.required />
                
                    <x-form.select class="!mt-2" wire:model="disability_id"
                        @change="
                            disabilityText = $event.target.selectedOptions[0].text;
                            if (disabilityText !== 'Other') {
                                $wire.set('disability_other', null); // Reset Livewire variable
                            }
                        " required>
                        @foreach ($disabilities as $disability)
                            <option value="{{ $disability->id }}">{{ $disability->name }}</option>
                        @endforeach
                    </x-form.select>
                
                    <div x-show="disabilityText === 'Other' || (@entangle('disability_other') && $wire.disability_other !== null && $wire.disability_other !== '')" class="mt-2">
                        <p class="text-sm text-red-500">Please specify your disability</p>
                        <x-form.input class="!mt-2" wire:model="disability_other" x-bind:required="disabilityText === 'Other'"/>
                    </div>
                </div>
            
                <div x-data="{ criticalIllnessText: '' }"
                    x-init="
                        if ($wire.critical_illness_other) {
                            criticalIllnessText = 'Other';
                        }
                    "
                >
                    <x-frontend.header-description :message="'Critical Illness: '"/>
                    <x-form.required />
                
                    <x-form.select class="!mt-2" wire:model="critical_illness_id"
                        @change="
                            criticalIllnessText = $event.target.selectedOptions[0].text;
                            if (criticalIllnessText !== 'Other') {
                                $wire.set('critical_illness_other', null); // Reset Livewire variable
                            }
                        " required>
                        @foreach ($critical_illnesses as $critical_illness)
                            <option value="{{ $critical_illness->id }}">{{ $critical_illness->name }}</option>
                        @endforeach
                    </x-form.select>
                
                    <div x-show="criticalIllnessText === 'Other' || (@entangle('critical_illness_other') && $wire.critical_illness_other !== null && $wire.critical_illness_other !== '')" class="mt-2">
                        <p class="text-sm text-red-500">Please specify your critical illness</p>
                        <x-form.input class="!mt-2" wire:model="critical_illness_other" x-bind:required="criticalIllnessText === 'Other'"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-end mt-8">
            <x-form.button>
                Next Page
            </x-form.button>
        </div>

        <div class="flex justify-center mt-16">
            <x-form.progress-indicator :start="1" :end="10" :current="1" />
        </div>
    </form>


    <div 
        x-data="{ fullscreenModal: false }"
        x-init="
            setTimeout(() => fullscreenModal = true, 100);
            $watch('fullscreenModal', value => {
                if (value) {
                    document.body.classList.add('overflow-hidden');
                } else {
                    document.body.classList.remove('overflow-hidden');
                }
            });
        "
        @keydown.escape="fullscreenModal = false"
    >
        <template x-teleport="body">
            <div 
                x-show="fullscreenModal"
                x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="translate-y-full"
                x-transition:enter-end="translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="translate-y-0"
                x-transition:leave-end="translate-y-full"
                class="flex fixed inset-0 z-[99] w-screen h-screen bg-white"
            >
                <button @click="fullscreenModal=false" class="absolute top-0 right-0 z-30 flex items-center justify-center px-3 py-2 mt-3 mr-3 space-x-1 text-xs font-medium uppercase border rounded-md border-neutral-200 lg:border-white/20 lg:bg-black/10 hover:lg:bg-black/30 text-neutral-600 lg:text-white hover:bg-neutral-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    <span>Close</span>
                </button>
                
                <div class="relative flex flex-wrap items-center w-full h-full px-8 overflow-auto">
                    <div class="relative w-full max-w-md mx-auto lg:mb-0">
                        <div class="relative">
                            <img src={{ asset('img/PBP.png') }} alt="" class="mb-4 max-w-24">
                            <div class="flex flex-col mb-6 space-y-2">
                                <h1 class="text-2xl font-semibold tracking-tight">Terms and Conditions</h1>
                                <p class="mb-8 text-base text-neutral-500">
                                    Sa pamamagitan ng pagbibigay ng inyong pahintulot, sumasang-ayon kayong lumahok sa Pamilya sa Bagong Pilipinas Assessment, na naglalayong mangalap ng impormasyon tungkol sa mga serbisyong na-access ng inyong pamilya mula sa mga ahensya ng gobyerno. Ang inyong mga sagot ay makakatulong sa pagpapabuti ng mga serbisyong ito. Ang lahat ng impormasyong ibibigay ay mananatiling mahigpit na kumpidensyal, at ang mga personal na detalye tulad ng pangalan at tirahan ay hindi isasama sa anumang ulat. Ang inyong pakikilahok sa pagtatasa na ito ay boluntaryo, at maaari kayong tumanggi na sagutin ang anumang tanong o itigil ang pagsagot anumang oras nang walang anumang magiging epekto. Sa pamamagitan ng pag-click sa pindutan ng pahintulot o pagpirma sa ibaba, pinatutunayan ninyo na inyong nauunawaan ang layunin ng pagtatasa na ito at sumasang-ayon kayong lumahok.
                                </p>
                                <x-form.button @click="fullscreenModal=false" >
                                    I Agree
                                </x-form.button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative top-0 bottom-0 right-0 flex-shrink-0 hidden w-1/3 overflow-hidden bg-cover lg:block">
                    <div class="absolute inset-0 z-20 w-full h-full opacity-70 bg-gradient-to-t from-black"></div>
                    <img src="{{ asset('img/asian-mother.webp') }}" class="z-10 object-cover w-full h-full" />
                </div>
            </div>
        </template>
    </div>


</div>
