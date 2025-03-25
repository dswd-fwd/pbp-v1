<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CivilStatus;

class CivilStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CivilStatus::updateOrCreate(   
            ['name' => 'Single'],
            ['name' => 'Single'],
        );
        CivilStatus::updateOrCreate(   
            ['name' => 'Maried'],
            ['name' => 'Maried'],
        );
        CivilStatus::updateOrCreate(   
            ['name' => 'Cohabitation (Live-in/Common-Law)'],
            ['name' => 'Cohabitation (Live-in/Common-Law)'],
        );
        CivilStatus::updateOrCreate(   
            ['name' => 'Divorced'],
            ['name' => 'Divorced'],
        );
        CivilStatus::updateOrCreate(   
            ['name' => 'Separated'],
            ['name' => 'Separated'],
        );
        CivilStatus::updateOrCreate(   
            ['name' => 'Widowed'],
            ['name' => 'Widowed'],
        );
    }
}
