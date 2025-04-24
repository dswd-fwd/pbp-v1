<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Interviewer;
use Hidehalo\Nanoid\Client;
use Illuminate\Support\Str;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\{ReligionSeeder, CivilStatusSeeder, IPMembershipSeeder, DisablitySeeder, HEASeeder, OccupationSeeder, OccupationClassSeeder, CriticalIllnessSeeder, ConfirmationSeeder, ExtensionNameSeeder, FamilyMemberSeeder, RelationshipToFamilySeeder, ReasonForAbsenceSeeder, CodeSkillSeeder};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $client = new Client();
        User::updateOrCreate(
            ['email' => 'test@admin.com'],
            [
        
                'uuid' => now()->format('mdY') . '-' . strtoupper(Str::random(4)),
                'first_name' => 'Test',
                'last_name' => 'Admin',
                'role' => 'admin',
                'name' => 'Test Admin',
                'email' => 'test@admin.com',
                'password' => bcrypt('password'),
            ],
        );

        Interviewer::updateOrCreate(
            ['email' => "jbbarceta@dswd.gov.ph"],
            [
                'name' => "Jelie B Barceta",
                'uuid' => 'j3bb22t1',
            ]
        );
        Interviewer::updateOrCreate(
            ['email' => "fbalcancia@dswd.gov.ph"],
            [
                'name' => "Fredelyn B Alcancia",
                'uuid' => 'f3b3a65a',
            ]
        );
        Interviewer::updateOrCreate(
            ['email' => "agjbolotaolo@dswd.gov.ph"],
            [
                'name' => "Anne Grace Bolotaolo",
                'uuid' => 'cbdc4de3',
            ]
        );
        Interviewer::updateOrCreate(
            ['email' => "jmapolinario@dswd.gov.ph"],
            [
                'name' => "Jedidiah Apolinario",
                'uuid' => '6d62227a',
            ]
        );
        Interviewer::updateOrCreate(
            ['email' => "keataganap@dswd.gov.ph"],
            [
                'name' => "Kyrie Eleison Taganap",
                'uuid' => '7d30358c',
            ]
        );
        Interviewer::updateOrCreate(
            ['email' => "pjdmarinas@dswd.gov.ph"],
            [
                'name' => "Patrick Jay D Mariñas",
                'uuid' => 'aa21c68a',
            ]
        );


        $this->call([
            ReligionSeeder::class,
            CivilStatusSeeder::class,
            IPMembershipSeeder::class,
            DisablitySeeder::class,
            HEASeeder::class,
            OccupationSeeder::class,
            OccupationClassSeeder::class,
            CriticalIllnessSeeder::class,
            ConfirmationSeeder::class,
            ExtensionNameSeeder::class,
            FamilyMemberSeeder::class,
            RelationshipToFamilySeeder::class,
            ReasonForAbsenceSeeder::class,
            CodeSkillSeeder::class,
        ]);
    }
}
