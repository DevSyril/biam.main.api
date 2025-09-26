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
        Schema::create('generated_documents', function (Blueprint $table) {
            $table->uuid('id')->default('uuid_generate_v4()')->primary();
            $table->string('title');
            $table->uuid('template_id')->index('idx_generated_template');
            $table->uuid('user_id')->index('idx_generated_user');
            $table->jsonb('form_data')->default('{}');
            $table->string('file_path', 500)->nullable();
            $table->integer('file_size')->nullable();
            $table->integer('download_count')->nullable()->default(0);
            $table->timestampTz('expiry_date')->nullable();
            $table->string('download_token')->nullable()->unique('generated_documents_download_token_key');
            $table->timestampTz('created_at')->nullable()->useCurrent();
            $table->timestampTz('updated_at')->nullable()->useCurrent();
            $table->timestampTz('completed_at')->nullable();
        });
        DB::statement("alter table \"generated_documents\" add column \"status\" generation_status null default 'draft'");
        DB::statement("create index \"idx_generated_status\" on \"generated_documents\" (\"status\")");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generated_documents');
    }
};
