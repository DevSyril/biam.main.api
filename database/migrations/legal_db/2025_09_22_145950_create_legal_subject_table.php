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
        Schema::connection('pgsql_secondary')->create('legal_subject', function (Blueprint $table) {
            $table->uuid('id')->default('uuid_generate_v4()')->primary();
            $table->string('label', 300)->unique('legal_subject_label_key');
            $table->text('description')->nullable();
            $table->string('slug', 300)->index('idx_legal_subject_slug');
            $table->uuid('parent_id')->nullable()->index('idx_legal_subject_parent');
            $table->integer('level')->nullable()->default(1);
            $table->timestampTz('created_at')->nullable()->default(DB::raw("now()"));
            $table->timestampTz('updated_at')->nullable()->default(DB::raw("now()"));

            $table->unique(['slug'], 'legal_subject_slug_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql_secondary')->dropIfExists('legal_subject');
    }
};
