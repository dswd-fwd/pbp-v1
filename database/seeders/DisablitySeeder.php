<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Disability;

class DisablitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Disability::updateOrCreate(   
            ['name' => 'None'],
            ['name' => 'None'],
        );
        Disability::updateOrCreate(   
            ['name' => 'Physical'],
            ['name' => 'Physical'],
        );
        Disability::updateOrCreate(   
            ['name' => 'Intellectual'],
            ['name' => 'Intellectual'],
        );
        Disability::updateOrCreate(   
            ['name' => 'Learning'],
            ['name' => 'Learning'],
        );
        Disability::updateOrCreate(   
            ['name' => 'Visual'],
            ['name' => 'Visual'],
        );
        Disability::updateOrCreate(   
            ['name' => 'Mental'],
            ['name' => 'Mental'],
        );
        Disability::updateOrCreate(   
            ['name' => 'Psychosocial'],
            ['name' => 'Psychosocial'],
        );
        Disability::updateOrCreate(   
            ['name' => 'Deaf/Hard of Hearing'],
            ['name' => 'Deaf/Hard of Hearing'],
        );
        Disability::updateOrCreate(   
            ['name' => 'Speech and Language impairment'],
            ['name' => 'Speech and Language impairment'],
        );
        Disability::updateOrCreate(   
            ['name' => 'Cancer'],
            ['name' => 'Cancer'],
        );
        Disability::updateOrCreate(   
            ['name' => 'Rare Disease'],
            ['name' => 'Rare Disease'],
        );
        Disability::updateOrCreate(   
            ['name' => 'Other'],
            ['name' => 'Other'],
        );
    }
}
