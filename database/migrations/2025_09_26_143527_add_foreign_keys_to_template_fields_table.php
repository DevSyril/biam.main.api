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
        Schema::table('template_fields', function (Blueprint $table) {
            $table->foreign(['field_id'], 'template_fields_field_id_fkey')->references(['id'])->on('form_fields')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['section_id'], 'template_fields_section_id_fkey')->references(['id'])->on('template_sections')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['template_id'], 'template_fields_template_id_fkey')->references(['id'])->on('templates')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('template_fields', function (Blueprint $table) {
            $table->dropForeign('template_fields_field_id_fkey');
            $table->dropForeign('template_fields_section_id_fkey');
            $table->dropForeign('template_fields_template_id_fkey');
        });
    }
};
