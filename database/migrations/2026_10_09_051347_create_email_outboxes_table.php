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
        Schema::create('email_outboxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notification_id')->nullable()->constrained('notifications')->nullOnDelete();
            $table->string('recipient_email');
            $table->string('subject');
            $table->longText('body');
            $table->string('status')->default('queued');
            $table->unsignedInteger('attempts')->default(0);
            $table->string('error_category')->nullable();
            $table->timestamp('next_attempt_at')->nullable();
            $table->string('dedup_key')->nullable();
            $table->timestamps();
            $table->unique('dedup_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_outboxes');
    }
};
