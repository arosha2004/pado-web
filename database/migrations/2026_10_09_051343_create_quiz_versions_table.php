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
        Schema::create('quiz_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_version_id')->constrained('training_versions')->cascadeOnDelete();
            $table->string('title');
            $table->unsignedInteger('pass_threshold')->default(80);
            $table->unsignedInteger('max_attempts')->default(3);
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
        Schema::dropIfExists('quiz_versions');
    }
};
