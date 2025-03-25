<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IPMembership;

class IPMembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IPMembership::updateOrCreate(   
            ['name' => 'Non-IP'],
            ['name' => 'Non-IP'],
        );
        IPMembership::updateOrCreate(   
            ['name' => 'Aeta'],
            ['name' => 'Aeta'],
        );
        IPMembership::updateOrCreate(   
            ['name' => 'Ati'],
            ['name' => 'Ati'],
        );
        IPMembership::updateOrCreate(   
            ['name' => 'Badjao'],
            ['name' => 'Badjao'],
        );
        IPMembership::updateOrCreate(   
            ['name' => 'Bago'],
            ['name' => 'Bago'],
        );
        IPMembership::updateOrCreate(   
            ['name' => 'Batak'],
            ['name' => 'Batak'],
        );
        IPMembership::updateOrCreate(   
            ['name' => 'Bukidnon'],
            ['name' => 'Bukidnon'],
        );
        IPMembership::updateOrCreate(   
            ['name' => 'B’laan'],
            ['name' => 'B’laan'],
        );
        IPMembership::updateOrCreate(   
            ['name' => 'Cimaron'],
            ['name' => 'Cimaron'],
        );
        IPMembership::updateOrCreate(   
            ['name' => 'Dumagat'],
            ['name' => 'Dumagat'],
        );
        IPMembership::updateOrCreate(   
            ['name' => 'Ibaloi'],
            ['name' => 'Ibaloi'],
        );
        IPMembership::updateOrCreate(   
            ['name' => 'Ibanag'],
            ['name' => 'Ibanag'],
        );
        IPMembership::updateOrCreate(   
            ['name' => 'Itom'],
            ['name' => 'Itom'],
        );
        IPMembership::updateOrCreate(   
            ['name' => 'Kankanaey'],
            ['name' => 'Kankanaey'],
        );
        IPMembership::updateOrCreate(   
            ['name' => 'Mandaya'],
            ['name' => 'Mandaya'],
        );
        IPMembership::updateOrCreate(   
            ['name' => 'Mangyan'],
            ['name' => 'Mangyan'],
        );
        IPMembership::updateOrCreate(   
            ['name' => 'Manobo'],
            ['name' => 'Manobo'],
        );
        IPMembership::updateOrCreate(   
            ['name' => 'Palawano'],
            ['name' => 'Palawano'],
        );
        IPMembership::updateOrCreate(   
            ['name' => 'Pullon'],
            ['name' => 'Pullon'],
        );
        IPMembership::updateOrCreate(   
            ['name' => 'Subanen'],
            ['name' => 'Subanen'],
        );
        IPMembership::updateOrCreate(   
            ['name' => 'Tagbanuas'],
            ['name' => 'Tagbanuas'],
        );
        IPMembership::updateOrCreate(   
            ['name' => 'Tau’t Bato'],
            ['name' => 'Tau’t Bato'],
        );
        IPMembership::updateOrCreate(   
            ['name' => 'Teduray'],
            ['name' => 'Teduray'],
        );
        IPMembership::updateOrCreate(   
            ['name' => 'T’boli'],
            ['name' => 'T’boli'],
        );
        IPMembership::updateOrCreate(   
            ['name' => 'Other'],
            ['name' => 'Other'],
        );
    }
}
