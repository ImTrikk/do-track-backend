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
            // Modify the column type or add other changes you need
            $table->string('admin_id')->change();
            $table->unique('admin_id', 'admins_admin_id_unique');
        });

        // Comment out or remove the attempt to add the unique constraint
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            // Reverse the changes made in the 'up' method
            $table->string('admin_id')->change();
        });
    }
};
