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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('role')->default('member');
            $table->foreignId('extension_name_id')->nullable();
            $table->foreignId('refregion_id')->nullable();
            $table->foreignId('refprovince_id')->nullable();
            $table->foreignId('refcitymun_id')->nullable();
            $table->foreignId('refbrgy_id')->nullable();
            $table->boolean('pantawid_member')->nullable();
            $table->boolean('slp_beneficiary')->nullable();
            $table->string('household_id_number')->nullable();
            $table->string('contact_number')->nullable();
            $table->foreignId('civil_status_id')->nullable();
            $table->foreignId('religion_id')->nullable();
            $table->string('religion_other')->nullable();
            $table->foreignId('i_p_membership_id')->nullable();
            $table->string('i_p_membership_other')->nullable();
            $table->boolean('head_of_the_family')->nullable();
            $table->date('birth')->nullable();
            $table->string('sex')->nullable();
            $table->foreignId('h_e_a_id')->nullable();
            $table->foreignId('occupation_id')->nullable();
            $table->string('occupation_other')->nullable();
            $table->foreignId('occupation_class_id')->nullable();
            $table->foreignId('disability_id')->nullable();
            $table->foreignId('critical_illness_id')->nullable();
            $table->string('critical_illness_other')->nullable();
            $table->foreignId('family_member_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
