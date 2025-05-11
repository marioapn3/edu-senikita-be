<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_quiz_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_quiz_attempt_id')->constrained()->onDelete('cascade');
            $table->foreignId('quiz_question_id')->constrained()->onDelete('cascade');
            $table->foreignId('quiz_answer_id')->constrained()->onDelete('cascade');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_quiz_answers');
    }
};
