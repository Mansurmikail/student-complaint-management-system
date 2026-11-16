<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();

            // Student who submitted the complaint
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Complaint information
            $table->string('subject');
            $table->string('category');
            $table->text('description');

            // Complaint status
            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
