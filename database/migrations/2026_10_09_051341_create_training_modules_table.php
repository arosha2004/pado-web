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
        Schema::create('training_modules', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('topic');
            $table->text('objective');
            $table->string('job_group_target')->nullable();
            $table->unsignedInteger('duration_minutes')->default(10);
            $table->foreignId('linked_policy_version_id')->nullable()->constrained('policy_versions')->nullOnDelete();
            $table->unsignedBigInteger('quiz_version_id')->nullable();
            $table->string('state')->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_modules');
    }
};
