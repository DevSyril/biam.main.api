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
        Schema::create('template_ratings', function (Blueprint $table) {
            $table->uuid('id')->default('uuid_generate_v4()')->primary();
            $table->uuid('template_id');
            $table->uuid('user_id');
            $table->integer('rating');
            $table->text('review')->nullable();
            $table->timestampTz('created_at')->nullable()->useCurrent();

            $table->unique(['template_id', 'user_id'], 'template_ratings_template_id_user_id_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_ratings');
    }
};
