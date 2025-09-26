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
        Schema::connection('pgsql_secondary')->create('article', function (Blueprint $table) {
            $table->uuid('id')->default('uuid_generate_v4()')->primary();
            $table->uuid('legal_text_id')->index('idx_article_legal_text');
            $table->string('article_number', 100)->index('idx_article_number');
            $table->string('article_title', 500)->nullable();
            $table->text('content');
            $table->boolean('is_modified')->nullable()->default(false);
            $table->boolean('is_abrogated')->nullable()->default(false)->index('idx_article_abrogated');
            $table->text('commentary')->nullable();
            $table->integer('display_order')->nullable();
            $table->timestampTz('created_at')->nullable()->default(DB::raw("now()"));
            $table->timestampTz('updated_at')->nullable()->default(DB::raw("now()"));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql_secondary')->dropIfExists('article');
    }
};
