<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExtensionName;

class ExtensionNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExtensionName::updateOrCreate(
            ['name' => 'Jr.'],
            ['name' => 'Jr.']
        );
        ExtensionName::updateOrCreate(
            ['name' => 'Sr.'],
            ['name' => 'Sr.']
        );
        ExtensionName::updateOrCreate(
            ['name' => 'I'],
            ['name' => 'I']
        );
        ExtensionName::updateOrCreate(
            ['name' => 'II'],
            ['name' => 'II']
        );
        ExtensionName::updateOrCreate(
            ['name' => 'III'],
            ['name' => 'III']
        );
        ExtensionName::updateOrCreate(
            ['name' => 'n/a'],
            ['name' => 'n/a']
        );
    }
}
