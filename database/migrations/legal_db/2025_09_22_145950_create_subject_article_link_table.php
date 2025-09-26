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
        Schema::connection('pgsql_secondary')->create('subject_article_link', function (Blueprint $table) {
            $table->uuid('id')->default('uuid_generate_v4()')->primary();
            $table->uuid('subject_id')->index('idx_subject_article_subject');
            $table->uuid('article_id')->index('idx_subject_article_article');
            $table->smallInteger('relevance')->nullable();
            $table->text('context_commentary')->nullable();
            $table->text('usage_example')->nullable();
            $table->timestampTz('created_at')->nullable()->default(DB::raw("now()"));
            $table->timestampTz('updated_at')->nullable()->default(DB::raw("now()"));

            $table->unique(['subject_id', 'article_id'], 'subject_article_link_subject_id_article_id_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql_secondary')->dropIfExists('subject_article_link');
    }
};
