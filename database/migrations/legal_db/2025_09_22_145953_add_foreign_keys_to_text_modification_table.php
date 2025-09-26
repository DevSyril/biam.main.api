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
        Schema::connection('pgsql_secondary')->table('text_modification', function (Blueprint $table) {
            $table->foreign(['source_article_id'], 'text_modification_source_article_id_fkey')->references(['id'])->on('article')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['target_article_id'], 'text_modification_target_article_id_fkey')->references(['id'])->on('article')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql_secondary')->table('text_modification', function (Blueprint $table) {
            $table->dropForeign('text_modification_source_article_id_fkey');
            $table->dropForeign('text_modification_target_article_id_fkey');
        });
    }
};
