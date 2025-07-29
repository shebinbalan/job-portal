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
    Schema::table('certificates', function (Blueprint $table) {
        $table->foreignId('seeker_id')
      ->nullable()
      ->constrained('users')
      ->onDelete('cascade')
      ->after('id');
    });
}

public function down(): void
{
    Schema::table('certificates', function (Blueprint $table) {
        $table->dropForeign(['seeker_id']);
        $table->dropColumn('seeker_id');
    });
}
};
