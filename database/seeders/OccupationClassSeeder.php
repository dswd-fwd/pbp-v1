<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OccupationClass;

class OccupationClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OccupationClass::updateOrCreate(   
            ['name' => 'Not employed but looking for work in the past 3 months'],
            ['name' => 'Not employed but looking for work in the past 3 months'],
        );
        OccupationClass::updateOrCreate(   
            ['name' => 'Not employed and not looking for work in the past 3 months'],
            ['name' => 'Not employed and not looking for work in the past 3 months'],
        );
        OccupationClass::updateOrCreate(   
            ['name' => 'Self-employed'],
            ['name' => 'Self-employed'],
        );
        OccupationClass::updateOrCreate(   
            ['name' => 'Private Company Employee'],
            ['name' => 'Private Company Employee'],
        );
        OccupationClass::updateOrCreate(   
            ['name' => 'Government Employee'],
            ['name' => 'Government Employee'],
        );
        OccupationClass::updateOrCreate(   
            ['name' => 'Pensioner'],
            ['name' => 'Pensioner'],
        );
        OccupationClass::updateOrCreate(   
            ['name' => 'OFW'],
            ['name' => 'OFW'],
        );
        OccupationClass::updateOrCreate(   
            ['name' => 'Student'],
            ['name' => 'Student'],
        );
    }
}
