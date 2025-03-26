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
        Schema::create('other_source_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User association
            $table->string('source_category'); // This includes "Others, specify: {value}"
            $table->string('employment_last_six_months')->nullable(); // Yes/No
            $table->decimal('income_cash', 10, 2)->nullable();
            $table->string('income_kind')->nullable();
            $table->string('other_specify')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('other_source_answers');
    }
};
