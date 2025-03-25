<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CodeSkill;

class CodeSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CodeSKill::updateOrCreate(   
            ['name' => 'Agricultural Crop Production'],
            ['name' => 'Agricultural Crop Production'],
        );
        CodeSKill::updateOrCreate(   
            ['name' => 'Animal Health Care'],
            ['name' => 'Animal Health Care'],
        );
        CodeSKill::updateOrCreate(   
            ['name' => 'Animal Production'],
            ['name' => 'Animal Production'],
        );
        CodeSKill::updateOrCreate(   
            ['name' => 'Automotive Servicing'],
            ['name' => 'Automotive Servicing'],
        );
        CodeSKill::updateOrCreate(   
            ['name' => 'Barangay Health Services'],
            ['name' => 'Barangay Health Services'],
        );
        CodeSKill::updateOrCreate(   
            ['name' => 'Bartending'],
            ['name' => 'Bartending'],
        );
        CodeSKill::updateOrCreate(   
            ['name' => 'Beauty Care'],
            ['name' => 'Beauty Care'],
        );
        CodeSKill::updateOrCreate(   
            ['name' => 'Bookkeeping'],
            ['name' => 'Bookkeeping'],
        );
        CodeSKill::updateOrCreate(   
            ['name' => 'Bread and Pastry Production'],
            ['name' => 'Bread and Pastry Production'],
        );
        CodeSKill::updateOrCreate(   
            ['name' => 'Carpentry'],
            ['name' => 'Carpentry'],
        );
        CodeSKill::updateOrCreate(   
            ['name' => 'Commercial Cooking'],
            ['name' => 'Commercial Cooking'],
        );
        CodeSKill::updateOrCreate(   
            ['name' => 'Construction'],
            ['name' => 'Construction'],
        );
        CodeSKill::updateOrCreate(   
            ['name' => 'Electronics'],
            ['name' => 'Electronics'],
        );
        CodeSKill::updateOrCreate(   
            ['name' => 'Dressmaking/ Garments'],
            ['name' => 'Dressmaking/ Garments'],
        );
        CodeSKill::updateOrCreate(   
            ['name' => 'Driving'],
            ['name' => 'Driving'],
        );
        CodeSKill::updateOrCreate(   
            ['name' => 'Farming'],
            ['name' => 'Farming'],
        );
        CodeSKill::updateOrCreate(   
            ['name' => 'Fishing'],
            ['name' => 'Fishing'],
        );
        CodeSKill::updateOrCreate(   
            ['name' => 'Food Production and Processing'],
            ['name' => 'Food Production and Processing'],
        );
        CodeSKill::updateOrCreate(   
            ['name' => 'Furniture and Fixtures'],
            ['name' => 'Furniture and Fixtures'],
        );
        CodeSKill::updateOrCreate(   
            ['name' => 'Heat Ventilation and Air-Conditioning'],
            ['name' => 'Heat Ventilation and Air-Conditioning'],
        );
        CodeSKill::updateOrCreate(   
            ['name' => 'Health, Social, and Other Community Services'],
            ['name' => 'Health, Social, and Other Community Services'],
        );
        CodeSKill::updateOrCreate(   
            ['name' => 'Household Services'],
            ['name' => 'Household Services'],
        );
        CodeSKill::updateOrCreate(   
            ['name' => 'Information Technology'],
            ['name' => 'Information Technology'],
        );
        CodeSKill::updateOrCreate(   
            ['name' => 'Machine Operation'],
            ['name' => 'Machine Operation'],
        );
        CodeSKill::updateOrCreate(   
            ['name' => 'Metals and Engineering'],
            ['name' => 'Metals and Engineering'],
        );
        CodeSKill::updateOrCreate(   
            ['name' => 'Plumbing'],
            ['name' => 'Plumbing'],
        );
        CodeSKill::updateOrCreate(   
            ['name' => 'Tourism Promotion Services'],
            ['name' => 'Tourism Promotion Services'],
        );
        CodeSKill::updateOrCreate(   
            ['name' => 'Other'],
            ['name' => 'Other'],
        );
    }
}
