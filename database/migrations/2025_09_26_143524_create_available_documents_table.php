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
        Schema::create('available_documents', function (Blueprint $table) {
            $table->uuid('id')->default('uuid_generate_v4()')->primary();
            $table->string('name', 300)->unique('available_documents_name_key');
            $table->text('description')->nullable();
            $table->timestampTz('created_at')->nullable()->useCurrent();
            $table->timestampTz('updated_at')->nullable()->useCurrent();
        });
        DB::statement("alter table \"available_documents\" add column \"category\" document_category not null");
        DB::statement("alter table \"available_documents\" add column \"type\" document_type not null");
        DB::statement("create index \"idx_available_docs_category\" on \"available_documents\" (\"category\")");
        DB::statement("create index \"idx_available_docs_type\" on \"available_documents\" (\"type\")");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('available_documents');
    }
};
