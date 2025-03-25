<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Confirmation;

class ConfirmationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Confirmation::updateOrCreate(   
            ['name' => 'Yes'],
            ['name' => 'Yes'],
        );
        Confirmation::updateOrCreate(   
            ['name' => 'No'],
            ['name' => 'No'],
        );
    }
}
