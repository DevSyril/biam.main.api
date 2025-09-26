<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->jsonb('content')->default('{}');
            $table->integer('version')->nullable()->default(1);
            $table->boolean('is_premium')->nullable()->default(false);
            $table->boolean('is_active')->nullable()->default(true);
            $table->boolean('is_public')->nullable()->default(false);
            $table->uuid('author_id')->nullable()->index('idx_templates_author');
            $table->string('language', 10)->nullable()->default('fr');
            $table->string('preview_url', 500)->nullable();
            $table->integer('estimated_time_minutes')->nullable();
            $table->integer('usage_count')->nullable()->default(0);
            $table->timestampTz('created_at')->nullable()->useCurrent();
            $table->timestampTz('updated_at')->nullable()->useCurrent();
        });
        DB::statement("alter table \"templates\" add column \"category\" document_category not null");
        DB::statement("alter table \"templates\" add column \"type\" document_type not null");
        DB::statement("create index \"idx_templates_category\" on \"templates\" (\"category\")");
        DB::statement("create index \"idx_templates_type\" on \"templates\" (\"type\")");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
