<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HEA;

class HEASeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HEA::updateOrCreate(   
            ['name' => 'Without Formal Education'],
            ['name' => 'Without Formal Education'],
        );
        HEA::updateOrCreate(   
            ['name' => 'Elementary'],
            ['name' => 'Elementary'],
        );
        HEA::updateOrCreate(   
            ['name' => 'Elementary Graduate'],
            ['name' => 'Elementary Graduate'],
        );
        HEA::updateOrCreate(   
            ['name' => 'High School'],
            ['name' => 'High School'],
        );
        HEA::updateOrCreate(   
            ['name' => 'High School Graduate'],
            ['name' => 'High School Graduate'],
        );
        HEA::updateOrCreate(   
            ['name' => 'Senior High School'],
            ['name' => 'Senior High School'],
        );
        HEA::updateOrCreate(   
            ['name' => 'Vocational Course'],
            ['name' => 'Vocational Course'],
        );
        HEA::updateOrCreate(   
            ['name' => 'Voc. Course Graduate'],
            ['name' => 'Voc. Course Graduate'],
        );
        HEA::updateOrCreate(   
            ['name' => 'College'],
            ['name' => 'College'],
        );
        HEA::updateOrCreate(   
            ['name' => 'College Graduate'],
            ['name' => 'College Graduate'],
        );
        HEA::updateOrCreate(   
            ['name' => 'Post College Degree'],
            ['name' => 'Post College Degree'],
        );
    }
}
