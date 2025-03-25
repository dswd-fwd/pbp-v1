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
        Schema::table('family_profiles', function (Blueprint $table) {
            $table->foreignId('code_skill_current_id')->nullable()->constrained('code_skills')->onDelete('cascade')->after('income_kind');
            $table->string('code_skill_current_other')->nullable()->after('code_skill_current_id');
            $table->foreignId('code_skill_acquire_id')->nullable()->constrained('code_skills')->onDelete('cascade')->after('code_skill_current_other');
            $table->string('code_skill_acquire_other')->nullable()->after('code_skill_acquire_id');
            $table->string('remarks')->nullable()->after('code_skill_acquire_other');
            $table->boolean('certified')->nullable()->after('remarks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('family_profiles', function (Blueprint $table) {
            // Drop foreign key constraints first
            $table->dropForeign(['code_skill_current_id']);
            $table->dropForeign(['code_skill_acquire_id']);
    
            // Drop columns
            $table->dropColumn([
                'code_skill_current_id',
                'code_skill_current_other',
                'code_skill_acquire_id',
                'code_skill_acquire_other',
                'remarks',
                'certified',
            ]);
        });
    }
};
