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
        Schema::create('templates', function (Blueprint $table) {
            $table->uuid('id')->default('uuid_generate_v4()')->primary();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('version')->nullable()->default(1);
            $table->boolean('is_premium')->nullable()->default(false);
            $table->boolean('is_active')->nullable()->default(true);
            $table->boolean('is_public')->nullable()->default(true);
            $table->uuid('author_id')->nullable();
            $table->string('language', 10)->nullable()->default('fr');
            $table->integer('estimated_time_minutes')->nullable();
            $table->integer('usage_count')->nullable()->default(0);
            $table->timestampTz('created_at')->nullable()->useCurrent();
            $table->timestampTz('updated_at')->nullable()->useCurrent();
            $table->uuid('document_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
