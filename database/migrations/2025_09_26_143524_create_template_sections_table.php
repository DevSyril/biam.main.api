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
        Schema::create('template_sections', function (Blueprint $table) {
            $table->uuid('id')->default('uuid_generate_v4()')->primary();
            $table->uuid('template_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('section_order');
            $table->string('legal_slug', 100)->nullable();
            $table->boolean('is_required')->nullable()->default(false);
            $table->boolean('is_repeatable')->nullable()->default(false);
            $table->timestampTz('created_at')->nullable()->useCurrent();
            $table->timestampTz('updated_at')->nullable()->useCurrent();

            $table->unique(['template_id', 'section_order'], 'template_sections_template_id_section_order_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_sections');
    }
};
