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
        Schema::table('template_tags', function (Blueprint $table) {
            $table->foreign(['tag_id'], 'template_tags_tag_id_fkey')->references(['id'])->on('tags')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['template_id'], 'template_tags_template_id_fkey')->references(['id'])->on('templates')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('template_tags', function (Blueprint $table) {
            $table->dropForeign('template_tags_tag_id_fkey');
            $table->dropForeign('template_tags_template_id_fkey');
        });
    }
};
