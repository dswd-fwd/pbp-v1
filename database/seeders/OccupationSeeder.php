<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Occupation;

class OccupationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Occupation::updateOrCreate(   
            ['name' => 'Special Occupations'],
            ['name' => 'Special Occupations'],
        );
        Occupation::updateOrCreate(   
            ['name' => 'Officials of government & special interest orgs, corp. executive, manager, managing proprietor/supervisor'],
            ['name' => 'Officials of government & special interest orgs, corp. executive, manager, managing proprietor/supervisor'],
        );
        Occupation::updateOrCreate(   
            ['name' => 'Professionals'],
            ['name' => 'Professionals'],
        );
        Occupation::updateOrCreate(   
            ['name' => 'Technicians & Assoc. Professionals'],
            ['name' => 'Technicians & Assoc. Professionals'],
        );
        Occupation::updateOrCreate(   
            ['name' => 'Clerks'],
            ['name' => 'Clerks'],
        );
        Occupation::updateOrCreate(   
            ['name' => 'Service worker/shop & market worker'],
            ['name' => 'Service worker/shop & market worker'],
        );
        Occupation::updateOrCreate(   
            ['name' => 'Farmers, forestry worker & fishermen'],
            ['name' => 'Farmers, forestry worker & fishermen'],
        );
        Occupation::updateOrCreate(   
            ['name' => 'Craft and related trade workers'],
            ['name' => 'Craft and related trade workers'],
        );
        Occupation::updateOrCreate(   
            ['name' => 'Plant/machine operator & assembler'],
            ['name' => 'Plant/machine operator & assembler'],
        );
        Occupation::updateOrCreate(   
            ['name' => 'Laborers & unskilled workers'],
            ['name' => 'Laborers & unskilled workers'],
        );
        Occupation::updateOrCreate(   
            ['name' => 'Other'],
            ['name' => 'Other'],
        );
    }
}
