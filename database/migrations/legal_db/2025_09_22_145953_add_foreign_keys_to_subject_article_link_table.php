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
        Schema::connection('pgsql_secondary')->table('subject_article_link', function (Blueprint $table) {
            $table->foreign(['article_id'], 'subject_article_link_article_id_fkey')->references(['id'])->on('article')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['subject_id'], 'subject_article_link_subject_id_fkey')->references(['id'])->on('legal_subject')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql_secondary')->table('subject_article_link', function (Blueprint $table) {
            $table->dropForeign('subject_article_link_article_id_fkey');
            $table->dropForeign('subject_article_link_subject_id_fkey');
        });
    }
};
