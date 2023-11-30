<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->string('student_id')->unique();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('digital_sig_url', 255);
            $table->boolean('is_blocked');
        });

        // constraints
        Schema::table('students', function (Blueprint $table) {
            $table->string('year_level_code')->references('year_level_code')->on('year_levels')->onDelete('cascade');
            $table->string('program_id')->references('program_id')->on('programs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
