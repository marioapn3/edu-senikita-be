<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('final_submissions', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->dropColumn('course_id');
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('final_submissions', function (Blueprint $table) {
            $table->dropForeign(['lesson_id']);
            $table->dropColumn('lesson_id');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
        });
    }
};
