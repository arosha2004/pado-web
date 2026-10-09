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
        Schema::create('training_sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('training_version_id');
            $table->unsignedInteger('order')->default(1);
            $table->string('title');
            $table->longText('content');
            $table->text('key_reminders')->nullable();
            $table->string('resource_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_sections');
    }
};
