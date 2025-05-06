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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->boolean('certificate_available')->default(false);
            $table->string('thumbnail')->nullable();
            $table->string('slug')->unique();
            $table->enum('level', ['pemula', 'menengah', 'lanjutan'])->default('pemula');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->foreignId('instructor_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
