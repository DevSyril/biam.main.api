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
        Schema::connection('pgsql_secondary')->table('article', function (Blueprint $table) {
            $table->foreign(['legal_text_id'], 'article_legal_text_id_fkey')->references(['id'])->on('legal_text')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql_secondary')->table('article', function (Blueprint $table) {
            $table->dropForeign('article_legal_text_id_fkey');
        });
    }
};
