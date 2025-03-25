<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FamilyMember;

class FamilyMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FamilyMember::updateOrCreate(   
            ['name' => '1'],
            ['name' => '1'],
        );
        FamilyMember::updateOrCreate(   
            ['name' => '2'],
            ['name' => '2'],
        );
        FamilyMember::updateOrCreate(   
            ['name' => '3'],
            ['name' => '3'],
        );
        FamilyMember::updateOrCreate(   
            ['name' => '4'],
            ['name' => '4'],
        );
        FamilyMember::updateOrCreate(   
            ['name' => '5'],
            ['name' => '5'],
        );
        FamilyMember::updateOrCreate(   
            ['name' => '6'],
            ['name' => '6'],
        );
        FamilyMember::updateOrCreate(   
            ['name' => '7'],
            ['name' => '7'],
        );
        FamilyMember::updateOrCreate(   
            ['name' => '8'],
            ['name' => '8'],
        );
        FamilyMember::updateOrCreate(   
            ['name' => '9'],
            ['name' => '9'],
        );
        FamilyMember::updateOrCreate(   
            ['name' => '10'],
            ['name' => '10'],
        );
    }
}
