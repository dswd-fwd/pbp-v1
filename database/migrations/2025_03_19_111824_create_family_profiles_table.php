<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('family_profiles', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('name');
            $table->foreignId('extension_name_id')->nullable()->constrained('extension_names');
            $table->string('sex');
            $table->foreignId('civil_status_id')->constrained('civil_statuses');
            $table->date('birth');
            $table->foreignId('relationship_to_family_id')->constrained('relationship_to_families');
            $table->string('relationship_to_family_other')->nullable();
            $table->foreignId('occupation_id')->nullable()->constrained('occupations');
            $table->string('occupation_other')->nullable();
            $table->foreignId('occupation_class_id')->nullable()->constrained('occupation_classes');
            $table->foreignId('disability_id')->nullable()->constrained('disabilities');
            $table->foreignId('critical_illness_id')->nullable()->constrained('critical_illnesses');
            $table->string('critical_illness_other')->nullable();
            $table->boolean('solo_parent');
            $table->foreignId('h_e_a_id')->nullable()->constrained('h_e_a_s');
            $table->boolean('attending_school')->nullable();
            $table->string('year_level')->nullable();
            $table->foreignId('reason_for_absence_id')->nullable()->constrained('reason_for_absences');
            $table->string('not_attending_school_reason')->nullable();
            $table->boolean('read_and_write')->nullable();
            $table->boolean('birth_registered')->nullable();
            $table->boolean('registered_voter')->nullable();
            $table->boolean('voted_last_six_years')->nullable();
            $table->boolean('has_internet_access')->nullable();
            $table->boolean('employment_last_six_months')->nullable();
            $table->integer('income_cash')->nullable();
            $table->integer('income_kind')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_profiles');
    }
};
