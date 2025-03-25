<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Religion;

class ReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Religion::updateOrCreate(   
            ['name' => 'None'],
            ['name' => 'None'],
        );
        Religion::updateOrCreate(
            ['name' => 'Roman Catholic'],
            ['name' => 'Roman Catholic'],
        );
        Religion::updateOrCreate(
            ['name' => 'Islam'],
            ['name' => 'Islam'],
        );
        Religion::updateOrCreate(
            ['name' => 'Iglesia ni Cristo'],
            ['name' => 'Iglesia ni Cristo'],
        );
        Religion::updateOrCreate(
            ['name' => 'Aglipay'],
            ['name' => 'Aglipay'],
        );
        Religion::updateOrCreate(
            ['name' => "Jehovah’s Witness"],
            ['name' => "Jehovah’s Witness"],
        );
        Religion::updateOrCreate(
            ['name' => 'United Methodists Church'],
            ['name' => 'United Methodists Church'],
        );
        Religion::updateOrCreate(
            ['name' => 'Tribal Religions'],
            ['name' => 'Tribal Religions'],
        );
        Religion::updateOrCreate(
            ['name' => 'Other'],
            ['name' => 'Other'],
        );
    }
}
