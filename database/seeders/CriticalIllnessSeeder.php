<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CriticalIllness;

class CriticalIllnessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CriticalIllness::updateOrCreate(   
            ['name' => 'None'],
            ['name' => 'None'],
        );
        CriticalIllness::updateOrCreate(   
            ['name' => 'Cancer'],
            ['name' => 'Cancer'],
        );
        CriticalIllness::updateOrCreate(   
            ['name' => 'Cardiac Arrest'],
            ['name' => 'Cardiac Arrest'],
        );
        CriticalIllness::updateOrCreate(   
            ['name' => 'Coma'],
            ['name' => 'Coma'],
        );
        CriticalIllness::updateOrCreate(   
            ['name' => 'Paralysis'],
            ['name' => 'Paralysis'],
        );
        CriticalIllness::updateOrCreate(   
            ['name' => 'Organ Failure'],
            ['name' => 'Organ Failure'],
        );
        CriticalIllness::updateOrCreate(   
            ['name' => 'Other'],
            ['name' => 'Other'],
        );
    }
}
