<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RelationshipToFamily;

class RelationshipToFamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RelationshipToFamily::updateOrCreate(   
            ['name' => 'Family Head'],
            ['name' => 'Family Head'],
        );
        RelationshipToFamily::updateOrCreate(   
            ['name' => 'Spouse'],
            ['name' => 'Spouse'],
        );
        RelationshipToFamily::updateOrCreate(   
            ['name' => 'Offspring'],
            ['name' => 'Offspring'],
        );
        RelationshipToFamily::updateOrCreate(   
            ['name' => 'Parent'],
            ['name' => 'Parent'],
        );
        RelationshipToFamily::updateOrCreate(   
            ['name' => 'Sibling'],
            ['name' => 'Sibling'],
        );
        RelationshipToFamily::updateOrCreate(   
            ['name' => 'Nephew/Niece'],
            ['name' => 'Nephew/Niece'],
        );
        RelationshipToFamily::updateOrCreate(   
            ['name' => 'Uncle/Aunt'],
            ['name' => 'Uncle/Aunt'],
        );
        RelationshipToFamily::updateOrCreate(   
            ['name' => 'Cousin'],
            ['name' => 'Cousin'],
        );
        RelationshipToFamily::updateOrCreate(   
            ['name' => 'Grandparent'],
            ['name' => 'Grandparent'],
        );
        RelationshipToFamily::updateOrCreate(   
            ['name' => 'Son/Daughter-in-Law'],
            ['name' => 'Son/Daughter-in-Law'],
        );
        RelationshipToFamily::updateOrCreate(   
            ['name' => 'Brother/Sister-in-Law'],
            ['name' => 'Brother/Sister-in-Law'],
        );
        RelationshipToFamily::updateOrCreate(   
            ['name' => 'Grandchild'],
            ['name' => 'Grandchild'],
        );
        RelationshipToFamily::updateOrCreate(   
            ['name' => 'Father/Mother-in-Law'],
            ['name' => 'Father/Mother-in-Law'],
        );
        RelationshipToFamily::updateOrCreate(   
            ['name' => 'Other'],
            ['name' => 'Other'],
        );
    }
}
