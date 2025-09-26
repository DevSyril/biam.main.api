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
        Schema::connection('pgsql_secondary')->create('text_modification', function (Blueprint $table) {
            $table->uuid('id')->default('uuid_generate_v4()')->primary();
            $table->uuid('source_article_id')->index('idx_text_modification_source');
            $table->uuid('target_article_id')->index('idx_text_modification_target');
            $table->enum('modification_type', ['Amendment', 'Partial_Repeal', 'Full_Repeal', 'Replacement']);
            $table->date('effective_date')->index('idx_text_modification_effective');
            $table->text('commentary')->nullable();
            $table->timestampTz('created_at')->nullable()->default(DB::raw("now()"));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql_secondary')->dropIfExists('text_modification');
    }
};
