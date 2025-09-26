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
        Schema::connection('pgsql_secondary')->table('jurisprudence', function (Blueprint $table) {
            $table->foreign(['linked_article_id'], 'jurisprudence_linked_article_id_fkey')->references(['id'])->on('article')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['linked_subject_id'], 'jurisprudence_linked_subject_id_fkey')->references(['id'])->on('legal_subject')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql_secondary')->table('jurisprudence', function (Blueprint $table) {
            $table->dropForeign('jurisprudence_linked_article_id_fkey');
            $table->dropForeign('jurisprudence_linked_subject_id_fkey');
        });
    }
};
