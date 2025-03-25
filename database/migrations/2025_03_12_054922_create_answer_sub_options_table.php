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
        Schema::create('answer_sub_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('answer_option_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_option_id')->constrained()->onDelete('cascade');
            $table->text('other_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answer_sub_options');
    }
};
