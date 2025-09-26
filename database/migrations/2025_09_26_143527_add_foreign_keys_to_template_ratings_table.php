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
        Schema::table('template_ratings', function (Blueprint $table) {
            $table->foreign(['template_id'], 'template_ratings_template_id_fkey')->references(['id'])->on('templates')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['user_id'], 'template_ratings_user_id_fkey')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('template_ratings', function (Blueprint $table) {
            $table->dropForeign('template_ratings_template_id_fkey');
            $table->dropForeign('template_ratings_user_id_fkey');
        });
    }
};
