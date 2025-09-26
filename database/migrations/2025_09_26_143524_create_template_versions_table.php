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
        Schema::create('template_versions', function (Blueprint $table) {
            $table->uuid('id')->default('uuid_generate_v4()')->primary();
            $table->uuid('template_id');
            $table->integer('version_number');
            $table->jsonb('content');
            $table->text('change_description')->nullable();
            $table->uuid('created_by')->nullable();
            $table->timestampTz('created_at')->nullable()->useCurrent();

            $table->unique(['template_id', 'version_number'], 'template_versions_template_id_version_number_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_versions');
    }
};
