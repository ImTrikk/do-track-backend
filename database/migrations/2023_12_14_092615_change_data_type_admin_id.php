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
        Schema::table('admins', function (Blueprint $table) {
            // Change the data type of the column
            $table->string('admin_id')->change();
        });

        // Remove the attempt to add the unique constraint
        Schema::table('admins', function (Blueprint $table) {
            $table->dropUnique('admins_admin_id_unique');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) { });
    }
};