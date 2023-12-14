<?php

use App\Models\College;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */

    protected $casts = [
        'admin_id' => 'string',
    ];

    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->string('admin_id')->unique();
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('email', 255);
            $table->string('password', 255);
            $table->string('position', 255);
            $table->timestamps();
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->foreignIdFor(College::class, 'college_id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
