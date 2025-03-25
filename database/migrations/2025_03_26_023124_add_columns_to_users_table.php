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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('code_skill_current_id')->nullable()->constrained('code_skills')->onDelete('cascade')->after('income_kind');
            $table->string('code_skill_current_other')->nullable()->after('code_skill_current_id');
            $table->foreignId('code_skill_acquire_id')->nullable()->constrained('code_skills')->onDelete('cascade')->after('code_skill_current_other');
            $table->string('code_skill_acquire_other')->nullable()->after('code_skill_acquire_id');
            $table->foreignId('reason_for_absence_id')->nullable()->constrained('reason_for_absences')->after('year_level');
            $table->string('remarks')->nullable()->after('code_skill_acquire_other');
            $table->boolean('certified')->nullable()->after('remarks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['code_skill_current_id']);
            $table->dropForeign(['code_skill_acquire_id']);
            $table->dropForeign(['reason_for_absence_id']);

    
            // Drop columns
            $table->dropColumn([
                'code_skill_current_id',
                'code_skill_current_other',
                'code_skill_acquire_id',
                'code_skill_acquire_other',
                'reason_for_absence_id',
                'remarks',
                'certified',
            ]);
        });
    }
};
