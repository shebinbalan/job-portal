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
        Schema::create('job_applications', function (Blueprint $table) {
    $table->id();

    $table->foreignId('user_id')
          ->constrained('users')
          ->onDelete('cascade');

    $table->foreignId('job_id')
          ->constrained('job_posts')
          ->onDelete('cascade');

    $table->string('resume_path');
    $table->text('cover_letter')->nullable();
    $table->enum('status', ['pending', 'reviewed', 'shortlisted', 'rejected'])->default('pending');
    $table->timestamps();

    // Optional: Add indexes for performance
    $table->index('user_id');
    $table->index('job_id');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
