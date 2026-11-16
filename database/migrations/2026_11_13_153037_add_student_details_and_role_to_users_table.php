
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
            $table->string('role')->default('student');

            $table->string('matric_number')->nullable()->unique();

            $table->string('department')->nullable();

            $table->string('faculty')->nullable();

            $table->string('phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['matric_number']);

            $table->dropColumn([
                'role',
                'matric_number',
                'department',
                'faculty',
                'phone',
            ]);
        });
    }
};
