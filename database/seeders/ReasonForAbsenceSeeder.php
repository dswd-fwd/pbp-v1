<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ReasonForAbsence;

class ReasonForAbsenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ReasonForAbsence::updateOrCreate(   
            ['name' => 'None'],
            ['name' => 'None'],
        );
        ReasonForAbsence::updateOrCreate(   
            ['name' => 'Schools are very far'],
            ['name' => 'Schools are very far'],
        );
        ReasonForAbsence::updateOrCreate(   
            ['name' => 'No school within the brgy'],
            ['name' => 'No school within the brgy'],
        );
        ReasonForAbsence::updateOrCreate(   
            ['name' => 'No regular transportation'],
            ['name' => 'No regular transportation'],
        );
        ReasonForAbsence::updateOrCreate(   
            ['name' => 'High cost of education'],
            ['name' => 'High cost of education'],
        );
        ReasonForAbsence::updateOrCreate(   
            ['name' => 'Illness/Disability'],
            ['name' => 'Illness/Disability'],
        );
        ReasonForAbsence::updateOrCreate(   
            ['name' => 'Housekeeping/Taking care of siblings'],
            ['name' => 'Housekeeping/Taking care of siblings'],
        );
        ReasonForAbsence::updateOrCreate(   
            ['name' => 'Marriage/Union'],
            ['name' => 'Marriage/Union'],
        );
        ReasonForAbsence::updateOrCreate(   
            ['name' => 'Employment/looking for work'],
            ['name' => 'Employment/looking for work'],
        );
        ReasonForAbsence::updateOrCreate(   
            ['name' => 'Lack of personal interest'],
            ['name' => 'Lack of personal interest'],
        );
        ReasonForAbsence::updateOrCreate(   
            ['name' => 'Cannot cope with school work'],
            ['name' => 'Cannot cope with school work'],
        );
        ReasonForAbsence::updateOrCreate(   
            ['name' => 'Problem with school records'],
            ['name' => 'Problem with school records'],
        );
        ReasonForAbsence::updateOrCreate(   
            ['name' => 'Problem with birth certificate'],
            ['name' => 'Problem with birth certificate'],
        );
        ReasonForAbsence::updateOrCreate(   
            ['name' => 'Cultural belief or customary practice'],
            ['name' => 'Cultural belief or customary practice'],
        );
        ReasonForAbsence::updateOrCreate(   
            ['name' => 'Old age'],
            ['name' => 'Old age'],
        );
        ReasonForAbsence::updateOrCreate(   
            ['name' => 'Other'],
            ['name' => 'Other'],
        );
    }
}
