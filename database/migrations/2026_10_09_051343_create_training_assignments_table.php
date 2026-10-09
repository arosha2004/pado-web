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
        Schema::create('training_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('training_version_id')->constrained()->cascadeOnDelete();
            $table->dateTime('assigned_at')->nullable();
            $table->dateTime('deadline_at')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->unsignedBigInteger('last_section_id')->nullable();
            $table->dateTime('lesson_completed_at')->nullable();
            $table->string('status')->default('not_started');
            $table->text('reason')->nullable();
            $table->foreignId('actor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'training_version_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_assignments');
    }
};
